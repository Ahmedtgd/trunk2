<?php

namespace App\Http\Controllers\rn;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use App\Models\OAuth;
use FCM;
use Log;
class FireBaseController extends Controller
{

    public function notify()
    {
        $tokens=[
            "e_FFK2E5qHM:APA91bF3O0kvk5btcuEgGPLd3Xn-f8YUml3awWfAQhq7nUMo2z0e_-QtZ39bCh_qc3xIldfdTUrcfroGhfMg8eJuEWehZPLB_n4b4sSbDMQ8QzPFNq3Qscpoiys4eMNyJLE5gaKzqFl4"
        ];
        $ftokens=OAuth::whereNull("deleted_at")->
         whereNotNull("ftoken")->select("ftoken")->
         get();

        Log::debug($ftokens);

        foreach ($ftokens as $f) {
            array_push($tokens,$f->ftoken);
        }

        return $this->process($tokens);
    }

    public function process($tokens)
    {   
        $title="OpenSupermall: Please update your app.";
        $data=[
            "image"=> "images/timeToUpdate-1080x675.jpg",
            "message"=>
                "Please update your Open app at Play Store by clicking the button below (you may need to uninstall first)",
            "action_type"=>"redirect",
            "app_url"=>"market://details?id=com.osmapp",
            "normal_url"=>"https://play.google.com/store/apps/details?id=com.osmapp",
            "app_version"=>"Caiman",
            "version_code"=>1,
            "AnotherActivity"=>
                "true",
            "title"=>
                'Urgent notification from OpenSupermall!',
            "onlyUpdate"=>
                "true"
        ];

        Log::debug($data);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setSound('default');
        $notificationBuilder->setBody("Update available.");

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($data);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        // You must change it to get your tokens
        // $tokens = MYDATABASE=>=>pluck('fcm_token')->toArray();
        $topic = new Topics();
        $topic->topic('app_update');
        $downstreamResponse = FCM::sendTo($tokens, $option,$notification, $data);
        dump($downstreamResponse);
    }
}
