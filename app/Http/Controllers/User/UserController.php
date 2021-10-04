<?php


namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $user = User::findOrfail(Auth::user()->id);
        return view("user.index")
        ->with("user", $user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Toallera  $toallera
     * @return \Illuminate\Http\Response
     */
    public function show(User $toallera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Toallera  $toallera
     * @return \Illuminate\Http\Response
     */
    public function edit(User $toallera)
    {
        $user = User::findOrfail(Auth::user()->id);
        return view("user.edit")
        ->with("user", $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Toallera  $toallera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $toallera)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Toallera  $toallera
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $toallera)
    {
        //
    }
}
