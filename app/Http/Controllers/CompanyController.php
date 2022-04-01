<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\CompanyAddFormRequest;
use App\Http\Requests\EditCompanyFormRequest;
use Image;
use Illuminate\Support\Facades\Crypt;
use File;

class CompanyController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = Company::orderBy('id','desc')->latest()->paginate(10);
        if ($request->ajax()) {
            return view('companies.presult', compact('companies'));
        }
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyAddFormRequest $request)
    {
        $result = [];
        $file_name = $request->file('logo')->getClientOriginalName();
        $original_image = uniqid().'_'.$file_name;
        $image = Image::make($request->file('logo')->getRealPath())
        ->resize('100', '100')->save(storage_path() . '/app/public/company_logos/' . $original_image);
        $company_obj = new Company();
        $company_obj->logo = $original_image;
        $company_obj->name = $request->get('name');
        $company_obj->email = $request->get('email');
        $company_obj->address = $request->get('address');
        $company_obj->website = $request->get('website');
        $response = $company_obj->save();
        if($response) {
            $result = ['status'=>'success','message' => "Company Successfully Added"];
        } else {
            $result = ['status'=>'failed','message' => "Company Added Failed"];
        }
        return response($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company_id = Crypt::decryptString($id);
        $c_data = Company::where(['id'=>$company_id])->first();
        return view("companies.show",compact('c_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company_id = Crypt::decryptString($id);
        $c_data = Company::find($company_id);
        if(empty($c_data)) {
            return redirect('companies')->with('error_msg',"Company Not Found");
        }
        return view("companies.edit",compact('c_data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditCompanyFormRequest $request, Company $company)
    {
        $result = [];
  
        $input = $request->all();
  
        if ($request->file('logo')) {
            $image_path = public_path("storage/company_logos/") .$company->logo;
            File::delete($image_path);
            $file_name = $request->file('logo')->getClientOriginalName();
            $original_image = uniqid().'_'.$file_name;
            $image = Image::make($request->file('logo')->getRealPath())
            ->resize('100', '100')->save(storage_path() . '/app/public/company_logos/' . $original_image);
            $input['logo'] = "$original_image";
        }else{
            $input['logo'] = $company->logo;
        }
        
        $response = $company->update($input);
    
        if($response) {
            $result = ['status'=>'success','message' => "Company Successfully Updated"];
        } else {
            $result = ['status'=>'failed','message' => "Company Updation Failed"];
        }
        return response($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company_id = Crypt::decryptString($id);
        $c_data = Company::find($company_id);
        if(empty($c_data)) {
            return redirect('companies')->with('error_msg',"Company Not Found");
        }
        $image_path = public_path("storage/company_logos/") .$c_data->logo;
        
        if(File::exists($image_path)) {
            File::delete($image_path);
        } else{
            $c_data->employess()->where('company_id',$company_id)->delete();
            $c_data->delete();
        }
        $c_data->employess()->where('company_id',$company_id)->delete();
        $res = $c_data->delete();
        if($res) {
            return redirect()->route('companies.index')
            ->with('success','Company deleted successfully');
        } else {
            return redirect()->route('companies.index')
            ->with('success','Company deleted failed');
        }
    }
}
