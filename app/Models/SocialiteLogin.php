<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialiteLogin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_user_id',
        'access_token',
        'refresh_token'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
