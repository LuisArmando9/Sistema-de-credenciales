<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\helpers\Csv\Constants\Constants;
use App\Models\User;
use App\Http\Controllers\Admin\Rules\WorkerRules;
use App\Http\Controllers\Auth\LoginController;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    const RULES = [
        'name' => ['required', 'string', 'max:255', "unique:users"],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];
    private $id;
    const INPUT_NAMES = ["name", "email"];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getRules(Request $request, User $user){
       $newRules = [];
       $response = $request->all();
       if($request->has("password")){
            if(!is_null($response['password'])){
                $newRules['password'] = self::RULES['password'];
            }
       }
       foreach(self::INPUT_NAMES as $key){
           if($request->has($key)){
            if(trim($response[$key]) != $user[$key]){
                $newRules[$key] = self::RULES[$key];
            }
           }
       }
       return $newRules;

    }
    public function index(Request $request)
    {
        $response = $request->get("search");
        if(is_null($response)){
            return view("admin.user.index")
            ->with("users", User::paginate())
            ->with("containsPaginate", true);
        }
        $request->validate(WorkerRules::SEARCH);
        return view("admin.user.index")
            ->with("users", User::where("id", $response)->get())
            ->with("containsPaginate", false);

       
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.user.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(self::RULES);
        $response = $request->except(["_token", "password_confirmation", "typeUser"]);
        $response["password"] = hash::make($response["password"]);
        $user  = User::create($response);
        $user->assignRole("ADMIN");
        return redirect()->route('useradmin.index')  
        ->with("toast_success", "Se ha creado un nuevo usuario correctamente.");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Toallera  $toallera
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Toallera  $toallera
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::findOrfail($id);
        return view("admin.user.edit")
        ->with("user", $user);

    }
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Toallera  $toallera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrfail($id);
        $newRules = $this->getRules($request, $user);
        if(Constants::isEmpty($newRules)){
            return redirect()->route('useradmin.edit', $id)
            ->with("toast_success", "x1");
        } 
        $request->validate($newRules);
        $response = $request->all();
        $newData = array();
        foreach($newRules as $key => $array){
           $newData[$key] = $response[$key];
        }
        if(isset($newRules['password'])){
            $newData["password"] = hash::make($newData["password"]);
        }                                                                                                                                                                   
        User::where('id', $id)->update($newData);
        return redirect()->route('useradmin.index')
        ->with("toast_success", "Se ha actualizado correctamente el usuario");
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = User::findOrfail($id);
            $user->delete();
        }catch(\Exception $e){
            return redirect()->
            route('useradmin.index')->
            with("toast_error", "No se puedo eliminar el usuario.");

        }
        return redirect()->
            route('useradmin.index')->
            with("toast_success", "Se ha eliminado correctamente el usuario");
    }
}
