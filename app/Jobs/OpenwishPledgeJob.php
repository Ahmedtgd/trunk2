<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\OpenWishPledge;
use Illuminate\Contracts\Bus\SelfHandling;
use Auth;

class OpenwishPledgeJob extends Job implements SelfHandling
{
    private $owpledge;

    /**
     * Create a new job instance.
     *
     * @param array $params
     */
    public function __construct ( $params = array () )
    {
        $this->owpledge = new OpenWishPledge();

        $this->owpledge->openwish_id = $params['openwish_id'];
        $this->owpledge->smedia_id = $params['smedia_id'];
        $this->owpledge->smedia_account = $params['smedia_account'];
        $this->owpledge->source_ip = $params['source_ip'];
        $this->owpledge->pledged_amt = $params['pledged_amt'];
        $this->owpledge->user_id =Auth::user()->id;
        // $this->owpledge->message=$params['message'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->owpledge->save()){
         
        }
    }
}
