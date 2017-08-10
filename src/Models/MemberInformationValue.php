<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-10 14:55
 */
namespace Notadd\Member\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Notadd\Foundation\Database\Model;

/**
 * Class MemberInformationValue.
 */
class MemberInformationValue extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'information_id',
        'member_id',
        'value',
    ];

    /**
     * @var string
     */
    protected $table = 'member_information_values';
}
