<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
Use App\Models\Session;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessions = Session::All();
        return view('admin.sessions.index', ['sessions' => $sessions]);        
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

    public function liveSessions(){
    
        $now = time();
        $view_period_default =(15 * 60); //
        $time_min = $now-(env("ACTIVE_SESSIONS_TIME", $view_period_default));

        $totalActiveUsers = Session::where('last_activity','>=', $time_min)
                            ->groupBy("user_id")
                            ->get();

        return $totalActiveUsers;
    }    

}
