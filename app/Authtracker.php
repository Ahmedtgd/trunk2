<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Authtracker
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $status
 * @property string|null $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Authtracker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Authtracker whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Authtracker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Authtracker whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Authtracker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Authtracker whereUserId($value)
 * @mixin \Eloquent
 */
class Authtracker extends Model
{
    //
    protected $table = 'authtracker';
}
