<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price',
        'total',
        'status',
        'payment_method',
        'transaction_id',
        'sender_number',
        'payment_proof',
        'notes',
        'paid_at',
        'delivered_at',
        'download_token',
        'download_expires_at',
        'download_count',
        'last_download_at',
        'customer_email',
        'customer_name',
        'customer_phone',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'delivered_at' => 'datetime',
        'download_expires_at' => 'datetime',
        'last_download_at' => 'datetime',
        'download_count' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPaid(): bool
    {
        return $this->status === 'completed' || $this->status === 'processing';
    }

    public function isDelivered(): bool
    {
        return $this->status === 'delivered';
    }

    public function canAccessDownload(): bool
    {
        return $this->isPaid() && $this->product && $this->product->digital;
    }

    public function isDownloadExpired(): bool
    {
        return $this->download_expires_at && now()->isAfter($this->download_expires_at);
    }

    public function getRemainingDownloadDays(): ?int
    {
        if (! $this->download_expires_at) {
            return null;
        }

        $remaining = now()->diffInDays($this->download_expires_at, false);

        return max(0, $remaining);
    }

    public function incrementDownloadCount(): void
    {
        $this->increment('download_count');
        $this->update(['last_download_at' => now()]);
    }

    public function getDownloadStatus(): string
    {
        if (! $this->canAccessDownload()) {
            return 'unavailable';
        }

        if ($this->isDownloadExpired()) {
            return 'expired';
        }

        return 'available';
    }
}
