<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Cache;

use App\Models\Adminmenu;
use App\Models\Option;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus= Adminmenu::latest()->get();
        $positions=MenuPositions();

        return view('admin.menu.create',compact('menus','positions'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
        ]);

        if ($request->status==1 && $request->position == 'header') {
            DB::table('adminmenus')->where('position',$request->position)->update(['status'=>0]);
        }
        
        $men=new Adminmenu;
        $men->name=$request->name;
        $men->position=$request->position;
        $men->status=$request->status;
        $men->data="[]";
        $men->save();

        return response()->json(['Menu Created']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info= Adminmenu::find($id);
        return view('admin.menu.index',compact('info'));
    }

    /*
    update menus json row in  menus table
    */
    public function MenuNodeStore(Request $request)
    {
        if($request->data == "[]"){
            $msg['errors']['user']='Please add menus';
            return response()->json($msg,401);
        }

        $info= Adminmenu::find($request->menu_id);
        $info->data=$request->data;
        $info->save();

        Cache::forget($info->position);
        return response()->json(['Menu Updated']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $info= Adminmenu::find($id);
       $positions=MenuPositions();

       return view('admin.menu.edit',compact('info','positions'));
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
        $request->validate([
            'name' => 'required|max:50',
        ]);

        if ($request->status==1 && $request->position == 'header') {
            DB::table('adminmenus')->where('position',$request->position)->update(['status'=>0]);
        }

        $men= Adminmenu::find($id);
        $men->name=$request->name;
        $men->position=$request->position;
        $men->status=$request->status;
        $men->save();
        
        Cache::forget($request->position);
        return response()->json(['Menu Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->method=='delete') {
            if ($request->ids) {
                foreach ($request->ids as $id) {
                    Adminmenu::destroy($id);
                }
            }else{
                $msg['errors']['menu'] = 'Please select menu';
                return response()->json($msg, 401);
            }
        }

        return response()->json(['Menu Removed']);
    }
}
