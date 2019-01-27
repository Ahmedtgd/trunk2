<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\OpenWish;
use Illuminate\Contracts\Bus\SelfHandling;

class WishListJob extends Job implements SelfHandling
{
    protected $openWish;
    private static $_instance;

    /**
     * Create a new job instance.
     *
     * @param array $params
     * return void
     */
    public function __construct($params = array())
    {
        $this->openWish = new OpenWish();

        $this->openWish->product_id = $params['product_id'];
        $this->openWish->user_id = $params['user_id'];
        $this->openWish->status="pending";
        $this->openWish->save();
//        $this->openWish->link_id = $params['link_id'];
//        $this->openWish->save();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->openWish->save()){
            return $this->openWish;
        }
    }

    public static function getInstance($data = array())
    {
        if(self::$_instance == null){
            self::$_instance = new WishListJob($data);
        }
        return self::$_instance;
    }
}
