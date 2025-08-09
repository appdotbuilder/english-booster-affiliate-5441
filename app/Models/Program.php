<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Program
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property string $duration
 * @property float $price
 * @property float|null $commission_rate
 * @property bool $is_active
 * @property array|null $features
 * @property string|null $image_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Referral> $referrals
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Click> $clicks
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Program newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program query()
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereFeatures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereImageUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program active()
 * @method static \Illuminate\Database\Eloquent\Builder|Program byType($type)

 * 
 * @mixin \Eloquent
 */
class Program extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'duration',
        'price',
        'commission_rate',
        'is_active',
        'features',
        'image_url',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'is_active' => 'boolean',
        'features' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Program types.
     */
    public const TYPES = [
        'online' => 'Online Programs',
        'offline' => 'Offline Programs (Pare)',
        'rombongan' => 'Rombongan Programs',
        'cabang' => 'Cabang Programs',
    ];

    /**
     * Get the referrals for the program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals(): HasMany
    {
        return $this->hasMany(Referral::class);
    }

    /**
     * Get the clicks for the program.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    /**
     * Scope a query to only include active programs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by program type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get the effective commission rate for this program.
     *
     * @param  float|null  $defaultRate
     * @return float
     */
    public function getEffectiveCommissionRate($defaultRate = null): float
    {
        return $this->commission_rate ?? $defaultRate ?? 10.00;
    }

    /**
     * Calculate commission amount for a given price.
     *
     * @param  float  $price
     * @param  float|null  $defaultRate
     * @return float
     */
    public function calculateCommission($price = null, $defaultRate = null): float
    {
        $price = $price ?? $this->price;
        $rate = $this->getEffectiveCommissionRate($defaultRate);
        
        return ($price * $rate) / 100;
    }

    /**
     * Get formatted price.
     *
     * @return string
     */
    public function getFormattedPrice(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get type label.
     *
     * @return string
     */
    public function getTypeLabel(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}