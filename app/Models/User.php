<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property string|null $referral_code
 * @property float $commission_rate
 * @property bool $is_active
 * @property string|null $bio
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Referral> $referrals
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Click> $clicks
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payout> $payouts
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereReferralCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'referral_code',
        'commission_rate',
        'is_active',
        'bio',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'commission_rate' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($user) {
            if ($user->role === 'affiliate' && !$user->referral_code) {
                $user->referral_code = static::generateUniqueReferralCode();
            }
        });
    }

    /**
     * Generate a unique referral code.
     *
     * @return string
     */
    protected static function generateUniqueReferralCode(): string
    {
        do {
            $code = 'EB' . strtoupper(Str::random(6));
        } while (static::where('referral_code', $code)->exists());
        
        return $code;
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is affiliate.
     *
     * @return bool
     */
    public function isAffiliate(): bool
    {
        return $this->role === 'affiliate';
    }

    /**
     * Get the referrals for the affiliate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class, 'affiliate_id');
    }

    /**
     * Get the clicks for the affiliate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class, 'affiliate_id');
    }

    /**
     * Get the payouts for the affiliate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payouts(): HasMany
    {
        return $this->hasMany(Payout::class, 'affiliate_id');
    }

    /**
     * Get completed referrals for the affiliate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function completedReferrals(): HasMany
    {
        return $this->referrals()->where('status', 'completed');
    }

    /**
     * Calculate total earnings for the affiliate.
     *
     * @return float
     */
    public function getTotalEarnings(): float
    {
        return $this->completedReferrals()->sum('commission_amount') ?: 0;
    }

    /**
     * Calculate pending earnings for the affiliate.
     *
     * @return float
     */
    public function getPendingEarnings(): float
    {
        return $this->referrals()->where('status', 'pending')->sum('commission_amount') ?: 0;
    }

    /**
     * Calculate total payouts for the affiliate.
     *
     * @return float
     */
    public function getTotalPayouts(): float
    {
        return $this->payouts()->where('status', 'completed')->sum('amount') ?: 0;
    }

    /**
     * Calculate available balance for payout.
     *
     * @return float
     */
    public function getAvailableBalance(): float
    {
        return $this->getTotalEarnings() - $this->getTotalPayouts();
    }
}