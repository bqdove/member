<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-27 16:50
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;
use Notadd\Foundation\Member\Member;

/**
 * Class MemberGroup.
 */
class MemberGroupRelation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'end',
        'group_id',
        'member_id',
        'next',
        'type',
    ];

    /**
     * @var array
     */
    protected $setters = [
        'next' => 'empty|0',
        'type' => 'empty|default',
    ];

    /**
     * @var string
     */
    protected $table = 'member_group_relations';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(MemberGroup::class, 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
