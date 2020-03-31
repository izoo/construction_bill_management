<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Spares;
use DB;
use DataTables;
class SparesController extends Controller
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
            $data = Spares::latest()->get();
            return Datatables::of($data)->addIndexColumn()
            ->addColumn('edit',function($row){
                $btn='<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
            
            return $btn;
        })
        ->addIndexColumn()
        ->addColumn('delete',function($row2){
          $btn2 = ' <a href="javascript:void(0)" data-toggle="tooltip"  id="'.$row2->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Remove</a>';
        return $btn2;
      })
        ->addIndexColumn()
           ->addColumn('more',function($row1)
        {
          $btn1 = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row1->id.'" data-original-title="Edit" class="more btn btn-primary btn-sm editVehicle">View More</a>';
          return $btn1;
         
        })->rawColumns(['edit','delete','more'])
        
        ->make(true);
        }
        
        return view('admin.dashboard.index',compact('data'));
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
      $validator=  Validator::make($request->all(),[
            'spare_name' => 'required|max:255',
            'price' => 'required|max:255',
            'model' => 'required|max:255',
            'make' => 'required|max:255',
            'description' => 'required',
            'photo' => 'required',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'type' => 'required|max:255',
            'category' => 'required',
            
      ]);
        
        if($validator->passes())
        {
            if($request->hasFile('photo'))
        {
            //$allowedfileExtension=['jpg','png','png'];
            foreach($request->file('photo') as $file)
            {
            
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $destinationPath='public/uploads/'; //Upload Path
                $profileImage = rand() .  "." . $extension;
                $file->move($destinationPath,$profileImage);
                $data[] = $profileImage;
            }
                
            
        }
        $vehicle = Spares::Create([
            'spare_name' => $request->spare_name,
            'price' => $request->price,
            'model_name' => $request->model,
            'make_name' => $request->make,
            'description' => $request->description,
            'photo' => json_encode($data),
            'type' => $request->type,
            'category' => $request->category,
        ]);
            return response()->json(['success' => 'New Sparepart Successfully Registered']);
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
        $product = spares::find($id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateProduct(Request $request)
    {
        //
          //
          $validator=  Validator::make($request->all(),[
            'spare_nameu' => 'required|max:255',
            'priceu' => 'required|max:255',
            'modelu' => 'required|max:255',
            'makeu' => 'required',
            'descriptionu' => 'required',
            'typeu' => 'required',
            'categoryu' => 'required',
            
      ]);
    if($validator->passes())
    {
      $form_data=array(
        'spare_name' => $request->spare_nameu,
        'price' => $request->priceu,
        'model_name' => $request->modelu,
        'make_name' => $request->makeu,
        'description' => $request->descriptionu,
        'type' => $request->typeu,
        'category' => $request->categoryu,
        
      );
      Spares::whereId($request->hidden_id)->update($form_data);
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
        $data = spares::findOrFail($id);
        $data->delete();
    }
}
