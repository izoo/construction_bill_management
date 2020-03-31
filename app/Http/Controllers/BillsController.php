<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use App\Exports\BillsExport;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Bills;
use App\Payment;
use App\BillsDetails;
use App\Users;
use App\Exp;
use App\Materials;
use App\Sites;
use DB;
use DataTables;
use Excel;
use Carbon\Carbon;
use PDF;
use Mail;
use DateTime;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserRequest; // including your class
class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        //
        //

        if($request->ajax())
        {
            $supplier=$request->supplier;
            $payment_status= $request->payment_status;
            $bill_status = $request->bill_status;
            $from_date = $request->from_date;
            $to_date = $request->to_date;
            $values = array($supplier,$payment_status,$bill_status,$from_date); 
            $user_logged = $request->logged_in;
            $users_select = $request->users_select;
            $days_due = $request->due_days; 
            $site = $request->site;
            $material =$request->material;
          
                //Here
                if($supplier =='' && $payment_status =='' && $bill_status ==''
                && $from_date =='' && $days_due =='' && $site =='' 
                && $material =='' && $users_select =='')
                {
                    $data = DB::table('bills')
                    ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                    ->join('materials','materials.material_name','=','bills_details.item')
                    ->orderBy('bills_details.created_at','DESC')
                    ->get(['bills.*','materials.*','bills_details.*']);
                    $data2 = DB::table('bills')
                    ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                    ->join('materials','materials.material_name','=','bills_details.item')
              
                    ->get(['bills.*','materials.*','bills_details.*']);
              
                }
                else
                {
                   
                    $query = DB::table('bills')
                    ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                    ->join('materials','materials.material_name','=','bills_details.item');
                    //->select(['ref_no',DB::raw('DATEDIFF(due_date,NOW()) as due_in')]);

                    if(!empty($supplier))
                    {
                        $query->where('bills.supplier_name','=',$supplier);
                    }
                    
                    if(!empty($from_date))
                    {
                        $query->whereBetween('date_added',array($request->from_date,$request->to_date));
                    }
                    if(!empty($users_select))
                    {
                        $query->where('bills.added_by', '=',$users_select);
                    }
                    if(!empty($payment_status))
                    {
                        if($payment_status=="paid")
                        {
                            $query->where('bills_details.amount_paid', '>',0);
                            //$query->where('bills_details.', '>',0);
                        }
                        else if($payment_status=="unpaid")
                        {
                            $query->where('bills_details.amount_paid','=',0);
                        }
                    }
                    if(!empty($site))
                    {
                        $query->where('bills.site_name', '=',$site);
                    }
                    if(!empty($material))
                    {
                        $query->where('bills_details.item', '=',$material); 
                    }
                    if(!empty($bill_status))
                    {
                        $query->where('bills_details.status','=',$bill_status);
                    }
                    if(!empty($days_due))
                    {
                      //echo $days_due;
                        $query->where(DB::raw('DATEDIFF(bills_details.due_date,NOW())'),'<=',$days_due)
                        ->where('bills_details.balance','>',0);
                        //$query->where('bills_details.days_due','<=',$days_due);
                    }
                   $data=$query->get(['bills.*','materials.*','bills_details.*']);
              }
           
       /*
        
       */
 //$id2=$data2->id;
 //echo $id2;
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('edit',function($row) use($user_logged){
                if($user_logged=='moha')
      {
        $return = '<li role="presentation"><a  href="javascript:void(0)" data-toggle="tooltip"  id="'.$row->ref_no.'" data-id="'.$row->id.'" data-original-title="Return" class="returnBill">Return</a></li>';
          $return_remove = '<li role="presentation"><a  href="javascript:void(0)" data-toggle="tooltip"  id="'.$row->ref_no.'" data-id="'.$row->id.'" data-original-title="Delete" class="deleteBill">Remove</a></li>';
      }
      else
      {
        $return_remove = '<li role="presentation"><a  href="javascript:void(0)" data-toggle="tooltip"  id="'.$row->ref_no.'" data-id="'.$row->id.'" data-original-title="Return" class="returnBill">Return</a></li>';

      $return = ' ';
    }
    if($row->added_by=='moha')
    {
        $return_approve = '';
    }
    else if($row->added_by !=='moha' && $row->status=="pending")
    {
        
        $return_approve = '<li role="presentation"><a  href="javascript:void(0)" data-toggle="tooltip"  id="'.$row->ref_no.'" data-id="'.$row->id.'" data-original-title="Approve" class="approveBill">Approve</a></li>';


    }
    else
{
    $return_approve = ''; 
}
                $btn=' <div class="dropdown">
                
                <button class="btn btn-primary dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">Action
               </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                  <li role="presentation"> <a  href="javascript:void(0)" data-toggle="tooltip"  id="'.$row->ref_no.'" data-id="'.$row->id.'" data-original-title="Edit" class="edit editBill">Edit</a></li>
                 '. $return .'
                  ' . $return_remove .'
                  ' . $return_approve .'
       
                </ul>
              </div> ';
            
            return $btn;
        })
        ->addIndexColumn()
        ->addColumn('status_new',function($row2){
            if($row2->status=="approved")
            {
                $btn2 = '<b class="text-success">' . $row2->status . '</b>';
            }
            else
            {
                $btn2 = '<b class="text-danger">' . $row2->status . '</b>';
            }
          
        return $btn2;
      })
      ->addIndexColumn()
      ->addColumn('days',function($row3){
        $date1 =  new DateTime(date('Y-m-d'));
        $date12 =  new DateTime(date('Y-m-d'));
        $date2 = new DateTime($row3->due_date);
        $interval = $date1->diff($date2);
        $interval = $interval->format('%r%a');
        $interval2 = $date12->diff($date2);
        $interval2 = $interval2->format('%a');
        $days = null;
        if($interval<0 && $row3->balance>0)
        {
          $days = '<b class="text-danger"> ' . $interval2 . ' Days Overdue</b>';
        }
        else if($interval>0 && $row3->balance>0)
        {
           $days = $interval;
        }
        else if($row3->balance==0)
        {
          $days = '<b class="text-success">Paid</b>';
        }
        else
        {
            $days = $interval2;
        }
        return $days;
      })
        ->rawColumns(['days','edit','status_new'])
        
        ->make(true);
    }
    
        return view('admin.dashboard.construction_admin',compact('data'));

    }


 public function returnBill(Request $request)
 {
     $form_data = array(
         'return_status' => 'returned'
     );
 
    $id= $request->return_id;
    BillsDetails::where('ref_no','=',$id)->update($form_data);
    
 }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pending(Request $request)
    {
        //
         
        if($request->ajax())
        {
            $data = Payments::latest()->where('balance','>',0)->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('edit',function($row){
                $btn='';
            
            return $btn;
        })
        ->addIndexColumn()
        ->addColumn('delete',function($row2){
          $btn2 = ' ';
        return $btn2;
      })
        ->rawColumns(['edit','delete'])
        
        ->make(true);
        }
        return $data;
         
         return view('admin.dashboard.construction_admin',compact('dat'));
    }
    public function fetchSites()
    {
        $data2=Sites::distinct()->orderBy('id','DESC')->get(['site_name','id','created_at']);
        echo json_encode($data2);
    }
    public function fetchExpenses()
    {
        $data2=DB::table('exp')->distinct()->orderBy('id','DESC')->get(['expense_name','id','created_at']);
        echo json_encode($data2);
    }
    public function paid(Request $request)
    {
        //
         
        if($request->ajax())
        {
            
                $supplier = $request->supplierp;
                $site_name = $request->sitep;
                $material_name = $request->materialp;
                $payment_status = $request->paymentp;
                $from_date = $request->from_datep;
                $to_date = $request->to_datep;
            if($supplier =='' && $site_name=='' && $material_name==''
             && $payment_status == '' && $from_date=='' && $to_date=='' )
             {
                $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                ->join('payments','payments.payment_id','=','bills_details.id')
                ->select('bills.*','bills_details.*','payments.*')
                ->orderBy("bills_details.created_at", "desc")
                ->get();  
            
             }
             else
             {
                 $query = DB::table('bills')
                 ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                 ->join('payments','payments.payment_id','=','bills_details.id');
                 if(!empty($from_date))
                 {
                    $query->whereBetween('date_payment',array($request->from_datep,$request->to_datep));

                 }
                 if(!empty($supplier))
                 {
                     $query->where('bills.supplier_name','=',$supplier);
                 }
                 if(!empty($site_name))
                 {
                     $query->where('bills.site_name','=',$site_name);
                 }
                 if(!empty($material_name))
                 {
                     $query->where('bills_details.item','=',$material_name);
                 }
                 if(!empty($payment_status))
                 {
                   $query->where('payments.mode_payment','=',$payment_status);
                 }
                 
                 $data=$query->get(['bills.*','bills_details.*','payments.*']);

             }
                

                
            
            
                
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('revert',function($row){
                $btn='<a  href="javascript:void(0)" data-toggle="tooltip"  id="'.$row->id.'" data-id="'. $row->payment_id .'" data-original-title="Edit" class="btn btn-primary confirmRevert"><i class="fa fa-undo"></i>Revert</a>';
            
            return $btn;
        })
        ->addIndexColumn()
        ->addColumn('delete',function($row2){
          $btn2 = '';
        return $btn2;
      })
        ->rawColumns(['revert','delete'])
        
        ->make(true);
        }
        return $data;
         
         return view('admin.dashboard.construction_admin',compact('dat'));
    }
    public function revertPayment(Request $request)
    {
       $id = $request->id;
       $payment_id = $request->payment_id;
       $data = DB::table('payments')->where('id','=',$id)->first();
       $data->amount_paid;
       $data2=DB::table('bills_details')->where('id','=',$payment_id)->first();
       $new_amount_paid = $data2->amount_paid - $data->amount_paid;
       $balance = $data2->total_cost - $new_amount_paid;
       $form_data = array(
           'amount_paid' => $new_amount_paid,
           'balance' => $balance,
           'pending_bank_amount' => $new_amount_paid,
           'pending_bank_balances' => $balance
       );
    if(DB::table('bills_details')->where('id','=',$payment_id)->update($form_data) && DB::table('payments')->where('id','=',$id)->delete())
    {
        echo "ok";
    }
    }
    public function printExcel()
    {
        //$sup=$request->supplier;
        $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                ->join('materials','materials.material_name','=','bills_details.item')
                ->select('bills.*','bills_details.*','materials.*')
                
                ->get()->toArray();
               $supplier_array=[];
               $total = 0;
                $header="                     All  Suppliers Materials ";
                $supplier_array[] = array($header ,' ',' ',' Supplied Items',' ',' ',' ',' ');
                
                $supplier_array[] = array('Supplier','Material','Description','Site','Ref NO','Added on','quantity','unit cost','vat','total cost');
                
                foreach($data as $dat)
                {
                    $supplier_array[]=array('Supplier' => $dat->supplier_name,
                    'Material' => $dat->item,
                    'Description' => $dat->mat_description,
                    'Site' => $dat->site_name,
                    'Ref No' => $dat->ref_no,
                    'Added on' => $dat->date_added,
                    'quantity' => number_format($dat->quantity),
                    'unit cost' => number_format($dat->price),
                    
                    'vat' => number_format($dat->vat),
                    'total cost' => number_format($dat->total_cost),
                   
                );
                $total += $dat->total_cost;
                }
                $supplier_array[]= array('Supplier' => '',
                    'Material' => '',
                    'Description' => '',
                    'Site' => '',
                    'Ref No' => '',
                    'Added on' => '',
                    'quantity' => '',
                    'unit cost' => '',
                    
                    'vat' => '',
                    'total cost' => " TOTAL "  .  number_format($total)
                );
                $sup_data = "All" . date("Y-m-d  h:i:sa");
                Excel::create($sup_data, function($excel) use ($supplier_array,$sup_data){
                    // Set the title
                    $excel->setTitle('FileName');
                 //   $xcel->sheet('SheetName')
                 //$excel->getActiveSheet()->mergeCells('A1:C1');
                 
                    $excel->sheet('Supplier Details', function($sheet) use ($supplier_array){
                        $sheet->mergeCells('A1:J1');

                        // add some text
                        $sheet->getCell('E1');
                        $sheet->setCellValue('E1','The quick brown fox.'); 
                        //$sheet->setValue("J2",SUM(J2))
                    $sheet->fromArray($supplier_array, null, 'A1', false, false);
                     
                    });
                   })->download('xlsx');
    }
    public function SupplierData(Request $request)
    {
        
        //$supplier=$_POST['id'];
        if($request->ajax())
        {
            $data = Bills::latest()->take(1)->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('edit',function($row){
                $btn='<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editBill">Edit</a>';
            
            return $btn;
        })
        ->addIndexColumn()
        ->addColumn('delete',function($row2){
          $btn2 = ' <a href="javascript:void(0)" data-toggle="tooltip"  id="'.$row2->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteBill">Remove</a>';
        return $btn2;
      })
        ->rawColumns(['edit','delete'])
        
        ->make(true);
        }
        return $data;
    }
   
 public function convert_customer_data_to_html(Request $request)
    {
       // $supplier = $_GET['supplier'];
        if($request->supplier)
        {
            $supplier_name=$request->supplier;
            $data= DB::table('bills')
            ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
            ->select(DB::raw('SUM(total_cost) AS total'))->where('supplier_name',$supplier_name)->first();
              $total=$data->total;
              $data1= DB::table('bills')
              ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
              ->select(DB::raw('SUM(amount_paid) AS paid'))->where('supplier_name',$supplier_name)->first();
                $paid=$data1->paid;
              
            $supplier = $request->supplier;
            $customer_data = DB::table('bills')
     ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
     ->select('bills.*','bills_details.*')->where('supplier_name','=',$supplier)->get();
   
    }
        else
        { 
            $supplier = "All Suppliers ";
            $customer_data = DB::table('bills')
            ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
            ->select('bills.*','bills_details.*')->get();
          
        }
    
        $output = '<body style="font-family: Verdana, Arial, sans-serif;">
        <div class="information" style="background-color: #60A7A6;color: #FFF;">
        <h3 style="color:#000;text-align:center;border-bottom-color: rgb(170, 50, 220, .6);">EASTLINE COMPANY LIMITED </h3>
    <table style="font-size: x-small;padding: 10px;" width="100%">
        <tr>
            <td align="left" style="width: 40%;">
                <h3> ' . $supplier . '</h3>
                <pre>
Street 15
123456 Kenya
Nairobi Eastleigh
<br /><br />
Date: '. date("l jS \of F Y h:i:s A") .'
Identifier: #'. rand() .'

</pre>


            </td>
            <td align="center">
                <img src="public/uploads/maurer-1020143_640.jpg" alt="Logo" width="64" class="logo"/>
            </td>
            
        </tr>

    </table>
</div>


<br/>

<div class="invoice">
<h3 style="margin-left: 15px;text-align:center;">' . $supplier . ' Invoice Details</h3>
        <table width="100%" style="border-collapse: collapse; border: 0px; margin: 15px;">
         <thead>
        <tr style="font-weight: bold; font-size: x-small;">
       <th style="border: 1px solid; padding:12px;" width="30%">Amount Due</th>
       <th style="border: 1px solid; padding:12px;" width="15%">Amount Paid</th>
       <th style="border: 1px solid; padding:12px;" width="15%">Balance</th>
       <th style="border: 1px solid; padding:12px;" width="15%">Status</th>
      </tr>
      </thead>
      <tbody>
        ';  
        foreach($customer_data as $customer)
        {
            $balance = $customer->balance;

            if($balance >0)
            {
                $status = 0;
                $status = "<span style='color:red;'>Pending</span>";
            }
            else if($balance <= 0)
            {
               $status = "<span style='color:green;'>Paid</span>";
            }
         $output .= '
         <tr style="font-weight: bold; font-size: x-small;">
         
          <td style="border: 1px solid; padding:12px;">Kshs '.number_format($customer->total_cost).'</td>
          <td style="border: 1px solid; padding:12px;">Kshs '.number_format($customer->amount_paid).'</td>
          <td style="border: 1px solid; padding:12px;">Kshs '.number_format($customer->balance).'</td>
          <td style="border: 1px solid; padding:12px;">'.$status.'</td>
         </tr>
         ';
        }
        $output .= '</tbody> <tfoot style="font-weight: bold; font-size: x-small;">
        <tr>
            <td colspan="1"></td>
            <td align="left">Total Kshs '. number_format($total) .'</td>
            <td align="left" class="gray">Amount Due Kshs '. number_format($paid) .'</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot></table></div>
        
<div class="information" style="position: absolute; bottom: 0;">
<table width="100%">
    <tr>
        <td align="left" style="width: 50%;">
            &copy; {{  ' . date('Y') . ' }} {{ ' . config('app.url') . ' }} All rights reserved.
        </td>
        <td align="right" style="width: 50%;">
            Company Slogan
        </td>
    </tr>

</table>
</div>'; 
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($output);
     return $pdf->stream();
    }
    public function create()
    {
        //
    }
    public function resetPassword(Request $request)
    {
         //
         $validator=  Validator::make($request->all(),[
            'new_email' => 'required|max:255',
            'old_password' => 'required|max:255',
            'new_password' => 'required|max:255',
            'confirm_password' => 'required|same:new_password',
           
            
      ]);
    if($validator->passes())
    {
    $check = DB::table('admins')->where('email','=',$request->new_email)->first();
  echo $request->new_email;
  
    if($check->email==$request->new_email)
    {
       if(Hash::check($request->old_password,$check->password))
       {
           //echo $new_password
        $form_data =array(
            'email' => $request->new_email,
           'password' =>   Hash::make($request->new_password), 
        );
       DB::table('admins')->where('email','=',$request->new_email)->update($form_data);
       return "success";
       }
       else
       {
        $validator->getMessageBag()->add('old', 'Old Password Not Correct');
        return response()->json(['error' => $validator->errors()->all()]);

     }
    }
    else
    {
        $validator->getMessageBag()->add('email', 'Wrong Email,Enter Correct Email');
        return response()->json(['error' => $validator->errors()->all()]);

    }
      

    }
    else
        {
            return response()->json(['error' => $validator->errors()->all()]);
        }
    }
    public function exportExcel(Request $request)
    {
        $sup=$request->supplier;
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $paid = $request->paid;
        $pending = $request->pending;
        if(!empty($sup))
        {
        $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                ->join('materials','materials.material_name','=','bills_details.item')
                ->select('bills.*','bills_details.*','materials.*')
              
                ->where('bills.supplier_name','=',$sup)
                ->get()->toArray();
        }
        else if(!empty($sup) && !empty($from_date) && !empty($paid))
        {
            $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
               
                ->select('bills.*','bills_details.*','materials.*')
               
                ->whereBetween('date_added',array($request->from_date,$request->to_date))
                ->where('bills.supplier_name','=',$sup)
                ->where('balance','<=',0)
                ->get()->toArray();
        }
        else if(!empty($sup) && !empty($from_date) && !empty($pending))
        {
            $data = DB::table('bills')
            ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
            ->join('materials','materials.material_name','=','bills_details.item')
            ->select('bills.*','bills_details.*','materials.*')
            ->whereBetween('date_added',array($request->from_date,$request->to_date))
            ->where('bills.supplier_name','=',$sup)
            ->where('balance','>',0)

            ->get()->toArray();
        }
        //else if()
        
               $supplier_array=[];
               $total = 0;
               $balance = 0;
               $amount_paid =0;
                $header="                    " .  $sup . "  Supplied Materials ";
                $supplier_array[] = array($header ,' ',' ',' Supplied Items',' ',' ',' ',' ');
                
                $supplier_array[] = array('Supplier','Material','Description','Site','Ref NO','Added on','quantity','unit cost','vat','total cost','balance','amount paid');
                
                foreach($data as $dat)
                {
                    $supplier_array[]=array('Supplier' => $dat->supplier_name,
                    'Material' => $dat->item,
                    'Description' => $dat->mat_description,
                    'Site' => $dat->site_name,
                    'Ref No' => $dat->ref_no,
                    'Added on' => $dat->date_added,
                    'quantity' => number_format($dat->quantity),
                    'unit cost' => number_format($dat->price),
                    
                    'vat' => number_format($dat->vat),
                    'total cost' => number_format($dat->total_cost),
                    'balance' => number_format($dat->balance),
                    'amount paid' => number_format($dat->amount_paid),
                );
                $total += $dat->total_cost;
                $balance +=$dat->balance;
                $amount_paid += $dat->amount_paid;
                }
                $supplier_array[]= array('Supplier' => '',
                    'Material' => '',
                    'Description' => '',
                    'Site' => '',
                    'Ref No' => '',
                    'Added on' => '',
                    'quantity' => '',
                    'unit cost' => '',
                    
                    'vat' => '',
                    'total cost' => " TOTAL  Kshs "  .  number_format($total),
                    'balance' => " TOTAL Kshs " .number_format($balance),
                    'amount paid' => " TOTAL  Kshs " .number_format($amount_paid),
                );
                $sup_data = $sup . date("Y-m-d  h:i:sa");
                Excel::create($sup_data, function($excel) use ($supplier_array,$sup_data){
                    // Set the title
                    $excel->setTitle('FileName');
                 //   $xcel->sheet('SheetName')
                 //$excel->getActiveSheet()->mergeCells('A1:C1');
                 
                    $excel->sheet('Supplier Details', function($sheet) use ($supplier_array){
                        $sheet->mergeCells('A1:J1');

                        // add some text
                        $sheet->getCell('E1');
                        $sheet->setCellValue('E1','The quick brown fox.'); 
                        //$sheet->setValue("J2",SUM(J2))
                    $sheet->fromArray($supplier_array, null, 'A1', false, false);
                     
                    });
                   })->download('xlsx');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255|',
            'user_name' => 'required|max:255|unique:users',
            'phone_number' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'role_select_user' => 'required|max:255',
            'user_password' => 'required|max:255',
            'user_confirm_password' => 'required|max:255|same:user_password',
          
          ],
          [
            'email.unique' => 'Email Already Exists',
            'user_name.unique' => 'Username Already Exists',
            'user_confirm_password.same'=>'Password Mismatch'
        ]);

        if($validator->passes())
        {
            //Bills::find();
         // $check = Bills::where('ref_no','=',$request->ref_no)->first();
            $users = Users::Create([
                
                'name' => $request->name,
                'user_name' => $request->user_name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'role_id'=> $request->role_select_user,
                'password' => Hash::make($request->user_password),
               
            ]);
            /*
            //$data['title'] = "Message From Eastline Construction ";
            $email = $request->user_email;
            $name = $request->name;
            $data = [
                'email' => $email,
                'password' => $request->user_password
            ];
            Mail::send('admin.sendmail',["data1"=>$data], function($message) use ($email,$name){
                $message->to($email,$name)
                ->subject('Your Email and Password');
            });
            if(Mail::failures())
            {
                return response()->Fail('Sorry!Please try again latter');
            }
            else
            {
                return response()->json('Yes,You have sent email from Eastline');
            }
            */
            //BillsDetails::insert($insert_data);
                return response()->json(['success' => 'New User Successfully Registered']);
            }
            else
            {
                return response()->json(['error_user' => $validator->errors()->all()]);
            }

    }
    public function fetchUsers(Request $request)
    {

        if($request->ajax())
        {
            
            $data = Users::join('roles','roles.id','=','users.role_id')->orderBy('users.created_at','DESC')->get(['roles.*','users.*']);
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('edit',function($row){
                $btn='<a  href="javascript:void(0)" data-toggle="tooltip"  id="'. $row->id .'" data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary editUser">Edit</a>';
            
            return $btn;
        })
        ->addIndexColumn()
        ->addColumn('delete',function($row2){
          $btn2 = '<a  href="javascript:void(0)" data-toggle="tooltip"  id="'. $row2->id .'" data-id="'.$row2->id.'" data-original-title="delete" class="btn btn-danger deleteUser">Remove</a>';
        return $btn2;
      })
      ->addIndexColumn()
        ->addColumn('change',function($row3){
          $btn3 = '<a  href="javascript:void(0)" data-toggle="tooltip"  id="'. $row3->id .'" data-id="'.$row3->id.'" data-original-title="activate" class="btn btn-success changePassword">Change Password</a>';
        return $btn3;
      })
      
        ->rawColumns(['edit','delete','change'])
        
        ->make(true);
        }
        
        //return view('admin.dashboard.construction_admin',compact('data'));
    }
    public function fetchUsersData()
    {
        $data=DB::table('users')->orderBy('id','DESC')->get();
        echo json_encode($data);
    }
     public function fetchVat(Request $request)
    {
        $supplier = $request->name;
        if(!empty($supplier) && empty($request->from_date))
        {
        $data= DB::table('bills_details')->select(DB::raw('SUM(vat) AS total_vat,SUM(total_cost) AS total'))->where('supplier',$supplier)->get();
        $count= DB::table('bills_details')->select(DB::raw('SUM(vat) AS total_vat'))->where('supplier',$supplier)->count();
        if($count>0)
        {
            echo json_encode($data);
        }
      }
    else if(!empty($request->from_date) && empty($supplier))
            {
                
                
                $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                ->whereBetween('date_added',array($request->from_date,$request->to_date))->sum('bills_details.vat');
                echo $data;
            }
            else if(!empty($supplier) && !empty($request->from_date))
            {
                $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                ->whereBetween('date_added',array($request->from_date,$request->to_date))
                ->where('supplier',$supplier)
                ->sum('bills_details.vat');
            }
        else
        {
            $data = DB::table('bills_details')->sum('bills_details.vat');
            echo $data;
        }
    
}
    public function fetchTotal(Request $request)
    {
        $supplier=$request->supplier;
        $supplier=$request->supplier;
        $payment_status= $request->payment_status;
        $bill_status = $request->bill_status;
        $from_date = $request->from_date;
        $values = array($supplier,$payment_status,$bill_status,$from_date); 
        $user_logged = $request->logged_in;
        $users = $request->users;
        if(!empty($supplier) && empty($request->from_date) && empty($request->payment_status) &&  empty($request->bill_status) && empty($users))
        {
            $data = DB::table('bills')
            ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
            ->where('bills.supplier_name',$supplier)
            ->sum('bills_details.total_cost');
       
        
            //echo "One";
            echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";

        
      }
      if(!empty($users) && empty($supplier) && empty($request->from_date) && empty($request->payment_status) &&  empty($request->bill_status))
      {
          $data = DB::table('bills')
          ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
          ->where('bills.added_by',$users)
          ->sum('bills_details.total_cost');
      $count= DB::table('bills')
      ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no') 
      ->select(DB::raw('SUM(total_cost) AS total'))->where('bills.supplier_name',$supplier)->count();
      
          //echo "One";
          echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";

      
    }
      else if(!empty($request->payment_status) && !empty($supplier) && empty($from_date) && empty($bill_status) && empty($users))
                {
                    $supplier=$request->supplier;
                    $from_date=$request->from_date;
                    $to_date=$request->to_date;
                    $payment_status= $request->payment_status;
                    $bill_status = $request->bill_status;
                    $users = $request->users;
                   if($payment_status=="paid")
                   {
                       
                    $data = DB::table('bills')
            ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
            ->where('bills.supplier_name',$supplier)
            ->where('bills_details.balance','=',0)
          
            ->sum('bills_details.total_cost');
            echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";
                    
                   }
                   else if($payment_status=="unpaid")
                   {
                    $data = DB::table('bills')
                    ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                    ->where('bills.supplier_name',$supplier)
                    ->where('bills_details.balance','>',0)
                    
                    ->sum('bills_details.total_cost');
                    echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";
                   }
                   
                
                }
                else if(!empty($request->payment_status) && empty($supplier) && !empty($from_date) && empty($bill_status) && empty($users))
                {
                    $supplier=$request->supplier;
                    $from_date=$request->from_date;
                    $to_date=$request->to_date;
                    $payment_status= $request->payment_status;
                    $bill_status = $request->bill_status;
                    $users = $request->users;
                   if($payment_status=="paid")
                   {
                       
                    $data = DB::table('bills')
            ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
            ->where('bills_details.balance','=',0)
           
            ->whereBetween('date_added',array($request->from_date,$request->to_date))
            ->sum('bills_details.total_cost');
            echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";
                    
                   }
                   else if($payment_status=="unpaid")
                   {
                    $data = DB::table('bills')
                    ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                    ->where('bills_details.balance','>',0)
                    ->whereBetween('date_added',array($request->from_date,$request->to_date))
                    ->sum('bills_details.total_cost');
                    echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";
                   }
                   
                
                }
                else if(!empty($request->payment_status) && empty($supplier) && empty($from_date) && empty($bill_status) && empty($users))
                {
                    $supplier=$request->supplier;
                    $from_date=$request->from_date;
                    $to_date=$request->to_date;
                    $payment_status= $request->payment_status;
                    $bill_status = $request->bill_status;
                    $users = $request->users;
                   if($payment_status=="paid")
                   {
                       
                    $data = DB::table('bills')
            ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
            ->where('bills_details.balance','=',0)
            ->sum('bills_details.total_cost');
            echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";
                    
                   }
                   else if($payment_status=="unpaid")
                   {
                    $data = DB::table('bills')
                    ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                    ->where('bills_details.balance','>',0)
                    ->sum('bills_details.total_cost');
                    echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";
                   }
                   
                
                }
   else if(!empty($request->from_date) &&  empty($request->supplier) && empty($request->payment_status) &&  empty($request->bill_status))
            {
                
                //echo "One";
                $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                ->whereBetween('date_added',array($request->from_date,$request->to_date))->sum('bills_details.total_cost');
                echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";

            }
            else if(!empty($request->from_date) && !empty($supplier) && empty($request->payment_status) &&  empty($request->bill_status))
            { 
               // echo "Both data and supplier";
                $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                ->whereBetween('date_added',array($request->from_date,$request->to_date))
                ->where('bills.supplier_name',$supplier)
                ->sum('bills_details.total_cost');
                echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";
            }
            else if(!empty($request->bill_status) && empty($request->from_date) && empty($supplier) && empty($request->payment_status))
            { 
               // echo "Both data and supplier";
                $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                
                ->where('bills_details.status','=',$bill_status)
                ->sum('bills_details.total_cost');
                echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";
            }
            else if(!empty($request->pending) && empty($supplier) && empty($request->from_date) &&  empty($request->paid))
            { 
               // echo "Both data and supplier";
                $data = DB::table('bills')
                ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                ->whereBetween('date_added',array($request->from_date,$request->to_date))
                ->where('bills.supplier_name',$supplier)
                ->where('balance','>',0)
                ->sum('bills_details.total_cost');
                echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";
            }
        else if(empty($supplier) && empty($request->from_date) && empty($request->payment_status) &&  empty($request->bill_status) && empty($users))
        {
            $data = DB::table('bills')
            ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
            ->sum('bills_details.total_cost');
            echo "Total Cost Kshs<strong style='font-size:18px'> " .  number_format($data) . "</strong>";

        }
     
    }
    public function addedBy(Request $request)
    {
        $logged=$request->logged;
        $users_count = DB::table('bills')
                    ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
                    ->where('added_by', '=', $logged)->get();
       
$count = $users_count->count();
echo  $count ;
    }
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            'mat' => 'required|max:255',
            'supplier' => 'required|max:255',
            'quantity' => 'required|max:255',
            'ref_no'  => 'required|max:255',
            'unit_cost' => 'required|max:255',
            'site_name_select' => 'required|max:255',
            'date_added' => 'required|max:255'

          ]);

        if($validator->passes())
        {
         $ref_no = $request->ref_no;
         if(Bills::where('ref_no','=',$ref_no)->count() == 0)
         {
                $bills = Bills::Create([
                'supplier_name' => $request->supplier,
                'site_name' => $request->site_name_select,
                'ref_no' => $request->ref_no,
                'added_by' => $request->logged_in,
                'date_added' => $request->date_added
            ]);
         }
            $item = $request->mat;
            for($count=0;$count < count($item);$count++)
            {
                $unit_cost = $request->unit_cost[$count];
                $quantity = $request->quantity[$count];
                $total = $unit_cost * $quantity;
                $vat = 16/100 * $total;
                $total_cost = $total ;
                $amount_paid=0;
                $days=$request->due[$count];
                $date_added=$request->date_added;
                $due_date = date('Y-m-d',strtotime($date_added . '+ '.$days.' days'));
                $data =array(
                    
                    'item' => $request->mat[$count],
                    'price' => $request->unit_cost[$count],
                    'quantity' => $request->quantity[$count],
                    'ref_no' => $request->ref_no,
                    'total_cost' => $total_cost,
                    'balance' => $total_cost,
                    'amount_paid' => $amount_paid,
                    'vat' => $vat,
                    'status' => 'approved',
                    'due_date' => $due_date,
                    'pending_bank_amount' => 0,
                    'pending_bank_balances' => $total_cost,


                );
                $insert_data[] = $data;
            }
            BillsDetails::insert($insert_data);
                return response()->json(['success' => 'New Bill Successfully Registered']);
         
            
            
            }
            else
            {
                return response()->json(['error' => $validator->errors()->all()]);
            }


    }
    public function returnLatest()
    {
        //->select(DB::raw('SUM(total_cost) AS total'))
        $bills_latest = DB::table('bills_details')
        ->select(['ref_no',DB::raw('DATEDIFF(due_date,NOW()) as due_in')])
        ->where('balance','>',0)
        //->where('payment_clearance_status','=','')
        ->whereNotNull('due_date')
        ->where(DB::raw('DATEDIFF(due_date,NOW())'),'<=',50)
        ->orderBy(DB::raw('DATEDIFF(due_date,NOW())'),'asc')
        ->get();
        //ech
         echo json_encode($bills_latest);

    }
    public function storeBills(Request $request)
    {
        //
          //

          $validator = Validator::make($request->all(),[
            'mat' => 'required|max:255',
            'supplier' => 'required|max:255',
            'quantity' => 'required|max:255',
            'unit_cost' => 'required|max:255',
            'site_name' => 'required|max:255',
            

          ]);

        if($validator->passes())
        {
            //Bills::find();]'
            
           // echo $name;
         // $check = Bills::where('ref_no','=',$request->ref_no)->first();
            $bills = Bills::Create([
                
                'supplier_name' => $request->supplier,
                'site_name' => $request->site_name,
                'ref_no' => $request->ref_no,
                'added_by' => $request->logged_in,
                'date_added' => $request->date_added
               
            ]);
            $item = $request->mat;
            for($count=0;$count < count($item);$count++)
            {
                $unit_cost = $request->unit_cost[$count];
                $quantity = $request->quantity[$count];
                $total = $unit_cost * $quantity;
                $vat = 16/100 * $total;
                $total_cost = $total ;
                $amount_paid=0;
                $days=$request->due[$count];
                $date_added=$request->date_added;
                $due_date = date('Y-m-d',strtotime($date_added . '+ '.$days.' days'));

                //$random= rand();
                //$id_bill= substr(0,4,$random);
                $data =array(
                    
                    'item' => $request->mat[$count],
                    'price' => $request->unit_cost[$count],
                    'quantity' => $request->quantity[$count],
                    'ref_no' => $request->ref_no,
                    'total_cost' => $total_cost,
                    'balance' => $total_cost,
                    'amount_paid' => $amount_paid,
                    'vat' => $vat,
                    'status' => 'pending',
                    'due_date' => $due_date,
                    'pending_bank_amount' => 0,
                    'pending_bank_balances' => $total_cost,

                );
                $insert_data[] = $data;
            }
            BillsDetails::insert($insert_data);
                return response()->json(['success' => 'New Bill Successfully Registered']);
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
        $ids= explode('_',$id);
        //echo $ids[1];
        $bill = Bills::join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
        ->where('bills_details.id','=',$ids[1])
            ->first();
            //echo $bill->id;
        /*
        $bill = DB::table('bills')
        ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
       
        ->select('bills.*','bills_details.*')
        ->where('bills.id','=',$ids[0])
        ->where('bills_details.bills_id','=',$ids[1])
        ->get();
        */
        return response()->json($bill);
    }
    public function approveBill(Request $request)
    {
        $approve = $request->approve_id;
        $form_data = array(
            'status' => 'approved'
        );
        BillsDetails::where('id','=',$approve)->update($form_data);
    }
    public function editPaid(Request $request)
    {
        $bill_id = $request->hidden_edit_paid_id;
        $amount_paid = $request->amount_edit_paid;
       $amount_due=  $request->amount_edit_due;
       $balance= $amount_due - $amount_paid;
       
        $form_data = array(
            'amount_paid' => $amount_paid,
            'balance' => $balance
        );
        BillsDetails::where('id','=',$bill_id)->update($form_data);
    }
    public function showBill(Request $request)
    {
        //
        $ids= $request->approve_id;
        //echo $ids[1];
        $bill = Bills::join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
     ->where('bills_details.id','=',$ids)
         ->first();
            //echo $bill->id;
        /*
        $bill = DB::table('bills')
        ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
       
        ->select('bills.*','bills_details.*')
        ->where('bills.id','=',$ids[0])
        ->where('bills_details.bills_id','=',$ids[1])
        ->get();
        */
        return response()->json($bill);
    }
    public function editUser(Request $request)
    {
        //
        $ids= $request->user_id;
        //echo $ids[1];
        $users = Users::join('roles','users.role_id','=','roles.id')->where('users.id','=',$ids)->first();
            //echo $bill->id;
        /*
        $bill = DB::table('bills')
        ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
       
        ->select('bills.*','bills_details.*')
        ->where('bills.id','=',$ids[0])
        ->where('bills_details.bills_id','=',$ids[1])
        ->get();
        */
        return response()->json($users);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewPayment(Request $request)
    {
        $ref_no = $request->ref_no;
        $data = DB::table('bills')
        ->join('payments','payments.ref_no', '=', 'bills.ref_no')
        ->select('bills.*','payments.*')->where('bills.ref_no',$ref_no)
        ->orderBy("bills.id", "desc")
        ->get();
        echo json_encode($data);

    }
    public function allBills(Request $request)
    {
        
        if($request->ajax())
        {
            $data = DB::table('bills')
            ->join('bills_details','bills_details.ref_no', '=', 'bills.ref_no')
            // ->join('payments','payments.payment_id','=','bills_details.id')
            ->select('bills.*','bills_details.*') 
            ->where('bills_details.pending_bank_balances','>',0)
            ->orderBy("bills.created_at", "desc")
            ->get();
            //  //echo $data->id;
            //  $data2 = DB::table('bills_details')
            //  ->join('payments','payments.payment_id','=','bills_details.id')
            //  ->select('bills_details.*','payments.*')
            //  ->where('payments.payment_id','=',$data->id)
            //  ->where('payments.mode_payment','=','Bank')
            //  ->where('payments.payment_clearance','=','pending')
            //  ->get();

            return Datatables::of($data)->addIndexColumn()
            ->addColumn('edit',function($row){
                $btn='<input type="checkbox" class="add-payment" id="'.$row->id.'"  value="'.$row->balance.'" name="select-pay">
                <input type="text" style="" max="'. $row->balance .'" id="'. $row->balance .'" class="change-amount" value="'.$row->balance .'"  name="'.$row->id.'">
                <input type="hidden" style="" class="change-ref" value="'.$row->ref_no .'"  name="'.$row->id.'">
                <input type="hidden" style="" class="change-sup" value="'.$row->supplier_name.'"  name="'.$row->id.'">';
            
            return $btn;
        })
      
      ->addIndexColumn()
        ->addColumn('new',function($row3){
          $btn3 = '<span><a><i class="fa fa-pencil"></i></a></span>';
        return $btn3;
      })
        ->rawColumns(['edit'])
        
        ->make(true);
        }
        return $data;
    }
    public function payAlways()
    {
        $today = Carbon::today()->format("Y-m-d");
        
        $ids =  DB::table('payments')
        ->where('payment_clearance_status','=','Pending')
        ->where('cleared_on', '<=',$today)
        ->pluck('payment_id')->toArray();
        //$count = $query->count();
       $ids2 =  DB::table('payments')
       ->where('payment_clearance_status','=','Pending')
       ->where('cleared_on', '<=',$today)
       ->pluck('id')->toArray();
      // $count2  = $data2->count();
       for($i=0;$i<count($ids);$i++)
       {
            $bill_payment = Payment::find($ids2[$i]);
            $bills = BillsDetails::find($ids[$i]);
            $total_paid = $bill_payment->amount_paid + $bills->amount_paid;
            $new_balance = $bills->total_cost - $total_paid;
            
            $form_data = array(
                'amount_paid' => $total_paid,
                'balance' => $new_balance,
                
            );
            $form_data2 = array(
                'payment_clearance_status' => 'Cleared'
            );
            BillsDetails::where('id','=',$ids[$i])->update($form_data); 
            Payment::where('id','=',$ids2[$i])
            ->where('payment_clearance_status','=','pending')
            ->where('cleared_on', '<=',$today)
            ->update($form_data2); 
       }
        
        
    }
    public function payMultiple(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'mode' =>'required'
           
        ],[
            'mode.required' => 'Mode Required'
        ]);
        if($validator->passes())
        {
            if(!empty($request->total) && !empty($request->balance) && !empty($request->ids))
            {
                //echo $request->ids;
               // $total = $request->total;
                //$balance = array($request->balance);
                $ids =  $request->ids;
                $mode = $request->mode;
                $posting_date = $request->posting_date;
                $clearing_date = $request->clearing_date;
                $date_payment = $request->date_payment;
               //$ids = array();
              // $new_ids =array_push($ids,$request->ids);
               // print_r($new_ids);
               //$new_ids = array_map('intval',$ids);
               $arr =explode(",",$ids);
               $balance = explode(",", $request->balance);
               $new_ids = array_walk($arr,'intval');
               $today = Carbon::today()->format("Y-m-d");
               //echo count($arr);
             // print_r($new_ids);
             /*
                 for($i=0;$i<count($arr);$i++)
                {
                    echo $arr[$i]  . '<br>';
                }
                */
               //echo $ids . '<br>' ;
              // echo $balance;
                //$new_ids=array_push($elements,$ids)
                
                for($i=0;$i<count($arr);$i++)
                {
                    
                    
                  //  echo $id ;
                 // Model::firstOrFail()->where('something', $value)
                  //$bill = BillsDetails::where('bills_id','=',$arr[$i])->first();
                  $bill = BillsDetails::find($arr[$i]);
                  $bil = Payment::where('payment_id','=',$arr[$i])->count();
                  echo $bil . "<br>";
                  if($bil>0)
                  {
                    $bill_payment=Payment::select(DB::raw('SUM(amount_paid) AS total'))
                    ->where('payment_id','=',$arr[$i])->first();
                    $bill2=$bill_payment->total;
                  }
                  else
                  {
                    $bill2 = $balance[$i];
                  }
                 
               
               // echo $date_payment;
                //         //echo $bal. '<br>';
                        
                      
                            
                             $amount_paid  = $bill->amount_paid;
                            // echo $amount_paid;
                             $amount_due = $bill->total_cost - $balance[$i];
                            $total_paid = $amount_paid + $balance[$i];
                            $new_balance = $bill->total_cost - $total_paid;
                            //$total_bill2 = $bill2 + $balance[$i];
                            $pending_balances= $bill->total_cost - $bill2;
                           // echo "New Balance" . $new_balance . '<br>';
                            //echo "Total Paid " . $total_paid . '<br>';
                            if($mode == "BANK")
                            {
                              $posting_date = $request->posting_date;
                              $clearing_date = $request->clearing_date;
                             // echo $request->date_payment;
                              if($today >= $clearing_date)
                              {
                               $payment_clearance_status = "Cleared";
                              }
                              else
                              {
                                $payment_clearance_status = "Pending";
                              }
                              $form_data=array(
                                'pending_bank_amount' => $bill2,
                                'pending_bank_balances' => $pending_balances
                              );
                           $insert_data[] = $form_data;
                           BillsDetails::where('id','=',$arr[$i])->update($form_data);
                           Payment::Create(
                               [
                                'payment_id' => $arr[$i],
                                'balance' => $new_balance,
                                'amount_paid' => $total_paid,
                                'mode_payment' => $mode,
                                'posted_on' => $posting_date,
                                'cleared_on' => $clearing_date,
                                'date_payment' => $request->date_payment,
                                'payment_clearance_status' => $payment_clearance_status
                               ]); 
                        }
                            else if($mode == "MPESA")
                            {
                                $payment_clearance_status = "Cleared";
                              $mpesa_code = $request->mpesa_code;
                              $form_data=array(
                                'balance' => $new_balance,
                                'amount_paid' => $total_paid,
                                'pending_bank_amount' => $total_paid,
                                'pending_bank_balances' => $new_balance
                              );
                           $insert_data[] = $form_data;
                           BillsDetails::where('id','=',$arr[$i])->update($form_data); 
                           Payment::Create(
                            [
                             'payment_id' => $arr[$i],
                             'balance' => $new_balance,
                             'amount_paid' => $total_paid,
                             'mode_payment' => $mode,
                             'posted_on' => $posting_date,
                             'cleared_on' => $clearing_date,
                             'date_payment' => $request->date_payment,
                             'payment_clearance_status' => $payment_clearance_status
                            ]); 
                        } 
                            else if($mode == "CASH")
                            {
                                $payment_clearance_status = "Cleared";
                                $form_data=array(
                                    'balance' => $new_balance,
                                    'amount_paid' => $total_paid,
                                    'pending_bank_amount' => $total_paid,
                                    'pending_bank_balances' => $new_balance
                                  );
                               $insert_data[] = $form_data;
                               BillsDetails::where('id','=',$arr[$i])->update($form_data);
                               Payment::Create(
                                [
                                 'payment_id' => $arr[$i],
                                 'balance' => $new_balance,
                                 'amount_paid' => $total_paid,
                                 'mode_payment' => $mode,
                                 'posted_on' => $posting_date,
                                 'cleared_on' => $clearing_date,
                                 'date_payment' => $request->date_payment,
                                 'payment_clearance_status' => $payment_clearance_status
                                ]);   
                            }
                         
                   // 
     
                }
               
     
                
            }
        }
      
    }
   
    public function updateUser(Request $request)
    {
        //
        
        $validator = Validator::make($request->all(),[
            'nameu' => 'required|max:255',
            'user_nameu' => 'required|max:255',
            'phone_numberu' => 'required|max:255',
            'emailu' => 'required|max:255',
            'role_select_useru' => 'required|max:255',
          ]);
       // echo $request->hidden_user_id;
        if($validator->passes())
        {
           // echo $request->hidden_user_id;
            //Bills::find();
         // $check = Bills::where('ref_no','=',$request->ref_no)->first();
            $user_data = array(
                'name' => $request->nameu,
                'user_name' => $request->user_nameu,
                'phone_number' => $request->phone_numberu,
                'email' => $request->emailu,
                'role_id'=> $request->role_select_useru,
                );

      Users::where('id','=',$request->hidden_user_id)->update($user_data);
      
    }
}
public function updatePassword(Request $request)
{
    //
    
    $validator = Validator::make($request->all(),[
        'user_passwordu' => 'required|max:255',
            'user_confirm_passwordu' => 'required|max:255|same:user_passwordu',
      ]);
   // echo $request->hidden_user_id;
    if($validator->passes())
    {
       // echo $request->hidden_user_id;
        //Bills::find();
     // $check = Bills::where('ref_no','=',$request->ref_no)->first();
        $user_data = array(
            
            'password' => Hash::make($request->user_passwordu),
            );

  Users::where('id','=',$request->hidden_password_id)->update($user_data);
  
}
}
public function insertAll()
{
    $sites=Bills::all();
    $total= $sites->count();
    
       for($i=0;$i<$total;$i++)
       {
        //echo $site->site_name . '<br>';
        
        if(Sites::where('site_name','=',$sites[$i]['site_name'])->count()<1)
        {
        Sites::Create(['site_name' => $sites[$i]['site_name']]);
        
            //return "Sites Successfully Updated";
        
      }
       }
       
    
}

    public function update(Request $request)
    {
        //
        $validator=  Validator::make($request->all(),[
            'matu' => 'required|max:255',
            'supplieru' => 'required|max:255',
            'quantityu' => 'required|max:255',
            'unit_costu' => 'required',
            'ref_nou' => 'required',
            'site_nameu' => 'required',
            'dueu' => 'required',
            'date_addedu' => 'required'
            
      ]);
    if($validator->passes())
    {
      $form_data=array(
        //'material' => $request->matu,
        'supplier_name' => $request->supplieru,
       // 'quantity' => $request->quantityu,
       // 'unit_cost' => $request->unit_costu,
        'ref_no' => $request->ref_nou,
        'site_name' => $request->site_nameu,
        'date_added' => $request->date_addedu,
      );

      $unit_cost = $request->unit_costu;
                $quantity = $request->quantityu;
                $total = $unit_cost * $quantity;
                $vat = 16/100 * $total;
                $total_cost = $total;
                //$amount_paid=0;
                $days=$request->dueu;
                $due_date = date('Y-m-d',strtotime('+ '.$days.' days'));
                $data_bills =array(
                    'item' => $request->matu,
                    'price' => $request->unit_costu,
                    'quantity' => $request->quantityu,
                    'ref_no' => $request->ref_nou,
                    'total_cost' => $total_cost,
                    'balance' => $total_cost,
                    'vat' => $vat,
                    'due_date' => $due_date
                    
                );
      Bills::where('ref_no','=',$request->hidden_id)->update($form_data);
      BillsDetails::where('id','=',$request->hidden_details)->update($data_bills);
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
        $ids= explode('_',$id);
        //Bills::where('ref_no','=',$request->hidden_id)

        $data = Bills::where('ref_no','=',$ids[0]);
        $data1 = BillsDetails::where('id','=',$ids[1]);
        if(BillsDetails::where('ref_no','=',$ids[0])->count()==1)
        {
            $data->delete();
            $data1->delete();
        }
        else if(BillsDetails::where('ref_no','=', $ids[0])->count()>1)
         {
            $data1->delete();
         }
         
     
         //$data = spares::findOrFail($id);
        //$data->delete();
    }
    public function deleteUser(Request $request)
    {
        //
        $id = $request->id;
    
        $data = Users::where('id','=',$id);
        
            $data->delete();
    }
}
