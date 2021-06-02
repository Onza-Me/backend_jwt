<?php


namespace OnzaMe\JWT\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BlockedUser
 * @package OnzaMe\JWT\Models
 */
class BlockedTokensUserId extends Model
{
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'expire_at'
    ];

    protected $dates = [
        'expire_at'
    ];
}
