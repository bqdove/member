<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-05 15:26
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Member\Member;

/**
 * Class Group.
 */
class MemberGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'description',
        'flow_marketing',
        'icon',
        'identification',
        'name',
    ];

    /**
     * @var string
     */
    protected $table = 'member_groups';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_group_relations', 'group_id', 'member_id');
    }
}
