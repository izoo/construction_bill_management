<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spares;
use DB;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index()
{
    //
    $data = DB::table('spares')->where('category','wheels tires')->orderBy('id','desc')->get();
    //return view('userproducts',compact('data'));
    echo json_encode($data);
}
public function fetchBrakes()
{
    $data=DB::table('spares')->where('category','brakes')->orderBy('id','desc')->get();
    echo json_encode($data);
}
public function fetchEngines()
{
    $data=DB::table('spares')->where('category','engines')->orderBy('id','desc')->get();
    echo json_encode($data);
}
public function fetchLighting()
{
 $data=DB::table('spares')->where('category','lighting')->orderBy('id','desc')->get();
 echo json_encode($data);
}
public function fetchParts()
{
    $data=DB::table('spares')->where('category','bodyparts')->orderBy('id','desc')->get();
    echo json_encode($data);
}
public function fetchOthers()
{
    $data=DB::table('spares')->where('category','others')->orderBy('id','desc')->get();
    echo json_encode($data);
}
public function fetchWheels()
{
    $data=DB::table('spares')->where('category','wheels&tires')->orderBy('id','desc')->get();
    echo json_encode($data);
}
public function fetchModels()
{
    $data=DB::table('spares')->distinct()->get(['model_name']);
    echo json_encode($data);
}
public function fetchSpecificModels()
{
    $model_name=$_GET['mod'];
    $data = DB::table('spares')->where('model_name',$model_name)->get();
    echo json_encode($data);
}
public function fetchSpecials()
{
    $data = DB::table('spares')->take(4)->get();
    echo json_encode($data);
}
public function fetchBodyParts()
{
    $data = DB::table('spares')->where('category','body&parts')->get();
    echo json_encode($data);
}
public function fetchSingleProduct(Request $request)
{
    $product_id=$request->id;
    $data = DB::table('spares')->where('id',$product_id)->get();
    $json= json_encode($data);
    return view('products_view')->with('json',$json)->render();
    
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
