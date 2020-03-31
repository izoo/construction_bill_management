<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Role;
Use App\Permission;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data =DB::table('roles')->orderBy('id','DESC')->get();
        echo json_encode($data);
    }
    
    public function getRoles(Request $request)
    {
        $role= $request->value;
        $data=DB::table('permissions')->where('role',$role)->get();
        return $data;
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
        $role_name = $request->role_name;  
        $role_status=$request->role_select;
        if($role_status=="NEW")
        {
        $validator = Validator::make($request->all(),[
        'role_name' => 'required|max:255|unique:roles'
        ],
        [
        'role_name.unique' => 'Role Name Already Exists'
        ]);
        if($validator->passes())
        {
           
                if(Role::Create(['role_name' => $role_name]))
                {
                    $permissions = $request->permission;
                    for($count=0;$count < count($permissions);$count++)
                    {
                        Permission::Create([
                            'role' => $role_name,
                            'permission' => $permissions[$count]
                        ]);
                    }
                }
                return response()->json(['success' => 'New Role Successfully Added']);
            }
        
            else
            {
                return response()->json(['error' => $validator->errors()->all()]);
            }
        }
            else
            {
                if(DB::table('permissions')->where('role','=',$role_name)->delete())
                {
                    $permissions = $request->permission;
                    for($count=0;$count < count($permissions);$count++)
                    {
                        Permission::Create([
                            'role' => $role_name,
                            'permission' => $permissions[$count]
                        ]);
                    }

                }
                return response()->json(['success' => 'Role Successfully Updated']);

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
