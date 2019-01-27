<?php

namespace App\Http\Controllers;

use Input;
use Redirect;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use App\Models\Language;
use App\Models\Category;
use App\Models\Occupation;
use App\Models\SubCatLevel1;
use App\Models\SubCatLevel2;
use App\Models\SubCatLevel3;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminEditUserRequest;
use App\Http\Requests\AdminCreateUserRequest;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use DB;

class AdminController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.tree');
    }

    /**
     * Get all categories
     *
     * @method Ajax Get
     */

    public function getCategoriesNum()
    {
		$category = Category::orderBy('floor')->select('id','name','description','floor','color','logo_white','logo_green')->whereRaw(" EXISTS
				(SELECT product.id FROM product, merchantproduct, merchant WHERE product.category_id = category.id AND product.id = merchantproduct.product_id AND product.oshop_selected = true AND merchant.id = merchantproduct.merchant_id AND product.available > 0 AND product.status = 'active' AND merchant.status = 'active')")->get()->toArray();
		return response()->json(count($category));
	}	 
	 
    public function getCategories()
    {
        $category = Category::orderBy('floor')->select('id','name','description','floor','color','logo_white','logo_green')->get()->toArray();
        $subCatLevel1 = SubCatLevel1::orderBy('description')->select('id','name','category_id','description','logo')->get()->toArray();
        $subCatLevel2 = SubCatLevel2::orderBy('description')->select('id','name','category_id','subcat_level_1_id','description','logo')->get()->toArray();
        $subCatLevel3 = SubCatLevel3::orderBy('description')->select('id','name','category_id','subcat_level_1_id','subcat_level_2_id','description','logo')->get()->toArray();

        $categories = array();
        foreach ($category as $key => $value) {
            if (empty($categories[$key])) {
                $categories[$key] = array();
            }
            $categories[$key]['desc']	= $value['description'];
            $categories[$key]['text']	= "Floor #" . $value['floor'] . " " . $value['description'];
            $categories[$key]['name']   = $value['name'];
            $categories[$key]['floor']  = $value['floor'];
            $categories[$key]['color']	= $value['color'];
            $categories[$key]['data-category-id'] = $value['id'];
            if (!empty($value['logo_white'])) {
                $categories[$key]['logo'] = \URL::to('images/category/logo/' . $value['logo_white'] );
            }
            if (!empty($value['logo_green'])) {
                $categories[$key]['logoGreen'] = \URL::to('images/category/logo-green/' . $value['logo_green'] );
            }
            $inc = 0;
            foreach ($subCatLevel1 as $key1 => $subCat1) {
                if ($subCat1['category_id'] == $value['id']) {
                    if (!isset($categories[$key]['nodes'])) {
                        $categories[$key]['nodes']	= array();
                    }
                    if (empty($categories[$key]['nodes'][$inc])) {
                        $categories[$key]['nodes'][$inc] = array();
                    }
                    $categories[$key]['nodes'][$inc]['text'] = $subCat1['description'];
                    $categories[$key]['nodes'][$inc]['desc'] = $subCat1['description'];
                    $categories[$key]['nodes'][$inc]['name'] = $subCat1['name'];
                    $categories[$key]['nodes'][$inc]['data-category-id'] = $value['id'];
                    $categories[$key]['nodes'][$inc]['data-category-1-id'] = $subCat1['id'];
                    if (!empty($subCat1['logo'])) {
                        $categories[$key]['nodes'][$inc]['logo'] = \URL::to('images/subcat_level_1/logo/' . $subCat1['logo'] );
                    }

                    $cnt = 0;
                    foreach ($subCatLevel2 as $key2 => $subCat2) {
                        if ($subCat2['category_id'] == $value['id'] && $subCat2['subcat_level_1_id'] == $subCat1['id']) {
                            if (!isset($categories[$key]['nodes'][$inc]['nodes'])) {
                                $categories[$key]['nodes'][$inc]['nodes'] = array();
                            }
                            if (empty($categories[$key]['nodes'][$inc]['nodes'][$cnt])) {
                                $categories[$key]['nodes'][$inc]['nodes'][$cnt] = array();
                            }
                            $categories[$key]['nodes'][$inc]['nodes'][$cnt]['text'] = $subCat2['description'];
                            $categories[$key]['nodes'][$inc]['nodes'][$cnt]['desc'] = $subCat2['description'];
                            $categories[$key]['nodes'][$inc]['nodes'][$cnt]['name'] = $subCat2['name'];
                            $categories[$key]['nodes'][$inc]['nodes'][$cnt]['data-category-id'] = $value['id'];
                            $categories[$key]['nodes'][$inc]['nodes'][$cnt]['data-category-1-id'] = $subCat1['id'];
                            $categories[$key]['nodes'][$inc]['nodes'][$cnt]['data-category-2-id']   = $subCat2['id'];
                            if (!empty($subCat2['logo'])) {
                                $categories[$key]['nodes'][$inc]['nodes'][$cnt]['logo']  = \URL::to('images/subcat_level_2/logo/' . $subCat2['logo'] );
                            }

                            $count = 0;
                            foreach ($subCatLevel3 as $key3 => $subCat3) {
                                if ($subCat3['category_id'] == $value['id'] && $subCat3['subcat_level_1_id'] == $subCat1['id'] && $subCat3['subcat_level_2_id'] == $subCat2['id']) {
                                    if (!isset($categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'])) {
                                        $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'] = array();
                                    }
                                    if (empty($categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count])) {
                                        $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count] = array();
                                    }
                                    $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count]['text'] = $subCat3['description'];
                                    $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count]['desc'] = $subCat3['description'];
                                    $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count]['name'] = $subCat3['name'];
                                    $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count]['data-category-id'] = $value['id'];
                                    $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count]['data-category-1-id'] = $subCat1['id'];
                                    $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count]['data-category-2-id']	= $subCat2['id'];
                                    $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count]['data-category-3-id']  = $subCat3['id'];
                                    if (!empty($subCat3['logo'])) {
                                        $categories[$key]['nodes'][$inc]['nodes'][$cnt]['nodes'][$count]['logo']    = \URL::to('images/subcat_level_3/logo/' . $subCat3['logo'] );
                                    }
                                    $count++;
                                }
                            }

                            $cnt++;
                        }
                    }

                    $inc++;
                }
            }
        }

        return response()->json($categories);
    }

    /**
     * Get category views
     *
     * @method Get
     */
    public function getCategoriesTable()
    {
        return view('admin/categoryTree');
    }

    /**
     * Add new category or subCategory
     *
     * @method Ajax POST
     */
    public function postNewCategory(Request $request) {

        $formData = Input::all();

        $destinationPath = array(
            'logo' => 'images/category/logo',
            'greenLogo' => 'images/category/logo-green',
            'subCat1' => 'images/subcat_level_1/logo',
            'subCat2' => 'images/subcat_level_2/logo',
            'subCat3' => 'images/subcat_level_3/logo'
        );

        $image = $request->file('logo');

        $now = \Carbon\Carbon::now()->toDateTimeString();

        if (!empty($formData['data-category-id'])) {

            $categoryData = array(
                'category_id' => $formData['data-category-id'],
                'name' => $formData['categoryName'],
                'description' => $formData['categoryDescription'],
                'created_at' => $now,
                'updated_at' => $now,
            );

            if (!empty($formData['data-category-2-id']) && !empty($formData['data-category-1-id'])) {
                $categoryData['subcat_level_2_id'] = $formData['data-category-2-id'];
                $categoryData['subcat_level_1_id'] = $formData['data-category-1-id'];
                if (!empty($image)) {
                    $filename = $image->getClientOriginalName();
                    $uploadSuccess = $image->move($destinationPath['subCat3'], $filename);
                    if ($uploadSuccess) {
                        $categoryData['logo'] = $filename;
                    }
                }
                SubCatLevel3::insert($categoryData);
            } else if (!empty($formData['data-category-1-id'])) {
                $categoryData['subcat_level_1_id'] = $formData['data-category-1-id'];
                if (!empty($image)) {
                    $filename = $image->getClientOriginalName();
                    $uploadSuccess = $image->move($destinationPath['subCat2'], $filename);
                    if ($uploadSuccess) {
                        $categoryData['logo'] = $filename;
                    }
                }
                SubCatLevel2::insert($categoryData);
            } elseif ($formData['data-category-id']) {
                if (!empty($image)) {
                    $filename = $image->getClientOriginalName();
                    $uploadSuccess = $image->move($destinationPath['subCat1'], $filename);
                    if ($uploadSuccess) {
                        $categoryData['logo'] = $filename;
                    }
                }
                SubCatLevel1::insert($categoryData);
            }
        } else {
			$max_floor = DB::table('category')->orderBy('floor','DESC')->pluck('floor');
			$max_floor++;
            $mainCategory = array(
                'name' => $formData['categoryName'],
                'description' => $formData['categoryDescription'],
                'floor'=> $max_floor,
                'color'=> '#AAAAAA',
                'enable'=> false,
                'original_color'=> isset($formData['color']) ? $formData['color']: '',
                'created_at' => $now,
                'updated_at' => $now,
            );
			
            if (!empty($image)) {
                $filename = $image->getClientOriginalName();
                $uploadSuccess = $image->move($destinationPath['logo'], $filename);
                copy($destinationPath['logo'] .'/'.$filename, $destinationPath['greenLogo'] .'/'.$filename);
                if ($uploadSuccess) {
                    $mainCategory['logo_white'] = $filename;
                }
            }

            $greenLogo = $request->file('greenLogo');
            if (!empty($greenLogo)) {
                $filename = $greenLogo->getClientOriginalName();
                $uploadSuccess = $greenLogo->move($destinationPath['greenLogo'], $filename);
                if ($uploadSuccess) {
                    $mainCategory['logo_green'] = $filename;
                }
            }
			DB::statement("UPDATE category SET floor=floor+1 WHERE floor >= " . $max_floor);
            Category::insert($mainCategory);
			
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Edit new category or subCategory
     *
     * @method Ajax POST
     */
    public function postEditCategory(Request $request) {

        $formData = Input::all();

        $destinationPath = array(
            'logo' => 'images/category/logo',
            'greenLogo' => 'images/category/logo-green',
            'subCat1' => 'images/subcat_level_1/logo',
            'subCat2' => 'images/subcat_level_2/logo',
            'subCat3' => 'images/subcat_level_3/logo'
        );

        $image = $request->file('logo');

        $categoryData = array(
            'name' => $formData['categoryName'],
            'description' => $formData['categoryDescription']
        );

        if (!empty($formData['data-category-3-id']) && !empty($formData['data-category-2-id']) && !empty($formData['data-category-1-id'])) {
            if (!empty($image)) {
                $filename = $image->getClientOriginalName();
                $uploadSuccess = $image->move($destinationPath['subCat3'], $filename);
                if ($uploadSuccess) {
                    $categoryData['logo'] = $filename;
                }
            }
            SubCatLevel3::where('id', '=', $formData['data-category-3-id'])->update($categoryData);
        } elseif (!empty($formData['data-category-2-id']) && !empty($formData['data-category-1-id'])) {
            if (!empty($image)) {
                $filename = $image->getClientOriginalName();
                $uploadSuccess = $image->move($destinationPath['subCat2'], $filename);
                if ($uploadSuccess) {
                    $categoryData['logo'] = $filename;
                }
            }
            SubCatLevel2::where('id', '=', $formData['data-category-2-id'])->update($categoryData);
        } elseif (!empty($formData['data-category-1-id'])) {
            if (!empty($image)) {
                $filename = $image->getClientOriginalName();
                $uploadSuccess = $image->move($destinationPath['subCat1'], $filename);
                if ($uploadSuccess) {
                    $categoryData['logo'] = $filename;
                }
            }
            SubCatLevel1::where('id', '=', $formData['data-category-1-id'])->update($categoryData);
        } else {
            if (!empty($image)) {
                $filename = $image->getClientOriginalName();
                $uploadSuccess = $image->move($destinationPath['logo'], $filename);
                if ($uploadSuccess) {
                    $categoryData['logo_white'] = $filename;
                }
            }

            $greenLogo = $request->file('greenLogo');

            if (!empty($greenLogo)) {
                $filename = $greenLogo->getClientOriginalName();
                $uploadSuccess = $greenLogo->move($destinationPath['greenLogo'], $filename);
                if ($uploadSuccess) {
                    $categoryData['logo_green'] = $filename;
                }
            }

            if (isset($formData['floor'])) {
                $categoryData['floor'] = $formData['floor'];
				$cat = DB::table('category')->where('id',$formData['data-category-id'])->first();
				if($cat->floor < $categoryData['floor']){
					DB::statement("UPDATE category SET floor=floor-1 WHERE floor > " . $cat->floor . " AND floor <= " . $categoryData['floor']);
					//DB::table('category')->where('category.floor','>',)->where('category.floor','<=',$categoryData['floor'])->update(['category.floor'=>'category.floor-1']);							
				}

				if($cat->floor > $categoryData['floor']){
					DB::statement("UPDATE category SET floor=floor+1 WHERE floor < " . $cat->floor . " AND floor >= " . $categoryData['floor']);
					//DB::table('category')->where('category.floor','<',$cat->floor)->where('category.floor','>=',$categoryData['floor'])->update(['category.floor'=>'category.floor+1']);							
				}				
            }
            if (isset($formData['color'])) {
                $categoryData['color'] = $formData['color'];
                $categoryData['original_color'] = $formData['color'];
            }

            Category::where('id', '=', $formData['data-category-id'])->update($categoryData);
        }

        echo json_encode(array('success' => true));
    }

    /**
     * Delete new category or subCategory
     *
     * @method Ajax POST
     */
    public function removeCategory() {
        $formData = Input::all();
        if (isset($formData['data-category-3-id']) && isset($formData['data-category-2-id']) && isset($formData['data-category-1-id'])) {
            SubCatLevel3::where('id', '=', $formData['data-category-3-id'])->delete();
        } elseif (isset($formData['data-category-2-id']) && isset($formData['data-category-1-id'])) {
            SubCatLevel2::where('id', '=', $formData['data-category-2-id'])->delete();
        } elseif (isset($formData['data-category-1-id'])) {
            SubCatLevel1::where('id', '=', $formData['data-category-1-id'])->delete();
        } else {
			$cat = DB::table('category')->where('id',$formData['data-category-id'])->first();
			
			//DB::table('category')->where('floor','>',$cat->floor)->update(['floor'=>'(floor-1)']);
			DB::statement("UPDATE category SET floor=floor-1 WHERE floor > " . $cat->floor);
            Category::where('id', '=', $formData['data-category-id'])->delete();
        }

        echo "success";exit();
    }

    /**
     * Get Users
     *
     * @method GET
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with([
                'roles',
                'occupation'
            ])->get();

            return response()->json($users);
        }

        $roles = Role::all()->pluck('description', 'id');
        $countries = Country::all()->pluck('name', 'id');
        $languages = Language::all()->pluck('description', 'id');
        $occupations = Occupation::all()->pluck('description', 'id');

        return view('admin/users', compact('countries', 'languages', 'occupations', 'roles'));
    }

    public function getSingleUser(Request $request)
    {
        if ($request->ajax()) {
            $user = User::with([
                'roles',
                'occupation'
            ])->find($request->get('id'));

            if ($user instanceof User)
                return response()->json($user->toArray());

            return response()->json(null);
        }

        return response('Forbidden', 403)->json();

    }


    public function postNewUsers(AdminCreateUserRequest $request)
    {
        $user = User::create([
            'birthdate' => Carbon::createFromFormat('d/m/Y', $request->get('birthdate')),
            'email' => $request->get('email'),
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'password' => Hash::make($request->get('password')),
            'gender' => $request->get('gender'),
            'mobile_no' => $request->get('mobilePhone'),
            'language_id' => $request->get('language'),
            'occupation_id' => $request->get('occupation'),
            'nationality_country_id' => $request->get('country'),
        ]);

        // attach role
        foreach ($request->get('roles') as $role) {
            $roleFound = Sentinel::findRoleById($role);
            if ($roleFound instanceof Role)
                $roleFound->users()->attach($user);
        }

        return response()->json(true);
    }

    public function postEditUser(AdminEditUserRequest $request)
    {
        $user = User::find($request->get('id'));

        $user->update([
            'birthdate' => Carbon::createFromFormat('d/m/Y', $request->get('birthdate')),
            'email' => $request->get('email'),
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'password' => Hash::make($request->get('password')),
            'gender' => $request->get('gender'),
            'mobile_no' => $request->get('mobilePhone'),
            'language_id' => $request->get('language'),
            'occupation_id' => $request->get('occupation'),
            'nationality_country_id' => $request->get('country'),
        ]);


        //detach all roles before updating
        $user->roles()->detach();

        // attach the new updated role list
        foreach ($request->get('roles') as $role) {
            $roleFound = Sentinel::findRoleById($role);
            if ($roleFound instanceof Role)
                $roleFound->users()->attach($user);
        }

        return response()->json(true);

    }

    public function removeUser(Request $request)
    {
        if ($request->ajax()) {
            User::where('id', '=', $request->get('id'))->delete();
            return response()->json(true);
        }

        return response('Forbidden', 403)->json();
    }
    /**
     * Get Roles
     *
     * @method GET
     */
    public function getRoles() {
        $roles = Role::all()->toArray();

        $treeRoles= array();
        foreach ($roles as $key => $value) {
            if (empty($treeRoles[$key])) {
                $treeRoles[$key] = array();
            }
            $treeRoles[$key]['text']         = $value['description'];
            $treeRoles[$key]['slug']         = $value['slug'];
            $treeRoles[$key]['name']         = $value['name'];
            $treeRoles[$key]['description']  = $value['description'];
            $treeRoles[$key]['permissions']  = $value['permissions'];
            $treeRoles[$key]['data-role-id'] = $value['id'];
        }
        return response()->json($treeRoles);
    }

    public function getRolesTable() {
        return view('admin/roles');
    }

    /**
     * Create Role
     *
     * @method POST
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postNewRole(Request $request) {

        $roleData = $request->all();

        $role = array(
            'name' => $roleData['roleName'],
            'slug' => $roleData['roleSlug'],
            'description' => $roleData['roleDescription']
        );

        $permissions = array();
        if (isset($roleData['permissions'])) {
            if ($roleData['permissions'] == 3) {
                $permissions['read'] = true;
                $permissions['write'] = true;
            } elseif ($roleData['permissions'] == 2) {
                $permissions['write'] = true;
            } else {
                $permissions['read'] = true;
            }

            $role['permissions'] = $permissions;
        }

        Sentinel::getRoleRepository()->createModel()->create($role);

        return response()->json(array('success' => true));
    }


    public function postEditRole(Request $request)
    {
        $role = Sentinel::findRoleById($request->get('data-role-id'));

        $role->name = $request->get('roleName');
        $role->slug = $request->get('roleSlug');
        $role->description = $request->get('roleDescription');

        $permissions = array();

        if ($request->get('permissions') == 3) {
            $permissions['read'] = true;
            $permissions['write'] = true;
        } elseif ($request->get('permissions') == 2) {
            $permissions['write'] = true;
        } else {
            $permissions['read'] = true;
        }

        $role->permissions = $permissions;

        $role->save();

        return response()->json(array('success' => true));
    }

    public function removeRole(Request $request)
    {
        $formData = $request->all();

        Role::where('id', '=', $formData['data-role-id'])->delete();

        return response()->json(array('success' => true));
    }
    //Create merchant information
    public function merchant_Account_create(Request $request){
        dd("Test route for creating merchant");
        $merchantInfo=new Merchant();

        $merchantInfo->user_id =$request->get('user_id');
        $merchantInfo->bank_id =$request->get('bank_id');
        $merchantInfo->company_name =$request->get('company_name');
        $merchantInfo->gst =$request->get('gst');
        $merchantInfo->business_reg_no =$request->get('business_reg_no');
        $merchantInfo->country_id =$request->get('country_id');
        $merchantInfo->business_type =$request->get('business_type');

        $merchantInfo->address_id =$request->get('address_id');
        $merchantInfo->contact_person =$request->get('contact_person');
        $merchantInfo->office_no =$request->get('office_no');
        $merchantInfo->mobile_no =$request->get('mobile_no');
        /* Name and address of the O-Shop */
        $merchantInfo->oshop_name =$request->get('oshop_name');
        $merchantInfo->oshop_address_id =$request->get('oshop_address_id');
        /* We support 5 logos for the O-Shop */
        $merchantInfo->oshop_logo_1 =$request->get('oshop_logo_1');
        $merchantInfo->oshop_logo_2 =$request->get('oshop_logo_2');
        $merchantInfo->oshop_logo_3 =$request->get('oshop_logo_3');
        $merchantInfo->oshop_logo_4 =$request->get('oshop_logo_4');
        $merchantInfo->oshop_logo_5 =$request->get('oshop_logo_5');
        /* These are images for O-Shop advertisment */
        $merchantInfo->oshop_adimage_1 =$request->get('oshop_adimage_1');
        $merchantInfo->oshop_adimage_2 =$request->get('oshop_adimage_2');
        $merchantInfo->oshop_adimage_3 =$request->get('oshop_adimage_3');
        $merchantInfo->oshop_adimage_4 =$request->get('oshop_adimage_4');
        $merchantInfo->oshop_adimage_5 =$request->get('oshop_adimage_5');

        $merchantInfo->description =$request->get('description');
        $merchantInfo->history =$request->get('history');

        /* Custom O-Shop template is referred from:
         * oshop_template table */
        $merchantInfo->license =$request->get('license');
        $merchantInfo->coverage =$request->get('coverage');
        $merchantInfo->ownership =$request->get('ownership');
        $merchantInfo->category_id =$request->get('category_id');
        $merchantInfo->planned_sales=$request->get('planned_sales');

        $merchantInfo->bankaccount_id=$request->get('bankaccount_id');


        /* Which merchant consultant brought this merchant in?
			 * Table sales_staff is a general store for commissionable
			 * sales staff */
        $merchantInfo->mc_sales_staff_id=$request->get('mc_sales_staff_id');

        /* This merchant maybe an internal referral from another
         * merchant consultant from another region or country.
         * We keep track of the referral source too. */
        $merchantInfo->referral_sales_staff_id=$request->get('referral_sales_staff_id');

        $merchantInfo->mcp1_sales_staff_id=$request->get('mcp1_sales_staff_id');
        $merchantInfo->mcp2_sales_staff_id=$request->get('mcp2_sales_staff_id');
        $merchantInfo->psh_sales_staff_id=$request->get('psh_sales_staff_id');

        /* The maximum number of products to be marketed under SMM.
         * This value will be initialized from global */
        $merchantInfo->smm_quota_max=$request->get('smm_quota_max');

        /* The maximum number of post a SMM can make in 24 hrs */
        $merchantInfo->smm_max_post=$request->get('smm_max_post');

        /* The minimum time in hours a SMM has to wait in between posts */
        $merchantInfo->smm_min_duration=$request->get('smm_min_duration');

        $merchantInfo->return_policy=$request->get('return_policy');
        $merchantInfo->remarks=$request->get('remarks');


        /* Commission table per merchant */
        $merchantInfo->osmall_commission=$request->get('osmall_commission');
        $merchantInfo->mc_sales_staff_commission=$request->get('mc_sales_staff_commission');
        $merchantInfo->mc_with_ref_sales_staff_commission=$request->get('mc_with_ref_sales_staff_commission');
        $merchantInfo->referral_sales_staff_commission=$request->get('referral_sales_staff_commission');
        $merchantInfo->mcp1_sales_staff_commission=$request->get('mcp1_sales_staff_commission');
        $merchantInfo->mcp2_sales_staff_commission=$request->get('mcp2_sales_staff_commission');
        $merchantInfo->smm_sales_staff_commission=$request->get('smm_sales_staff_commission');
        $merchantInfo->psh_sales_staff_commission=$request->get('psh_sales_staff_commission');
        $merchantInfo->str_sales_staff_commission=$request->get('str_sales_staff_commission');
        $merchantInfo->save();

    }
    //Update the merchant data
    public function update_merchant(Request $request)
    {
        $merchantInfo=Merchant::where('user_id',$request->get('user_id'))->first();
        if($merchantInfo==true){
            $merchantInfo->user_id =$request->get('user_id');
            $merchantInfo->bank_id =$request->get('bank_id');
            $merchantInfo->company_name =$request->get('company_name');
            $merchantInfo->gst =$request->get('gst');
            $merchantInfo->business_reg_no =$request->get('business_reg_no');
            $merchantInfo->country_id =$request->get('country_id');
            $merchantInfo->business_type =$request->get('business_type');

            $merchantInfo->address_id =$request->get('address_id');
            $merchantInfo->contact_person =$request->get('contact_person');
            $merchantInfo->office_no =$request->get('office_no');
            $merchantInfo->mobile_no =$request->get('mobile_no');
            /* Name and address of the O-Shop */
            $merchantInfo->oshop_name =$request->get('oshop_name');
            $merchantInfo->oshop_address_id =$request->get('oshop_address_id');
            /* We support 5 logos for the O-Shop */
            $merchantInfo->oshop_logo_1 =$request->get('oshop_logo_1');
            $merchantInfo->oshop_logo_2 =$request->get('oshop_logo_2');
            $merchantInfo->oshop_logo_3 =$request->get('oshop_logo_3');
            $merchantInfo->oshop_logo_4 =$request->get('oshop_logo_4');
            $merchantInfo->oshop_logo_5 =$request->get('oshop_logo_5');
            /* These are images for O-Shop advertisment */
            $merchantInfo->oshop_adimage_1 =$request->get('oshop_adimage_1');
            $merchantInfo->oshop_adimage_2 =$request->get('oshop_adimage_2');
            $merchantInfo->oshop_adimage_3 =$request->get('oshop_adimage_3');
            $merchantInfo->oshop_adimage_4 =$request->get('oshop_adimage_4');
            $merchantInfo->oshop_adimage_5 =$request->get('oshop_adimage_5');

            $merchantInfo->description =$request->get('description');
            $merchantInfo->history =$request->get('history');

            /* Custom O-Shop template is referred from:
             * oshop_template table */
            $merchantInfo->license =$request->get('license');
            $merchantInfo->coverage =$request->get('coverage');
            $merchantInfo->ownership =$request->get('ownership');
            $merchantInfo->category_id =$request->get('category_id');
            $merchantInfo->planned_sales=$request->get('planned_sales');

            $merchantInfo->bankaccount_id=$request->get('bankaccount_id');


            /* Which merchant consultant brought this merchant in?
                 * Table sales_staff is a general store for commissionable
                 * sales staff */
            $merchantInfo->mc_sales_staff_id=$request->get('mc_sales_staff_id');

            /* This merchant maybe an internal referral from another
             * merchant consultant from another region or country.
             * We keep track of the referral source too. */
            $merchantInfo->referral_sales_staff_id=$request->get('referral_sales_staff_id');

            $merchantInfo->mcp1_sales_staff_id=$request->get('mcp1_sales_staff_id');
            $merchantInfo->mcp2_sales_staff_id=$request->get('mcp2_sales_staff_id');
            $merchantInfo->psh_sales_staff_id=$request->get('psh_sales_staff_id');

            /* The maximum number of products to be marketed under SMM.
             * This value will be initialized from global */
            $merchantInfo->smm_quota_max=$request->get('smm_quota_max');

            /* The maximum number of post a SMM can make in 24 hrs */
            $merchantInfo->smm_max_post=$request->get('smm_max_post');

            /* The minimum time in hours a SMM has to wait in between posts */
            $merchantInfo->smm_min_duration=$request->get('smm_min_duration');

            $merchantInfo->return_policy=$request->get('return_policy');
            $merchantInfo->remarks=$request->get('remarks');


            /* Commission table per merchant */
            $merchantInfo->osmall_commission=$request->get('osmall_commission');
            $merchantInfo->mc_sales_staff_commission=$request->get('mc_sales_staff_commission');
            $merchantInfo->mc_with_ref_sales_staff_commission=$request->get('mc_with_ref_sales_staff_commission');
            $merchantInfo->referral_sales_staff_commission=$request->get('referral_sales_staff_commission');
            $merchantInfo->mcp1_sales_staff_commission=$request->get('mcp1_sales_staff_commission');
            $merchantInfo->mcp2_sales_staff_commission=$request->get('mcp2_sales_staff_commission');
            $merchantInfo->smm_sales_staff_commission=$request->get('smm_sales_staff_commission');
            $merchantInfo->psh_sales_staff_commission=$request->get('psh_sales_staff_commission');
            $merchantInfo->str_sales_staff_commission=$request->get('str_sales_staff_commission');
            $merchantInfo->save();
        }
        else{
            return redirect()->back();
        }
    }
    public function edit_merchant($id){
        $data[]=Merchant::find($id);
        return json_encode($data);
    }
    public function destroy_merchant($id)
    {
        //
        $mer = Merchant::find($id);
        $mer->delete();
        return json_encode(["message"=>true]);
    }


}
