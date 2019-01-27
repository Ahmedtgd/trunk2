<?php

namespace App\Models;
use App\Models\SMMout;
use App\Models\Buyer;
use App\Models\RoleUser;
use App\Models\OAuth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sofa\Eloquence\Eloquence;
use App\Http\Controllers\EmailController;
use DB;
use Session;
class User extends EloquentUser implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Eloquence;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'users';
    // protected $softDelete = true;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $searchableColumns=['username','id'];
    protected $fillable = [
        'type',
        'name',
        'email',
        'gender',
        'avatar',
        'password',
        'mobile_no',
        'birthdate',
        'last_name',
        'first_name',
        'provider_id',
        'language_id',
        'permissions',
        'access_token',
        'occupation_id',
        'nationality_country_id',
    ];

    /**
     * Check if a role exist by passing $role->slug
     *
     * @param String $roleSlug
     * @return bool
     */
    public function hasRole($roleSlug)
    {
        $roles = $this->getRoles()->pluck('slug')->toArray();

        return in_array($roleSlug, $roles);
    }


    public function hasAccess($sys_name)
    {
        $ret=false;
        if ($this->hasRole('adm')) {
            return true;
        }

        $exclude=[
			"report",
			"ageing",
			"statement",
			"reconline",
			"recopossum",
			"treport",
			"salesmemo",
			"sstreport",
			"purorder",
			"invoice",
			"purorderi",
			"crednoterec",
			"debnoterec",
			"debnoteiss",
			"delordiss",
			"delordrec",
			"saleslog",
			"salordgat",
			"invissgat",
			"wastage",
			"system",
			"jaguar",
			"gator",
			"opossum",
			"arapaima",
			"logistics",
			"warehouse",
			"raw",
			"humancap",
			"wallet",
			"beluga",
			"inventory",
			"oshop",
			"analytics",
			"data",
			"custlist",
			"stafflist",
			"dealertab",
			"suppllist",
			"autolink",
			"specialoffer"
		];

        if (in_array($sys_name,$exclude)) {
            return true;
        }

        if ($this->hasRole('mer')) {
            $merchant_id=DB::table('merchant')
            ->where('user_id',$this->id)
            ->whereNull('deleted_at')
            ->pluck('id');
            if (!empty($merchant_id)) {
                # code...
                $access=DB::table('moduleaccess')
                ->join('sysmodule','sysmodule.id','=','moduleaccess.sysmodule_id')
                ->where('sysmodule.sysname',$sys_name)
                ->where('moduleaccess.merchant_id',$merchant_id)
                ->whereNull('moduleaccess.deleted_at')
                ->where('moduleaccess.status','active')
                ->first();
                if (!empty($access)) {
                    # code...
                    $ret=true;
                }
            }
        }
    
        return $ret;
    }
    /*relations*/

    /*one user may have many merchants*/
    public function merchant()
    {
        return $this->hasMany('App\Models\Merchant','user_id','id');
    }

    

    public function location()
    {
        return $this->hasMany('App\Models\MerchantLocation','id','id');
    }
    
    /*one user may have many station*/
    public function station()
    {
        return $this->hasMany('App\Models\Station','user_id','id');
    }


    /*user has only one occupation 1:1*/
    public function occupation()
    {
        return $this->belongsTo('App\Models\Occupation','occupation_id','id');
    }
    /*end relations*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dealers(){
        return $this->hasMany('App\Models\Dealer','user_id');
    }
     /**
     * country belongs to user
     */
    public function get_country(){
        return $this->belongsTo('App\Models\Country','nationality_country_id','id');
    }

   /*Address belongs to only one city 1:1*/
    public function get_default_address(){
       return $this->hasOne('App\Models\Address','id','default_address_id');
    }

    public function get_roles(){
       return $this->hasManyThrough('App\Models\Role','App\Models\RoleUser');
    }

    public function getPorder(){
       return $this->hasMany('App\Models\POrder','user_id','id');
    }
        /*end relations*/

    public function getMeta()
    {
        $userMeta = [
            "id" => null,
            "occupation_id" => null,
            "first_name" => null,
            "last_name" => null,
            "birthdate" => null,
            "mobile_no" => null,
            "email" => null,
            "password" => null,
            "gender" => null,
            "annual_income" => null,
            "salutation" => null,
            "type" => null,
            "deleted_at" => null,
            "created_at" => null,
            "updated_at" => null,
        ];
        return $userMeta;
    }

    public function store(Request $request)
    {
        $user_data = $this->collectUserFormData($request);
        $user = new User();
        $user_model = $user->create($user_data);

        $role = new RoleUser;
        $role->user_id = $user_model->id;

        if($request->get('indication') == 'merchant'){
           // $role->role_id = 3;
        }elseif($request->get('indication') == 'station'){
            $role->role_id = 11;
			$role->save();
        }elseif($request->get('indication') == 'buyer'){
            $role->role_id = 2;
			$role->save();
        }      

        return $user_model;
    }

    public function collectUserFormData(Request $request)
    {
        return  $user_data = [
//          'id'=>$request->get('id'),
        //  'occupation_id'=>$request->get(''),
            'first_name'=>$request->get('firstname'),
            'last_name'=>$request->get('lastname'),
            'birthdate' => $request->get('dob') != null ? $request->get('dob') : '0000-00-00',
            'mobile_no'=>$request->get('mobile'),
            'email'=>$request->get('email'),
            'password'=>bcrypt($request->get('password')),
            'gender'=>$request->get('gender'),
            'annual_income'=>$request->get('income'),
            'salutation'=>$request->get('salutation'),
            /*'type'=>$request->get('indication') != null ? $request->get('indication') : null,*/
        ];
    }

    /**
     * First check if user exist. if not create one
     * @param $userData
     * @return static
     */
    public function findByEmailOrCreate($userData)
    {
        $existing_user = User::where('email', $userData->email)->first();
        // $role= DB::table('role_users')->where('user_id',$existing_user->id)->get();
        if ( $existing_user ) {
            $roles= DB::table('role_users')->
				where('user_id',$existing_user->id)->get();
            foreach ($roles as $r) {
                if ($r->role_id==2) {
                    # code...
                    Session::put('user_role',2);
                    return $existing_user;
                }
            }
            // return $user;
        }

        // Get first name and last name
        $fb_url2="https://graph.facebook.com/".$userData->id.
			"/?access_token=".(string)$userData->token.
			"&fields=first_name,last_name";

        $json2= json_decode(file_get_contents($fb_url2), true);
        $first_name=$json2['first_name'];
        $last_name=$json2['last_name'];
        try {
             $user= User::create([
				'id' => $userData->id,
				'first_name' => $first_name,
				'last_name' => $last_name,
				'name' => $userData->name,
				'email'    => $userData->email,
				'avatar'   => $userData->avatar,
				'access_token' => $userData->token,
				'gender' => isset($userData->gender)?$userData->gender:null,
				'provider_id' => $userData->id,
			]);

			// Create a record in Oauth
			$oauth=new OAuth;
			// if fb 
			$oauth->smedia_id=1;
			$oauth->client_id=$userData->id;
			$oauth->access_token=$userData->token;
			$oauth->user_id=$user->id;

			$oauth->save();
			$buyer= new Buyer;
			$buyer->user_id=$user->id;
			$buyer->status='active';
			$buyer->active_date=Carbon::now();
			$buyer->save();
			$roleuser=new RoleUser;
			$roleuser->user_id=$user->id;
			$roleuser->role_id=2;
			$roleuser->save();
			$access_token= $userData->token;
			$fb_url= "https://graph.facebook.com/me/friends?access_token=".
				(string)$access_token;

			$json = json_decode(file_get_contents($fb_url), true);
			$totalFBfriends = intval($json['summary']['total_count']);
			$smm= new SMMout;
			$smm->user_id= $user->id;
			$smm->connections=$totalFBfriends;
			$smm->save();
			return $user;

        } catch (\Exception $e) {
            //In case if user record exists, just give a role id
			// Create a record in Oauth
			$oauth=new OAuth;
			// if fb 
			$oauth->smedia_id=1;
			$oauth->client_id=$userData->id;
			$oauth->access_token=$userData->token;
			$oauth->user_id=$existing_user->id;

			$oauth->save();
			$buyer= new Buyer;
			$buyer->user_id=$existing_user->id;
			$buyer->status='active';
			$buyer->active_date=Carbon::now();
			$buyer->save();
			$roleuser=new RoleUser;
			$roleuser->user_id=$existing_user->id;
			$roleuser->role_id=2;
			$roleuser->save();
			$access_token= $userData->token;
			$fb_url= "https://graph.facebook.com/me/friends?access_token=".
				(string)$access_token;
			$json = json_decode(file_get_contents($fb_url), true);
			$totalFBfriends = intval($json['summary']['total_count']);
			$smm= new SMMout;
			$smm->user_id= $existing_user->id;
			$smm->connections=$totalFBfriends;
			$smm->save(); 
			return $existing_user;
        }
    }
    /*
     * Update record
     */
    public function UpdateUser($request)
    {
        $user_id = Auth::id();
        // dd($user_id);
        $user = User::find($user_id);
        $user->first_name   =   $request->get('firstname');
        $user->last_name    =   $request->get('lastname');
        // $user->email    =   $request->get('email');
        //$user->password     =    bcrypt($request->get('password'));
        $user->save();
        if ($user->email!=$request->get('email')) {
            $e= new EmailController;
            $e->updateEmail($request->get('email'),$user->id);
        }
        return $user;
    {

        }
    }   
	public function UpdateUserByid($request)
    {
        $user_id =  $request->get('theuserid');
      //  dd($user_id);
        $user = User::find($user_id);
        $user->first_name   =   $request->get('firstname');
        $user->last_name    =   $request->get('lastname');
        // $user->email    =   $request->get('email');
        //$user->password     =    bcrypt($request->get('password'));
        $user->save();
        if ($user->email!=$request->get('email')) {
            $e= new EmailController;
            $e->updateEmail($request->get('email'),$user->id);
        }
        return $user;
    {

        }
    }

    public function autolinks()
    {
        return $this->hasMany('App\Models\Autolink');
    }

    public function getBirthdateAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    //added by imran
    public function employees()
    {
        return $this->hasMany("App\Models\Employee");
    }

    public function OpenWish()
    {
        return $this->hasMany('App\Models\OpenWish','user_id','id');
    }
    public function buyerDiscount()
    {
        return $this->belongsToMany('App\Models\Discount', 'discountbuyer' ,'buyer_id','id');
    }


    public function member()
    {
//        return $this->hasManyThrough(Member)
    }
}
