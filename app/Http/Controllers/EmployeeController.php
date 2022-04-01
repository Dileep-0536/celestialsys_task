<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\Employee;
use App\Models\Company;
use App\Http\Requests\AddEmployeeFormRequest;
use App\Http\Requests\EditEmployeeFormRequest;

class EmployeeController extends Controller
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
        $employees = Employee::with('company')->latest()->paginate(10);
        if ($request->ajax()) {
            return view('employees.presult', compact('employees'));
        }
        return view('employees.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_companies = Company::orderBy('id','desc')->get();
        return view('employees.create', compact('get_companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddEmployeeFormRequest $request)
    {
        $result = [];
        $employee_obj = new Employee();
        $employee_obj->first_name = $request->get('first_name');
        $employee_obj->last_name = $request->get('last_name');
        $employee_obj->email = $request->get('email');
        $employee_obj->phone = $request->get('phone');
        $employee_obj->company_id = $request->get('company_id');
        $response = $employee_obj->save();
        if($response) {
            $result = ['status'=>'success','message' => "Employee Successfully Added"];
        } else {
            $result = ['status'=>'failed','message' => "Employee Added Failed"];
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee_id = Crypt::decryptString($id);
        $e_data = Employee::with('company')->where(['id'=>$employee_id])->first();
        if(empty($e_data)) {
            return redirect('employees')->with('error_msg',"Employee Not Found");
        }
        $get_companies = Company::orderBy('id','desc')->get();
        return view("employees.edit",compact('e_data','get_companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditEmployeeFormRequest $request, Employee $employee)
    {
        $result = [];

        $input = $request->all();

        $response = $employee->update($input);
    
        if($response) {
            $result = ['status'=>'success','message' => "Employee Successfully Updated"];
        } else {
            $result = ['status'=>'failed','message' => "Employee Updation Failed"];
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
        $employee_id = Crypt::decryptString($id);
        $e_data = Employee::find($employee_id);
        if(empty($e_data)) {
            return redirect('employees')->with('error_msg',"Employee Not Found");
        }
        $res = $e_data->delete();
        if($res) {
            return redirect()->route('employees.index')
                        ->with('success','Employee deleted successfully');
        } else {
            return redirect()->route('employees.index')
                        ->with('error_msg','Employee deleted failed');
        }
    }
}
