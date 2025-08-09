<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Payout
 *
 * @property int $id
 * @property int $affiliate_id
 * @property float $amount
 * @property string $status
 * @property string $method
 * @property array|null $payment_details
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property string|null $notes
 * @property string|null $transaction_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $affiliate
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Payout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereAffiliateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout pending()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout completed()

 * 
 * @mixin \Eloquent
 */
class Payout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'affiliate_id',
        'amount',
        'status',
        'method',
        'payment_details',
        'processed_at',
        'notes',
        'transaction_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Payout statuses.
     */
    public const STATUSES = [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    /**
     * Payout methods.
     */
    public const METHODS = [
        'bank_transfer' => 'Bank Transfer',
        'paypal' => 'PayPal',
        'e_wallet' => 'E-Wallet',
        'crypto' => 'Cryptocurrency',
    ];

    /**
     * Get the affiliate that owns the payout.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    /**
     * Scope a query to only include pending payouts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include completed payouts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Mark payout as completed.
     *
     * @param  string|null  $transactionId
     * @return bool
     */
    public function markAsCompleted($transactionId = null): bool
    {
        return $this->update([
            'status' => 'completed',
            'processed_at' => now(),
            'transaction_id' => $transactionId,
        ]);
    }

    /**
     * Mark payout as cancelled.
     *
     * @param  string|null  $reason
     * @return bool
     */
    public function markAsCancelled($reason = null): bool
    {
        $data = ['status' => 'cancelled'];
        
        if ($reason) {
            $data['notes'] = $reason;
        }

        return $this->update($data);
    }

    /**
     * Get status label.
     *
     * @return string
     */
    public function getStatusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * Get method label.
     *
     * @return string
     */
    public function getMethodLabel(): string
    {
        return self::METHODS[$this->method] ?? $this->method;
    }

    /**
     * Get formatted amount.
     *
     * @return string
     */
    public function getFormattedAmount(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}