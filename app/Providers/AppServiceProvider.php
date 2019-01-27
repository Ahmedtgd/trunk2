<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use DB;
// use App\Http\Controllers\UtilityController;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Directive for standard id*/
        Blade::directive('standid',function($value){
            // return $value ."/"."hello";
            return "<php echo $value;?>";
            $limit=10;
            $pad='0';
            $l="[";
            $r="]";
            $pad_value= $limit-strlen($value);
            if ($pad_value==0) {
                # code...
                return $l.$value.$r;
            }
            else{
                $padder=str_repeat($pad, $pad_value);
                $response= $l.$padder.$value.$r;
                return "<?php echo $response; ?>";
            };
        });
		
		view()->share('currentCurrency', DB::table('currency')->pluck('code'));
        // 
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * it helps to define variable in Blade using '@def' :: wahid  
         */
        Blade::extend(function($value) {
            return preg_replace('/\@def(.+)/', '<?php ${1}; ?>', $value);
        });
    }
}
