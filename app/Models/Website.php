<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Website extends Model
{
    protected $table = 'website';
    protected $guarded = [ 'id'];

    public function merchant()
    {
        return $this->belongsToMany('App\Models\Merchant','merchantwebsite','website_id','merchant_id');
    }

    public function station()
    {
        return $this->belongsToMany('App\Models\Station','stationwebsite','website_id','station_id');
    }


    public function getMeta()
    {
        return
            $websites =[
                "id" =>null,
                "name" => null,
                "description" => null,
                "url" => null,
                "type"=>null,
                "created_at" => null,
                "updated_at" => null];
    }

    public function store(Request $request){

        $website = new Website();
        $webRecords[] = ['name'=>null,'description'=>null,'url'=>null];//all website records
        $website_model[] =null;
        //loop on website
        $length = count($request->get('website'));

        //lets create a record
        if (!is_null($request->get('website'))) {
            foreach($request->get('website') as $url)
            {
                $webRecords[] = $this->collectWebsiteData('website','',$url); // every key has an arr except merchant_id
            }
        }

        //loop on social
        if (!is_null($request->get('social'))){
            $length = count($request->get('social'));//

            foreach($request->get('social') as $url)
            {
                $webRecords[] = $this->collectWebsiteData('socialmedia','',$url); // every key has an arr except merchant_id
            }
        }

        //loop on ecommerce
        if (!is_null($request->get('ecom_site'))) {
            $length = count($request->get('ecom_site'));//
            foreach($request->get('ecom_site') as $url)
            {
                $webRecords[] = $this->collectWebsiteData('ecommerce','',$url); // every key has an arr except merchant_id
            }
        }


        unset($webRecords[0]);

        foreach($webRecords as $websiteSingleRecord)
        {
            $website_model[] = $website->create($websiteSingleRecord);
        }

        unset($website_model[0]);

        return $website_model;
    }

    public function collectWebsiteData($type, $description, $url)
    {
        return $bank_data = [
            'name' => '',
            'type' => $type,
            'description' => $description,
            'url' => $url
        ];
    }

    public function UpdateWebsites($request)
    {
        $websiteRowId = count($request->get('website'));
        // dd($websiteRowId);
        if(!is_null($request->get('websiteRow'))) {
            for($i=0;$i<$websiteRowId;$i++)
            {
                if (!empty($request->get('website')[$i])) {
                    $website = Website::where('id',$request->get('websiteRow'))->first();
                    $website->url = $request->get('website')[$i];
                    $website->save();
                }
            }
        }


        $socialRowId = count($request->get('website'));
        if(! is_null($request->get('socialRow'))) {
            for($i=0;$i<$socialRowId;$i++)
            {
                if (!empty($request->get('social')[$i])) {
                    $website = Website::where('id',$request->get('socialRow'))->first();
                    $website->url = $request->get('social')[$i];
                    $website->save();
                }
            }
        }

        $ecom_siteRowId = count($request->get('ecom_site'));
        if(!is_null($request->get('ecom_siteRow'))) {
            for($i=0;$i<$ecom_siteRowId;$i++)
            {
                if (!empty($request->get('ecom_site')[$i]) && $request->get('ecom_site')[$i]) {
                    $website = Website::where('id',$request->get('ecom_siteRow'))->first();
                    $website->url = $request->get('ecom_site')[$i];
                    $website->save();
                }
            }
        }

        $websiteRowId = count($request->get('website'));
        $socialRowId = count($request->get('social'));
        $ecom_siteRowId = count($request->get('ecom_site'));

        for($i=0; $i< $websiteRowId; $i++)
        {
            $website = new Website();
            $website->name = 'website';
            $website->url = $request->get('website')[$i];
            $website->save();
        }

        for($i=0; $i< $socialRowId; $i++)
        {
            $website = new Website();
            $website->name = 'social';
            $website->url = $request->get('social')[$i];
            $website->save();
        }

        for($i=0; $i< $ecom_siteRowId; $i++) {
            $website = new Website();
            $website->name = 'ecom_site';
            $website->url = $request->get('ecom_site')[$i];
            $website->save();
        }
    }
}
