<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Materials;
use DB;
use DataTables;
class MaterialsController extends Controller
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
             $dat = Materials::latest()->get();
             return Datatables::of($dat)->addIndexColumn()
             ->addColumn('edit',function($row){
                 $btn=' ';
             
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
         
         return view('admin.dashboard.construction_admin',compact('dat'));
    }
public function fetchDescription(Request $request)
{
    $mat = $request->mat;

        $material = Materials::where('material_name','=',$mat)->first();
        return response()->json($material);
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
            'material_name' => 'required|unique:materials',
            
           

         ],
         [
             'material_name.unique' => 'Material with similar name exists'
         ]
        );
        if($validator->passes())
        {
            $sites = Materials::Create([
                'material_name' => $request->material_name,
                'mat_description' => $request->material_desc
                
               
            ]);
                return response()->json(['success' => 'New Site Successfully Registered']);
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
    public function fetchMaterials()
    {
        $data=DB::table('materials')->orderBy('id','DESC')->get();
        echo json_encode($data);
    }
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
         //
         $data = materials::findOrFail($id);
         $data->delete();
    }
}
