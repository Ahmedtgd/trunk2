<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';

    protected $fillable = [
        'vbanner_id',
        'bunting_id',
        'signboard_id',
        'id'
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Album
     */
    public function album()
    {
        return $this->belongsTo('App\Models\Album');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Signboard
     */
    public function signboard()
    {
        return $this->belongsTo('App\Models\Signboard','signboard_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo VBanner
     */
    public function vbanner()
    {
        return $this->belongsTo('App\Models\VBanner');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Signboard
     */
    public function bunting()
    {
        return $this->belongsTo('App\Models\Bunting');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Theme
     */
    public function theme()
    {
        return $this->belongsTo('App\Models\Theme');
    }

    public function profileproducts()
    {
        return $this->belongsToMany('App\Models\Product', 'profileproduct',
            'profile_id', 'product_id')->withTimestamps();
    }
}
