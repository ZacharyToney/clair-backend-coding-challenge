<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PayItem
 *
 * @property int $id
 * @property string $amount
 * @property string $hours_worked
 * @property string $pay_rate
 * @property string $date
 * @property string $external_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read PayItem|null $business
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PayItemFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem whereHoursWorked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem wherePayRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PayItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PayItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'hours_worked',
        'pay_rate',
        'date',
        'external_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(PayItem::class);
    }
}
