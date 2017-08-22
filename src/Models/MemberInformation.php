<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-04 18:39
 */
namespace Notadd\Member\Models;

use Notadd\Foundation\Database\Model;

/**
 * Class MemberInformation.
 */
class MemberInformation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'description',
        'details',
        'length',
        'name',
        'order',
        'opinions',
        'privacy',
        'register',
        'required',
        'type',
    ];

    /**
     * @var string
     */
    protected $table = 'member_informations';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(MemberInformationGroup::class, 'member_information_relations', 'information_id', 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(MemberInformationValue::class, 'information_id');
    }
}
