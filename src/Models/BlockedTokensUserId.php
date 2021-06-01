<?php


namespace OnzaMe\JWT\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BlockedUser
 * @package OnzaMe\JWT\Models
 */
class BlockedTokensUserId extends Model
{
    protected $fillable = [
        'id',
        'expire_at'
    ];

    protected $dates = [
        'expire_at'
    ];
}
