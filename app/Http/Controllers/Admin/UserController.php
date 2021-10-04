<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\helpers\DbTables\Constants\Constants;
use App\Models\User;
use App\Http\Controllers\Admin\ToalleraController;
use Exception;
use PhpParser\Node\Stmt\Foreach_;

class UserController extends Controller
{
    const RULES = [
        'name' => ['required', 'string', 'max:255', "unique:users"],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
        'typeUser' => ['required', "string", 'min:4', "max:5", 'regex:/ADMIN|USER/']
    ];
    const INPUT_NAMES = ["name", "email"];
    public function __construct()
    {
        $this->middleware(['role:ADMIN', 'auth']);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Request $request)
    {
        $response = $request->get("search");
        if(is_null($response)){
            return view("admin.user.index")
            ->with("users", User::paginate())
            ->with("containsPaginate", true);
        }
        $request->validate(ToalleraController::RULES_SEARCH);
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
        $user->assignRole($request["typeUser"]);
        return redirect()->route('useradmin.index')  
        ->with("INSERT", "IS_OK");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Toallera  $toallera
     * @return \Illuminate\Http\Response
     */
    public function show(User $toallera)
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
    protected function getRulesToUpdate(Request $request, $id)
    {
        $user = User::findOrfail($id);
        $newRules = array();
        $response = $request->all();
        foreach(self::INPUT_NAMES as $key){
            try{
                if(!empty($response[$key])){
                    if($response[$key] != $user[$key]){
                        $newRules[$key] = self::RULES[$key];
                    }
                }
            }catch(Exception $e){
                return redirect()->route('useradmin.edit', $id);
            }
        }
        try {
            if(!empty($response["password"])){
                $newRules["password"] = self::RULES["password"];
            }
            if(!empty($response["typeUser"])){
                $newRules["typeUser"] = self::RULES["typeUser"];
            }
        } catch (Exception $e) {
            return redirect()->route('useradmin.edit', $id);
        }
        return  $newRules;
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
        $newRules = $this->getRulesToUpdate($request, $id);
        if(Constants::isEmpty($newRules)){
            return redirect()->route('useradmin.edit', $id);
        }
        
        $request->validate($newRules);
        $response = $request->except(['_token', "_method", "password_confirmation"]);
        $newData = array();
        foreach($newRules as $key => $data){
            $newData[$key] = $response[$key];
        }
     
        User::where('id', $id)->update($newData);
        return redirect()->route('useradmin.index')
        ->with("UPDATE", "IS_OK");
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrfail($id);
        $user->delete();
        return redirect()->
            route('useradmin.index')->
            with("DELETE", "IS_OK");
    }
}
