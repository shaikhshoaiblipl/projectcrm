<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductCategory;
use App\Country;
use App\City;
use App\Customer;
use App\Customer_has_contact;
use App\Customer_has_company_store;
use App\Customer_has_prodcut;
use App\Customer_has_present_product;
use App\User;
use DataTables;
use Form;
use Auth;


class Customers extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $sales=User::with('roles')->whereHas('roles', function($query){
            $query->where('id',config('constants.ROLE_TYPE_SALES_ID'));
        })->where(['is_active'=>TRUE])->pluck('name', 'id');
        $cities = City::where('id', '!=', config('constants.CITY_OTHER_ID'))->where(['is_active'=>TRUE])->pluck('title', 'id');
        return view('admin.customer.index',compact('sales','cities'));
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomers(Request $request){
        $customers = Customer::query()->with('city','users'); 
        $customers->select([\DB::raw(with(new Customer)->getTable().'.*')]);
        if (in_array(Auth::user()->roles->first()->id, [config('constants.ROLE_TYPE_CUSTOMERSERVICE_ID'),config('constants.ROLE_TYPE_SALES_ID'),config('constants.ROLE_TYPE_PURCHASER')])) {
            $customers->where('created_by',Auth::user()->id);
        }
        $customers->groupBy('id');

        $sales_id = intval($request->input('sales_id'));
        if(intval($sales_id) > 0)
            $customers->where('created_by', $sales_id); 
        
        $customer_type = $request->input('customer_type');
        if($customer_type!='')
            $customers->where('customer_type', $customer_type);  
        
        $city_id = intval($request->input('city_id'));
        if(intval($city_id) > 0)
            $customers->where('city_id', $city_id);       

        return DataTables::of($customers)               

            ->editColumn('is_active', function ($customer) {
                if($customer->is_active == TRUE ){
                    return "<a href='".route('admin.customers.status',$customer->id)."'><span class='badge badge-success'>Active</span></a>";
                }else{
                    return "<a href='".route('admin.customers.status',$customer->id)."'><span class='badge badge-danger'>Inactive</span></a>";
                }
            })  
            ->editColumn('created_by', function ($customer) {
                return isset($customer->users->name)?$customer->users->name:'';
            })
            ->editColumn('city_id', function ($customer) {
               return $customer->city->title;
            })
            ->editColumn('customer_type', function ($customer) {
               return ucwords($customer->customer_type);
            })  
            ->addColumn('action', function ($customer) {
                return
                    // edit
                    //'<a href="'.route('admin.countries.edit',[$customer->id]).'" class="btn btn-success btn-circle btn-sm"><i class="fas fa-edit"></i></a> '.
                    // Delete
                    Form::open(array(
                        'style' => 'display: inline-block;',
                        'method' => 'DELETE',
                        'onsubmit'=>"return confirm('Do you really want to delete?')",
                        'route' => ['admin.countries.destroy', $customer->id])).
                    ' <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>'.
                    Form::close();
            })
            ->rawColumns(['media.name','is_active','action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
       $productCategories = ProductCategory::where(['is_active'=>TRUE,'parent_id'=>0])->pluck('title', 'id');
       $subCategories = ProductCategory::where('parent_id', '!=', 0)->where(['is_active'=>TRUE])->pluck('title', 'id');
       $countries = Country::where('id', '!=', config('constants.COUNTRY_OTHER_ID'))->where(['is_active'=>TRUE])->pluck('title', 'id');
       $cities = City::where('id', '!=', config('constants.CITY_OTHER_ID'))->where(['is_active'=>TRUE])->pluck('title', 'id');
       return view('admin.customer.form', compact('countries','subCategories','cities'));
    }

    /**
     * For get city name with country and return json
     *
     * @return \Illuminate\Http\Response
    */
    public function getCities(Request $request){
        $country_id = intval($request->input('country_id'));
        $city_id = intval($request->input('city_id'));
        $single_drop = $request->input('single_drop');
        $citieshtml ='';
        if($single_drop==TRUE){
            $citieshtml ='<option value="">-Select-</option>';
        }
        
        if($country_id > 0){
            $cities = City::where('id', '!=', config('constants.CITY_OTHER_ID'))->where(['is_active'=>TRUE,'country_id'=>$country_id])->pluck('title', 'id');
            if($cities->count() > 0){
                foreach ($cities as $id => $title) {
                    $selected = ($city_id==$id)?'selected':'';
                    $citieshtml .= '<option value="'.$id.'" '.$selected.'>'.ucwords($title).'</option>';
                }
            }
        }        
        return response()->json(['cities'=>$citieshtml]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'company_name'=>'required',
            'address'=>'required',
            'country_id'=>'required',
            'city_id'=>'required',
            'landline'=>'required',
            'contact_person_name'=>'required',
            'website'=>'required',
            'customer_type'=>'required',
            'tin_number'=>'required',
            'company_type'=>'required',
            'company_city_id'=>'required',
            'customer_product_sub_cat_id'=>'required',     
            'present_company_name'=>'required',     
            'sub_product_id'=>'required',     
        ];
        
        $request->validate($rules);
        $data = $request->all();
       
       /* $company_name = isset($data['company_name'])?$data['company_name']:'';
        $address = isset($data['address'])?$data['address']:'';
        $country_id = isset($data['country_id'])?$data['country_id']:'';
        
        $landline = isset($data['landline'])?$data['landline']:'';
        $website = isset($data['website'])?$data['website']:'';
        $customer_type = isset($data['customer_type'])?$data['customer_type']:'';
        $tin_number = isset($data['tin_number'])?$data['tin_number']:'';
        $market_information = isset($data['market_information'])?$data['market_information']:'';*/

        $city_id = isset($data['city_id'])?$data['city_id']:'';
        
        $contact_person_name = isset($data['contact_person_name'])?$data['contact_person_name']:'';
        $email = isset($data['email'])?$data['email']:'';
        $mobile = isset($data['mobile'])?$data['mobile']:'';
       
        $company_type = isset($data['company_type'])?$data['company_type']:'';
        $company_city_id = isset($data['company_city_id'])?$data['company_city_id']:'';

        $customer_product_sub_cat_id = isset($data['customer_product_sub_cat_id'])?$data['customer_product_sub_cat_id']:'';

        $present_company_name = isset($data['present_company_name'])?$data['present_company_name']:'';
        $sub_product_id = isset($data['sub_product_id'])?$data['sub_product_id']:'';
        
        $data = $request->except(['customer_id','contact_person_name', 'email','mobile','company_type', 'company_city_id','customer_product_sub_cat_id','present_company_name','sub_product_id']);

        $data['created_by']=Auth::user()->id;

        $customer = Customer::create($data);
        $city = City::where('id',$city_id)->first();
        $citytitle='';
        if($city){
           $citytitle = substr($city->title,0,3); 
        }else{
           $newstr = $customer->id;
        }
        
        $customer_id='M1'.ucwords($citytitle).$customer->id;
        $customer->update(['customer_id'=>$customer_id]);
        if(!empty($contact_person_name)){
            foreach ($contact_person_name as $key => $contact_person){
                if($contact_person!=''){
                    $dataArray=array('customer_id'=>$customer->id,
                        'contact_name'=>isset($contact_person)?$contact_person:'',
                        'email'=>isset($email[$key])?$email[$key]:'' ,
                        'mobile'=>isset($mobile[$key])?$mobile[$key]:'',
                    );
                    Customer_has_contact::create($dataArray);
                }
            }
        } 

        if(!empty($company_type)){
            foreach ($company_type as $key => $company_t){
                if($company_t!=''){
                    $dataArray=array('customer_id'=>$customer->id,
                        'company_type'=>isset($company_t)?$company_t:'' ,
                        'company_city_id'=>isset($company_city_id[$key])?$company_city_id[$key]:0,
                    );
                    Customer_has_company_store::create($dataArray);
                }
            }
        }

        if(!empty($customer_product_sub_cat_id)){
            foreach ($customer_product_sub_cat_id as $key => $customer_p_sub_cat_id){
                if($customer_p_sub_cat_id!='' && $customer_p_sub_cat_id!=0 ){
                    $dataArray=array('customer_id'=>$customer->id,
                        'customer_product_sub_cat_id'=>isset($customer_p_sub_cat_id)?$customer_p_sub_cat_id:0,
                    );
                    Customer_has_prodcut::create($dataArray);
                }
            }
        }
        
        if(!empty($sub_product_id)){
            foreach ($sub_product_id as $key => $sub_product){
                if($sub_product!='' && $sub_product!=0 ){
                    $dataArray=array('customer_id'=>$customer->id,
                        'present_company_name'=>isset($present_c_name[$key])?$present_c_name[$key]:'' ,
                        'present_sub_product_id'=>isset($sub_product)?$sub_product:0,
                    );
                    Customer_has_present_product::create($dataArray);
                }
            }
        }

        $request->session()->flash('success',__('global.messages.add'));
        return redirect()->route('admin.customers.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view('admin.countries.form',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $rules = [            
            'title'=>'required|unique:'.with(new Country)->getTable().',title,'.$country->getKey()
        ];

        $request->validate($rules);

        $data = $request->all();

        $country->update($data);   

        $request->session()->flash('success',__('global.messages.update'));
        return redirect()->route('admin.countries.index');
    }

    /**
     * Change status the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function status(Request $request, $customer_id=null){
        $customer = Customer::findOrFail($customer_id);
        if (isset($customer->is_active) && $customer->is_active==FALSE) {
            $customer->update(['is_active'=>TRUE]);
            $request->session()->flash('success',__('global.messages.activate'));
        }else{
            $customer->update(['is_active'=>FALSE]);
            $request->session()->flash('danger',__('global.messages.deactivate'));
        }
        return redirect()->route('admin.customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy(Request $request,$customer_id=null)
     {
            $customer = Customer::where('id',$customer_id)->first();
            if($customer){
                Customer_has_contact::where('customer_id',$customer_id)->delete();
                Customer_has_company_store::where('customer_id',$customer_id)->delete();
                Customer_has_prodcut::where('customer_id',$customer_id)->delete();
                Customer_has_present_product::where('customer_id',$customer_id)->delete();
            }
            $customer->delete();
            $request->session()->flash('danger',__('global.messages.delete'));
            return redirect()->route('admin.countries.index');
     }



     public function getProductSubCategories(Request $request){
        // $product_cat_id = intval($request->input('product_cat_id'));
        //     $productsubcategory = ProductCategory::where(['is_active'=>TRUE,'parent_id'=>$product_cat_id])->pluck('title', 'id'); 
        return response()->json('working');
    }
}
