<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SMMout extends Model
{
    protected $table = 'smmout';

    protected $fillable = ['user_id', 'product_id', 'object_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    
    public function smmin()
    {
        return $this->hasMany('App\Models\SMMin','smmout_id');
    }

    public function scopeWithPosts($query, $user_id)
    {
        return $query->select(
                'smmout.*',
                'product.name as product_name',
                'product.photo_1',
                'product.retail_price',
                DB::raw('COUNT(smmout.product_id) as number_shared'),
                DB::raw('COUNT(sin.smmout_id) as view_clicks'),
                DB::raw(
                    
                    'SUM(op.order_price) as sales',
                    'SUM(op.quantity) as q'
                    )
            )
            
            ->join('product','smmout.product_id', '=', 'product.id')
            ->leftJoin('smmin as sin','sin.smmout_id','=','smmout.id')
            ->leftJoin('porder as pr','pr.id','=','sin.porder_id')
            // ->leftJoin('payment as py','py.id','=','pr.payment_id')
            ->leftJoin('orderproduct as op','op.porder_id','=','pr.id')
            ->where('smmout.user_id',$user_id)

                        // ->leftJoin('smmin as cv', function($smm){
            //     $smm->on('smmout.id', '=', 'cv.smmout_id')
            //         ->where('cv.response', '=', 'view');
            // })
            // ->leftJoin('smmin as cb', function($smm){
            //     $smm->on('smmout.id', '=', 'cb.smmout_id')
            //         ->where('cb.response', '=', 'buy');
            // })
            //->where(DB::raw('smmout.created_at >= date_sub(NOW(), INTERVAL '. $smm_min_duration .' hour)'))
            ->groupBy('smmout.product_id')
            ->orderBy('smmout.created_at','DESC')
            ->get();
    }

    public static function smmOuts($user_id="")
    {

        if ($user_id=="") {
            $user_id==Auth::user()->id;
        }
        // $product_lists= SMMout::where('user_id',$user_id)->lists('product_id')->all();
    
        $smmProducts=
         SMMout::join('product','smmout.product_id','=','product.id')
				->join('merchantproduct','merchantproduct.product_id','=','product.id')
				->join('merchant','merchantproduct.merchant_id','=','merchant.id')
                ->where('smmout.user_id',$user_id)
                
              
                ->select(
                        'smmout.*',
                        'product.name as product_name',
                        'product.photo_1',
                        'product.smm_selected as smm_selected',
                        'product.status as pstatus',
                        'merchant.status as mstatus'

                    )
          
                ->orderBy('smmout.created_at','DESC')
                ->get();
        return $smmProducts;
        foreach (array_unique($product_lists) as $pl) {
            try {
                
           
                      $result=
                      SMMout::join('product','smmout.product_id','=','product.id')
                ->leftJoin('smmin as sin','sin.smmout_id','=','smmout.id')
                ->leftJoin('porder as pr','pr.id','=','sin.porder_id')
                ->leftJoin('orderproduct as op','op.porder_id','=','pr.id')
                ->where('smmout.user_id',$user_id)
                ->where('smmout.product_id',$pl)
                ->where('product.id',$pl)
                ->where('op.product_id',$pl)
                ->select(
                        'smmout.*',
                        'product.name as product_name',
                        'product.photo_1',
                        
                        'op.quantity as q12',
                        DB::raw('
                            SUM(op.order_price) as sales,
                            SUM(op.quantity) as q,
                            COUNT(sin.id) as view_clicks,
                            COUNT(smmout.id) as shares,
                             case when product.discounted_price>0 then product.discounted_price ELSE product.retail_price end as retail_price

                            '

                    
                            )
                    )
                ->groupBy('smmout.product_id')
                ->orderBy('smmout.created_at','DESC')
                ->first();
                array_push($smmProducts, $result);
             } catch (\Exception $e) {
                return $e;
                //Do nothing 
                // return $e;
            }
        }

        return $smmProducts;       

    }
    public function scopeCheckIfMinDuration($query, $user_id, $smm_min_duration)
    {
        return $query->where('user_id', $user_id)
            ->where(DB::raw('created_at >= date_sub(NOW(), INTERVAL '. $smm_min_duration .' hour)'))
            ->count();
    }
}
