<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Click
 *
 * @property int $id
 * @property int $affiliate_id
 * @property int|null $program_id
 * @property string $ip_address
 * @property string|null $user_agent
 * @property string|null $referrer_url
 * @property string|null $landing_page
 * @property array|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $affiliate
 * @property-read \App\Models\Program|null $program
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Click newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Click newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Click query()
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereAffiliateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereReferrerUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereLandingPage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Click whereUpdatedAt($value)

 * 
 * @mixin \Eloquent
 */
class Click extends Model
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
        'ip_address',
        'user_agent',
        'referrer_url',
        'landing_page',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the affiliate that owns the click.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    /**
     * Get the program that was clicked.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}