<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-07 22:36
 */

namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Member\Member;

/**
 * Class SocialiteAuth.
 */
class SocialiteAuth extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'extra',
        'identification',
        'member_id',
        'state',
        'type',
    ];

    /**
     * @var string
     */
    protected $table = 'socialite_auth';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
