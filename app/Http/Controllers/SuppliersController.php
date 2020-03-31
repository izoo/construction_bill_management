<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Validator;
use App\Suppliers;
use App\Bills;
use DB;
use DataTables;
class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

         if($request->ajax())
         {
             $data = Suppliers::latest()->get();
             return Datatables::of($data)->addIndexColumn()
             ->addColumn('edit',function($row){
                 $btn='<a  href="javascript:void(0)" data-toggle="tooltip"  id="'. $row->id .'" data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary editSupplier">Edit</a>';
             
             return $btn;
         })
         ->addIndexColumn()
         ->addColumn('delete',function($row2){
           $btn2 = '';
         return $btn2;
       })
         ->rawColumns(['edit','delete'])
         
         ->make(true);
         }
         
         return view('admin.dashboard.construction_admin',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'supplier_name' => 'required|unique:suppliers',
            'supplier_email' => 'required|unique:suppliers',
            'supplier_phone' => 'required|max:255',
            'company_name' => 'required|max:255',
           

        ],
        [
        'suppler_name.unique' => 'Supplier Name Exists,Use A Different Name',
        'supplier_email.unique' => 'Email Already Exists',
    
    ]);
        if($validator->passes())
        {
            $supplier = $request->supplier_name;
            $sup=str_replace(' ', '', $supplier);
            $sites = Suppliers::Create([
                'supplier_name' => $sup,
                'supplier_email' => $request->supplier_email,
                'supplier_phone' => $request->supplier_phone,
                'company_name' => $request->company_name,
                
               
            ]);
                return response()->json(['success' => 'New Supplier Successfully Registered']);
            }
            else
            {
                return response()->json(['error' => $validator->errors()->all()]);
            }
    }
public function fetchSuppliers()
{
    $data=DB::table('suppliers')->orderBy('id','DESC')->get();
    echo json_encode($data);
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
        //
        //$ids= explode('_',$id);
        $supplier = suppliers::find($id);
        return response()->json($supplier);
        /*
        $bill = DB::table('bills')
        ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
       
        ->select('bills.*','bills_details.*')
        ->where('bills.id','=',$ids[0])
        ->where('bills_details.bills_id','=',$ids[1])
        ->get();
        */
       // return response()->json($bill);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
            //
            $validator = Validator::make($request->all(),[
                'supplier_nameu' => 'required|max:255',
                'supplier_emailu' => 'required|max:255',
                'supplier_phoneu' => 'required|max:255',
                'company_nameu' => 'required|max:255',
               
    
            ]);
        if($validator->passes())
        {
          $form_data=array(
            'supplier_name' => $request->supplier_nameu,
            'supplier_email' => $request->supplier_emailu,
            'supplier_phone' => $request->supplier_phoneu,
            'company_name' => $request->company_nameu,
          );
     // Bills::where('su')
          $form_data2 = array(
          'supplier_name' => $request->supplier_nameu
          );
          Suppliers::where('id','=',$request->hidden_sup_edit)->update($form_data);
          Bills::where('supplier_name','=',$request->hidden_sup_name)->update($form_data2);
          return response()->json(['success' => 'Data Successfully Updated']);
        }
        else
            {
                return response()->json(['error' => $validator->errors()->all()]);
            }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
