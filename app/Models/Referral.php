<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Referral
 *
 * @property int $id
 * @property int $affiliate_id
 * @property int $program_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string|null $customer_phone
 * @property string $status
 * @property float|null $commission_amount
 * @property float $commission_rate
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property string|null $notes
 * @property array|null $customer_data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $affiliate
 * @property-read \App\Models\Program $program
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Referral newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Referral newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Referral query()
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereAffiliateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereCustomerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereCommissionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereCustomerData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Referral completed()
 * @method static \Illuminate\Database\Eloquent\Builder|Referral pending()

 * 
 * @mixin \Eloquent
 */
class Referral extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'affiliate_id',
        'program_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
        'commission_amount',
        'commission_rate',
        'completed_at',
        'notes',
        'customer_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'commission_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'completed_at' => 'datetime',
        'customer_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Referral statuses.
     */
    public const STATUSES = [
        'pending' => 'Pending',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ];

    /**
     * Get the affiliate that owns the referral.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    /**
     * Get the program that owns the referral.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Scope a query to only include completed referrals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include pending referrals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Mark referral as completed.
     *
     * @return bool
     */
    public function markAsCompleted(): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        return $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Mark referral as cancelled.
     *
     * @return bool
     */
    public function markAsCancelled(): bool
    {
        if ($this->status === 'completed') {
            return false;
        }

        return $this->update([
            'status' => 'cancelled',
        ]);
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
     * Get formatted commission amount.
     *
     * @return string
     */
    public function getFormattedCommissionAmount(): string
    {
        if (!$this->commission_amount) {
            return 'Rp 0';
        }
        
        return 'Rp ' . number_format($this->commission_amount, 0, ',', '.');
    }
}