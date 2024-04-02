<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static lockForUpdate()
 */
class Boat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'slug',
        'user_id',
    ];

    #[\Override]
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
        ];
    }
}
