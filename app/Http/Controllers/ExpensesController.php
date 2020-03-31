<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Validator;
use DB;
use DataTables;
use App\Expense_details;
use App\Expenses;
class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
          //
          $expense = $request->expense;
          $site = $request->site;
          $payment_status = $request->payment_status;
          $from_date = $request->from_date;
          $to_date = $request->to_date;
          if($request->ajax())
          {
              if($expense =='' && $payment_status =='' &&
              $site =='' && $from_date =='' && $to_date =='')
              {
                $data = DB::table('expenses')
                ->join('expense_details','expense_details.site_name','=','expenses.site')
                ->join('exp','exp.expense_name','=','expense_details.expense_name')
                ->orderBy('expenses.id','desc')->get(['expenses.*','exp.*','expense_details.*','expenses.id as first_id','expense_details.id as second_id']);
              }
              else
              {
                $query = DB::table('expenses')->join('expense_details','expense_details.site_name','=','expenses.site')
                ->join('exp','exp.expense_name','=','expense_details.expense_name');
                if(!empty($from_date))
                {
                    $query->whereBetween('expenses.date_paid',array($from_date,$to_date));
                }
                if(!empty($expense))
                {
                    $query->where('exp.expense_name','=',$expense);
                }
                if(!empty($site))
                {
                    $query->where('expenses.site','=',$site);
                }
                if(!empty($payment_status))
                {
                    $query->where('expenses.mode_payment','=',$payment_status);
                } 
                $data = $query->get(['expenses.*','exp.*','expense_details.*','expenses.id as first_id','expense_details.id as second_id']); 
              }
              
              return Datatables::of($data)->addIndexColumn()
              ->addColumn('edit',function($row){
                  $btn='<a  href="javascript:void(0)" data-toggle="tooltip"  id="'. $row->first_id .'" data-id="'. $row->second_id .'" data-original-title="Edit" class="btn btn-primary editExpenses">Edit</a>';
              
              return $btn;
          })
          ->addIndexColumn()
          ->addColumn('delete',function($row2){
            $btn2 = '<a  href="javascript:void(0)" data-toggle="tooltip"  id="'. $row2->id .'" data-id="'.$row2->id.'" data-original-title="Delete" class="btn btn-danger deleteExpenses">Remove</a>';
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

    public function insertAll()
{
    $expenses=Expenses::all();
    $total= $expenses->count();
    
       for($i=0;$i<$total;$i++)
       {
        //echo $site->site_name . '<br>';
        
        if(DB::table('exp')->where('expense_name','=',$expenses[$i]['expense'])->count()<1)
        {
       // Sites::Create(['site_name' => $expenses[$i]['site_name']]);
        DB::table('exp')->insert([
            'expense_name' => $expenses[$i]['expense'],
            'expense_description' => $expenses[$i]['description']
        ]);
        
            //return "Sites Successfully Updated";
        
      }
       }
       
    
}
public function insertNext()
{
    $expenses=Expenses::all();
    $total= $expenses->count();
    
       for($i=0;$i<$total;$i++)
       {
        //echo $site->site_name . '<br>';
       
       // Sites::Create(['site_name' => $expenses[$i]['site_name']]);
       Expense_details::Create([
        'site_name' => $expenses[$i]['site'],
        'expense_name' => $expenses[$i]['expense'],
        'quantity' => $expenses[$i]['quantity'],
        'unit_price' => $expenses[$i]['unit_price'],
        'vat' => $expenses[$i]['unit_price'],
    ]);
        
            //return "Sites Successfully Updated";
        
      
       }
       
    
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
           'expense' => 'required|max:255',
           'site_name_expense' => 'required|max:255',
           
           'expense_quantity' => 'required|max:255',
           'expense_price' => 'required|max:255',
           'mode_expense' => 'required|max:255',
           'date_paid' => 'required|max:255',
        ]);
        if($validator->passes())
        {    
            $mode = $request->mode_expense;
            $site_name = $request->site_name_expense;
            $cheque_no = $request->cheque_no;
            $mpesa_code = $request->mpesa_code;
            $bank_name = $request->expense_bank_name;
            $date_paid = $request->date_paid;
            $expense_payments = Expenses::Create([
                'site' =>$site_name,
                'mode_payment' =>$mode,
                'bank_name' => $bank_name,
                'cheque_no' =>$cheque_no,
                'mpesa_code' =>$mpesa_code,
                'date_paid' => $date_paid
            ]);
        $expense = $request->expense;
         for($count=0;$count < count($expense);$count++)
         {
            $quantity = $request->expense_quantity[$count];
            $unit_price = $request->expense_price[$count];
            $total = $unit_price * $quantity;
            $vat = 16/100 * $total;
            
            Expense_details::Create([
                'site_name' => $request->site_name_expense,
                'expense_name' => $request->expense[$count],
                'quantity' => $request->expense_quantity[$count],
                'unit_price' => $request->expense_price[$count],
                'vat' => $vat,
                'total_amount' => $total
            ]);
         }


            return response()->json(['success' => 'New Expense Successfully Added']);
        }
        else
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
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
        $ids = explode('_',$id);

        $expense = DB::table('expenses')
        ->join('expense_details','expense_details.site_name','=','expenses.site')
        ->where('expenses.id','=', $ids[0])
        ->where('expense_details.id','=',$ids[1])->first();
        return response()->json($expense);
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
          //
          $validator = Validator::make($request->all(),[
            'expenseu' => 'required|max:255',
            'site_namee' => 'required|max:255',
            'mode_expenseu' => 'required|max:255',
            'date_paidu' => 'required|max:255',
           

        ]);
    if($validator->passes())
    {
            $expense = $request->expenseu;
            $mode = $request->mode_expenseu;
            $site_name = $request->site_namee;
            $cheque_no = $request->cheque_nou;
            $mpesa_code = $request->mpesa_codeu;
            $date_paid = $request->date_paidu;
            $bank_name = $request->expense_bank_nameu;
            $quantity = $request->expense_quantityu;
            $unit_price = $request->expense_unit_costu;
            $total = $unit_price * $quantity;
            $vat = 16/100 * $total;
             $form_data=array(
                'site' =>$site_name,
                'mode_payment' =>$mode,
                'bank_name' => $bank_name,
                'cheque_no' =>$cheque_no,
                'mpesa_code' =>$mpesa_code,
                'date_paid' => $date_paid,
                );
                $form_data2=array(
                    'site_name' => $site_name,
                    'expense_name' => $expense,
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'total_amount' => $total
                );
 // Bills::where('su')
      
      Expenses::where('id','=',$request->hidden_expense_id)->update($form_data);
      Expense_details::where('id','=', $request->hidden_expense_next_id)->update($form_data2);
      //Bills::where('supplier_name','=',$request->hidden_sup_edit)->update($form_data);
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
        $data = Expenses::where('id','=',$id);
        $data->delete();
    }
}
