<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('product_purchases', function (Blueprint $table) {
            $table->timestamp('access_starts_at')->nullable()->after('delivered_at');
            $table->timestamp('access_expires_at')->nullable()->after('access_starts_at');
            $table->timestamp('expiration_notification_sent_at')->nullable()->after('access_expires_at');
        });

        DB::table('product_purchases')
            ->join('products', 'product_purchases.product_id', '=', 'products.id')
            ->whereIn('product_purchases.status', ['completed', 'processing', 'delivered'])
            ->whereNull('product_purchases.access_starts_at')
            ->select([
                'product_purchases.id',
                'product_purchases.paid_at',
                'product_purchases.created_at',
                'products.validity_days',
            ])
            ->orderBy('product_purchases.id')
            ->chunkById(100, function ($purchases) {
                foreach ($purchases as $purchase) {
                    $startsAt = $purchase->paid_at ?: $purchase->created_at;
                    $expiresAt = $purchase->validity_days
                        ? \Carbon\Carbon::parse($startsAt)->addDays((int) $purchase->validity_days)
                        : null;

                    DB::table('product_purchases')
                        ->where('id', $purchase->id)
                        ->update([
                            'access_starts_at' => $startsAt,
                            'access_expires_at' => $expiresAt,
                            'download_expires_at' => $expiresAt,
                        ]);
                }
            }, 'product_purchases.id', 'id');
    }

    public function down()
    {
        Schema::table('product_purchases', function (Blueprint $table) {
            $table->dropColumn([
                'access_starts_at',
                'access_expires_at',
                'expiration_notification_sent_at',
            ]);
        });
    }
};
