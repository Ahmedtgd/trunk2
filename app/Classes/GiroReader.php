<?php namespace App\Classes;

use DB;

class GiroReader
{
    protected $currency;

    public function __construct(){
        $this->currency = DB::table('currency')->select('code')->where('active' , '=', 1)->first();
    }

    protected function get_file($file)
    {
        if(!file_exists($file = storage_path("giro/{$file}"))){
            return false;
        }

        return $file;
    }


    /**
     * Get Giro Header
     * @param $file_name
     * @return array
     */
    public function get_header($file_path)
    {
        $giro =  file_get_contents($file_path);

        $header = substr($giro, 0, 480);

        if(strlen(trim(substr($header, $start=82, $length=8))) != 8){
            //I am using the date to check
            return false;
        }

        //variables
        $c_no = ltrim((trim(substr($header, $start=60, $length=20))) ,'0');
        $company_ac_no = substr($c_no, 0, 3)."-".substr($c_no, 3, 6)."-".substr($c_no, 6, 1);

        $t_date = trim(substr($header, $start=82, $length=8));
        $transaction_date = substr($t_date, 0, 2)."-".substr($t_date, 2, 2)."-".substr($t_date, 4, 4);

        return [
            'record_type'               => trim(substr($header, $start=0, $length=2)),
            'tape_id'                   => trim(substr($header, $start=2, $length=3)),
            'branch'                    => ltrim(trim(substr($header, $start=5,$length=5)), '0'),
            'company_cif'               => trim(substr($header, $start=10, $length=20)),
            'company_name'              => trim(substr($header, $start=30, $length=30)),
            'company_ac_no'             => $company_ac_no,
            'instruction'               => trim(substr($header, $start=80, $length=1)),
            'reversal_indicator'        => trim(substr($header, $start=81, $length=1)),
            'crediting_debiting_date'   => $transaction_date,
            'customer_ref_no'           => trim(substr($header, $start=130, $length=16))
        ];
    }


    /**
     * Get Giro Trailer
     * @param $file_name
     * @return array
     */
    public function get_trailer($file_path)
    {
        $giro =  file_get_contents($file_path);

        $trailer = substr($giro, -482); //return

        $count = (int) trim(substr($trailer, $start=10,$length=27));
        if(!$count){
            //I am using the date to check
            return false;
        }

        return [
            'record_type'               => trim(substr($trailer, $start=0, $length=2)),
            'total_count'               => ltrim(trim(substr($trailer, $start=2, $length=8)), '0'),
            'total_amount'              => $this->currency->code ." ".number_format(trim(substr($trailer, $start=10,$length=27))/100, 2),
        ];
    }


    /**
     * Get Giro Detail
     * @param $file_name
     */
    public function get_detail($file_path)
    {
        $detail = substr(file_get_contents($file_path), 480, -482);
        $details = [];
        $key = 0;


        $lines = explode("\n", $detail);

        foreach($lines as $index => $line)
        {
            //exclude first and last line
            if($index == 0 || $index == count($lines)-1) continue;

            //detail header
            if(strlen($line) == 481)
            {
                $key++;
                $details[$key]['invoice'] = [
                    'record_type'           => trim(substr($line, $start=0, $length=2)),
                    'account_no'            => trim(substr($line, $start=2, $length=20)),
                    'amount'                => $this->currency->code ." ".number_format(trim(substr($line, $start=21, $length=18))/100, 2),
                    'instruction'           => trim(substr($line, $start=39, $length=1)),
                    'new_ic_no'             => trim(substr($line, $start=40, $length=12)),
                    'old_ic_no'             => trim(substr($line, $start=52, $length=8)),
                    'txn'                   => trim(substr($line, $start=60, $length=20)),
                    'business_reg_no'       => trim(substr($line, $start=80, $length=20)),
                    'ref_no'                => trim(substr($line, $start=100, $length=20)),
                    'receiving_fi_id'       => trim(substr($line, $start=120, $length=9)),
                    'beneficiary_name'      => trim(substr($line, $start=129, $length=22)),
                    'police_army_id'        => trim(substr($line, $start=151, $length=20)),
                    'send_advice_via'       => trim(substr($line, $start=171, $length=1)),
                    'email'                 => trim(substr($line, $start=172, $length=50)),
                    'fax_no'                => trim(substr($line, $start=224, $length=24)),
                    'require_id_check'      => trim(substr($line, $start=247, $length=1)),
                    'url'                   => 'http://' . $_SERVER['SERVER_NAME'] . '/admin/general/giro-reader/detail/' . $key
                ];
            }
            else if(strlen($line) == 78)
            {
                $details[$key]['invoice_details'][] = [
                    'record_type'           => trim(substr($line, $start=0, $length=2)),
                    'description'           => trim(substr($line, $start=3, $length=78))
                ];
            }
        }

        return $details;
    }

    public function all($file_path)
    {
        $header = $this->get_header($file_path);
        $trailer =  $this->get_trailer($file_path);
        $details =  $this->get_detail($file_path);

        //failed
        if(!is_array($header) || !is_array($trailer)) return;

        return [
            'header'    => $header,
            'details'   => $details,
            'trailer'   => $trailer
        ];
    }
}