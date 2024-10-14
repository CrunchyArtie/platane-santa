<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SantaRestriction
 *
 * @property-read \App\Models\User|null $santa
 * @property-read \App\Models\User $target
 * @method static \Illuminate\Database\Eloquent\Builder|SantaRestriction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SantaRestriction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SantaRestriction query()
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $santa_id
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|SantaRestriction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SantaRestriction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SantaRestriction whereSantaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SantaRestriction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SantaRestriction whereUserId($value)
 * @mixin \Eloquent
 */
class SantaRestriction extends Model
{
    use HasFactory;

    protected $fillable = ['santa_id', 'user_id'];

    public function santa()
    {
        return $this->belongsTo(User::class, 'santa_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
