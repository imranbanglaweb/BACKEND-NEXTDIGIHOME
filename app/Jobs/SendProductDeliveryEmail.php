<?php

namespace App\Jobs;

use App\Models\ProductPurchase;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendProductDeliveryEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $purchase;

    public function __construct(ProductPurchase $purchase)
    {
        $this->purchase = $purchase->load('product');
    }

    public function handle(EmailService $emailService)
    {
        $emailService->sendProductDelivery($this->purchase);
    }
}