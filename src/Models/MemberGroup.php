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
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $display_name
 * @property string              $icon
 * @property string              $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class MemberGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'description',
        'icon',
        'identification',
        'name',
    ];

    /**
     * @var string
     */
    protected $table = 'member_groups';

    /**
     * Many-to-Many relations with the member model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(Member::class, 'group_member', 'group_id', 'member_id');
    }
}
