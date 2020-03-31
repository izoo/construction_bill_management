<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use DB;
use DataTables;
use App\Exp;
class NewExpenseController extends Controller
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
            $data = DB::table('exp')->orderBy('created_at','desc')->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('edit',function($row){
                $btn ='<a  href="javascript:void(0)" data-toggle="tooltip"  id="'. $row->id .'" data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary editnewExpenses">Edit</a>';
                return $btn;
            })
            ->addIndexColumn()
            ->addColumn('delete',function($row2){
                $btn2 = '<a  href="javascript:void(0)" data-toggle="tooltip"  id="'. $row2->id .'" data-id="'.$row2->id.'" data-original-title="Delete" class="btn btn-danger deletenewExpenses">Remove</a>';
            })
            ->rawColumns(['edit','delete'])
            ->make(true);
        }
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
            'expense_name' => 'required|max:255|unique:exp',
            'expense_description' => 'required|max:255'
        ],[
            'expense_name.unique' => 'Expense Already Exits',
        ]);
        if($validator->passes())
        {
            DB::table('exp')->insert([
                'expense_name' => $request->expense_name,
                'expense_description' => $request->expense_description
            ]);
            return response()->json(['success' => 'New Expense Successfully Added']);
        }
        else
        {
            return response()->json(['error_expense' => $validator->errors()->all()]);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
