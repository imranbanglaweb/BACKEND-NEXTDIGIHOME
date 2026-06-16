<?php

namespace App\Console\Commands;

use App\Mail\GenericMailable;
use App\Models\ProductPurchase;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyProductPurchaseExpirations extends Command
{
    protected $signature = 'product-purchases:notify-expiring {--days=7 : Notify purchases expiring within this many days}';

    protected $description = 'Send customer notifications for product purchases whose access validity is expiring soon.';

    public function handle(): int
    {
        $days = max(1, (int) $this->option('days'));
        $now = now();
        $until = now()->addDays($days)->endOfDay();
        $sent = 0;

        ProductPurchase::with(['product', 'user'])
            ->whereIn('status', ['completed', 'processing', 'delivered'])
            ->whereNotNull('access_expires_at')
            ->whereNull('expiration_notification_sent_at')
            ->whereBetween('access_expires_at', [$now, $until])
            ->orderBy('access_expires_at')
            ->chunkById(100, function ($purchases) use (&$sent) {
                foreach ($purchases as $purchase) {
                    $email = $purchase->customer_email ?: optional($purchase->user)->email;

                    if (! $email) {
                        Log::warning('Product expiration notification skipped: no customer email', [
                            'purchase_id' => $purchase->id,
                        ]);
                        continue;
                    }

                    try {
                        Mail::to($email)->send(new GenericMailable(
                            'Your product access expires soon',
                            $this->buildEmailBody($purchase),
                            $email,
                            url('/'),
                            'Visit Dashboard'
                        ));

                        $purchase->forceFill([
                            'expiration_notification_sent_at' => now(),
                        ])->save();

                        $sent++;
                    } catch (\Throwable $e) {
                        Log::error('Product expiration notification failed', [
                            'purchase_id' => $purchase->id,
                            'email' => $email,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });

        $this->info("Sent {$sent} product expiration notification(s).");

        return self::SUCCESS;
    }

    private function buildEmailBody(ProductPurchase $purchase): string
    {
        $productName = e(optional($purchase->product)->name ?: 'your product');
        $customerName = e($purchase->customer_name ?: optional($purchase->user)->name ?: 'Customer');
        $expiresAt = optional($purchase->access_expires_at)->format('d M Y');
        $remainingDays = $purchase->remaining_access_days;

        return '
            <h2>Product access expires soon</h2>
            <p>Hello '.$customerName.',</p>
            <p>Your access for <strong>'.$productName.'</strong> will expire on <strong>'.$expiresAt.'</strong>.</p>
            <p>Remaining validity: <strong>'.($remainingDays ?? 0).' day(s)</strong>.</p>
            <p>Please renew or contact support if you want to continue using this product after the expiry date.</p>
        ';
    }
}
