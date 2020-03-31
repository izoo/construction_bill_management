<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\PasswordPrompts;
use DB;
use DataTables;
class PasswordPromptsController extends Controller
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
              $data = DB::table('passwords_prompt')->orderBy('created_at','DESC')->get();
              return Datatables::of($data)->addIndexColumn()
              ->addColumn('edit',function($row){
                $btn='<a href="javascript:void(0)" data-toggle="tooltip"  id="'.$row->id.'" data-original-title="Edit" class=" btn btn-danger btn-sm removePassword">Remove</a>';
            
               return $btn;
              })
             ->rawColumns(['edit'])
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
     
    public function checkPassword(Request $request)
    {
      $prompt = $request->prompt;
      if(DB::table('passwords_prompt')->where('prompt_on','=',$prompt)->count()>0)
      {
          echo 'ok';
      }
      
      
    }
    public function confirmPassword(Request $request)
    {
        $password = $request->password;
        $prompt = $request->prompt;
        $data= DB::table('passwords_prompt')->where('prompt_on','=',$prompt)->first();
        if(Hash::check($password,$data->password))
        {
            echo "ok";
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
            'prompt_on' => 'required|unique:passwords_prompt',
            'password_prompt' =>'required|string|min:8',
            'password_prompt_confirm' => 'required|same:password_prompt',
            
        ],[
            'prompt_on.unique' => "This Prompt On Already Exists",
            'password_prompt.min' => "Password Must Be Atleast 8 Characters",
            'password_prompt_confirm.confirm_password' => "Passwords Must Be The Same"
        ]);
        if($validator->passes())
        {

            $data = array(
                'prompt_on' => $request->prompt_on,
                'password' => Hash::make($request->password_prompt)
            );
            DB::table('passwords_prompt')->insert($data);
        }
        else
        {
            return response()->json(['prompt_errors' => $validator->errors()->all()]);
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
    public function deletePassword(Request $request)
    {
        //
        $id = $request->id;
        echo $id;
        $data= DB::table('passwords_prompt')->where('id','=',$id);
        $data->delete();
    }
    public function destroy(Request $request)
    {
        //
      
    }
}
