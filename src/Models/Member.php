<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-05 15:01
 */
namespace Notadd\Member\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Notadd\Foundation\Member\Member as BaseMember;

/**
 * Class Member.
 */
class Member extends BaseMember
{
    use SoftDeletes, Notifiable;

    /**
     * Founder role
     */
    const ROLE_FOUNDER = 'founder';

    /**
     * @var string
     */
    protected $table = 'members';

    /**
     * @var array
     */
    protected $fillable = [
        'avatar',
        'birthday',
        'email',
        'introduction',
        'name',
        'nickname',
        'password',
        'phone',
        'realname',
        'sex',
        'signature',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'birthday',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activate() {
        return $this->hasOne(MemberActivate::class, 'member_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function ban()
    {
        return $this->hasOne(MemberBan::class, 'member_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groups()
    {
        return $this->hasMany(MemberGroupRelation::class, 'member_id');
    }

    /**
     * @param $email
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Notadd\Member\Models\Member
     */
    public static function findByEmail($email)
    {
        return static::query()->where('email', $email)->first();
    }
}
