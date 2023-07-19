<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FrontEndSearch;
use App\Http\Controllers\Admin\SeoController;
use Str;
use Auth;
use DB;
use Image;
use File;

class FrontEndSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /* all user show data, search and pagination start */
        $conditions = [];
        $numberOfPage = $request->no_of_users ?? 10;
        if (!empty($request->src) && !empty($request->term)) {
            $frontendSearch = FrontEndSearch::where('status', 1)
                ->where($request->term, 'like', '%' . $request->src . '%')
                ->paginate($numberOfPage);

            $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
        } else {
            $frontendSearch = FrontEndSearch::where('status', 1)
                ->orderBy('id', 'DESC')
                ->paginate($request->no_of_users);
        }
        /* all user show data, search and pagination end */

        return view('admin.frontendsearch.index', compact('frontendSearch', 'conditions', 'frontendSearch', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.frontendsearch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            'keyword' => 'required|max:250', 
            'path' => 'required|max:200',
            'name' => 'required|max:50',
            'description' => 'required|max:200',
        ];

        $messages = [
            'keyword.required' => 'Keyword can not be empty',
            'path.required' => 'URL can not be empty',
            'name.required' => 'name can not be empty',
            'description.required' => 'description can not be empty',
            
        ];

        $this->validate($request, $rules, $messages);

        // $creat_slug = Str::slug($request->title);
        // $check = Page::where('slug', $creat_slug)->count();
        // if ($check != 0) {
        //     $slug = $creat_slug . '-' . $check . rand(20, 80);
        // } else {
        //     $slug = $creat_slug;
        // }

        $url_check = FrontEndSearch::where('path', $request->path)->count();
        if ($url_check != 0) {
            return response()->json([
                'status' => false,
                'message' => 'Keyword with same URL already exists.',
            ]);
        }

        $FrontEndSearch =  new FrontEndSearch;
        $FrontEndSearch->keyword = $request->keyword;
        $FrontEndSearch->path = $request->path;
        $FrontEndSearch->name = $request->name;
        $FrontEndSearch->description = $request->description;
        $FrontEndSearch->status = $request->status;
        $FrontEndSearch->save();
       
        if ($FrontEndSearch) {
            return response()->json([
                'status' => true,
                'message' => 'Keyword Saved Successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Keyword Saving Failed',
            ]);
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
        $FrontEndSearch = FrontEndSearch::find($id);
        return view('admin.frontendsearch.show', compact('FrontEndSearch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $FrontEndSearch = FrontEndSearch::find($id);
        return view('admin.frontendsearch.edit', compact('FrontEndSearch'));
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
        $rules = [
            'keyword' => 'required|max:250', 
            'path' => 'required|max:200',
            'name' => 'required|max:50',
            'description' => 'required|max:300',
        ];

        $messages = [
            'keyword.required' => 'Keyword can not be empty',
            'path.required' => 'URL can not be empty',
            'name.required' => 'name can not be empty',
            'description.required' => 'description can not be empty',
            
        ];

        $this->validate($request, $rules, $messages);


        $FrontEndSearch = FrontEndSearch::find($id);
        $FrontEndSearch->keyword = $request->keyword;
        $FrontEndSearch->path = $request->path;
        $FrontEndSearch->name = $request->name;
        $FrontEndSearch->description = $request->description;
        $FrontEndSearch->status = $request->status;
        $FrontEndSearch->save();

        if ($FrontEndSearch) {
            return response()->json([
                'status' => true,
                'message' => 'Keyword Update Successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Keyword Saving Failed',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->ids) {
            foreach ($request->ids as $id) {
                FrontEndSearch::destroy($id);
            }

            return response()->json('Successfully deleted');
        } else {
            return response()->json('Please select Keyword');
        }
    }

    public function destroyPage(Request $request, $id)
    {
        FrontEndSearch::destroy($id);

        return response()->json([
            'status' => true,
            'message' => 'Keyword deleted successfully',
        ]);
    }

    public function changePageStatus(Request $request, $id)
    {
        $FrontEndSearch = FrontEndSearch::findorFail($id);
        if ($FrontEndSearch->status == 1) {
            $status = 0;
            $hide = 'active-badge';
            $show = 'deactive-badge';
        } else {
            $status = 1;
            $hide = 'deactive-badge';
            $show = 'active-badge';
        }
        $FrontEndSearch->status = $status;
        $FrontEndSearch->save();

        SeoController::sitemapUpdate();

        return response()->json([
            'status' => true,
            'hide' => $hide,
            'show' => $show,
            'message' => 'Keyword status changed successfully',
        ]);
    }
}
