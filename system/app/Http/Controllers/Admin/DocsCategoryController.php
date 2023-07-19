<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\DocumentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use URL;

class DocsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->status ?? 'all';
        $conditions = [];

        if (!empty($request->src) && !empty($request->term)) {
            if ($status === 'all') {
                $docscategories = DocumentCategory::where($request->term, 'like', '%' . $request->src . '%')
                    ->latest()
                    ->paginate(10);

                $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
                // dd($conditions);
            } else {
                $docscategories = DocumentCategory::where('status', $status)
                    ->where($request->term, 'like', '%' . $request->src . '%')
                    ->latest()

                    ->pagiante(10);
                // dd($channels);

                $conditions[] = [$request->term, 'like', '%' . $request->src . '%'];
            }
        } else {
            if ($status === 'all') {
                $docscategories = DocumentCategory::latest()->paginate(10);
            } else {
                $docscategories = DocumentCategory::where('status', $status)
                    ->latest()
                    ->paginate(10);
            }
        }
        $docscategories_url = Session(['docscategories_url' => '#']);
        $all = DocumentCategory::where($conditions)->count();
        $actives = DocumentCategory::where('status', 1)
            ->where($conditions)
            ->count();
        $inactives = DocumentCategory::where('status', 0)
            ->where($conditions)
            ->count();
        // dd($all);

        return view('admin.docscategories.index', compact('docscategories', 'request', 'all', 'status', 'actives', 'inactives'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $docscategories = [];

        return view('admin.docscategories.create', compact('docscategories'));
        // dd($channels);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $maxValue = DocumentCategory::max('ordering');
        $result_max = $maxValue + 1;

        $rules = [
            'name' => 'required|max:100',
        ];

        $messages = [
            'name.required' => 'Document Category name is required ! ',
        ];

        $this->validate($request, $rules, $messages);
        $creat_slug = Str::slug($request->name);
        $check = DocumentCategory::where('slug',$creat_slug)->count();
        if ($check != 0) {
            $slug = $creat_slug.'-'.$check.rand(20,80);
        }
        else{
            $slug = $creat_slug;
        }

        $check = DocumentCategory::where('name', $request->name)->first();
        if (!$check) {
            $docscategory = new DocumentCategory();
            $docscategory->name = $request->name;
            $docscategory->slug = $slug;
            $docscategory->status = $request->status ?? 1;

            $docscategory->meta_title = $request->meta_title;
            $docscategory->meta_description = $request->meta_description;
            $docscategory->meta_keywords = $request->meta_keywords;
            
            // $docscategory->save();
            $docscategory->ordering = $result_max;
            $docscategory->save();

            echo json_encode(['type' => 'success', 'message' => 'Document Category Created Successfully !']);
        } else {
            echo json_encode(['type' => 'error', 'message' => 'Document Category Name Is Already Exists !']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $channels = DocumentCategory::findOrfail($id);
        // return view('admin.channels.show', compact('channels'));
        // dd($channels);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $docscategories_url = Session(['docscategories_url' => URL::previous()]);
        $docscategories = DocumentCategory::find($id);
        // dd($docscategories);
        return view('admin.docscategories.edit', compact('docscategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $maxordering = DocumentCategory::where('ordering',  $request->ordering)
        // ->orderBy('ordering', 'DESC')
        ->first();
        //  dd($maxordering);
        $docscategory = DocumentCategory::find($id);
        
        $rules = [
            'name' => 'required|max:100',
        ];

        $messages = [
            'name.required' => 'Document Category name is required ! ',
        ];

        $this->validate($request, $rules, $messages);
        $docscategories_url = Session::get('docscategories_url');

        $check = DocumentCategory::where('name', $request->name)
            ->where('id', '<>', $id)
            ->first();

        if (!$check) {
            $oldCatId = $docscategory->ordering;
            
            $docscategory->name = $request->name;
            $docscategory->status = $request->status ?? 1;
            $docscategory->meta_title = $request->meta_title;
            $docscategory->meta_description = $request->meta_description;
            $docscategory->meta_keywords = $request->meta_keywords;

            $docscategory->ordering = $request->ordering;
            if ($maxordering != null) {
                // $docscategory->ordering = $maxordering->ordering;
                
                $maxordering->ordering = $oldCatId;
                $maxordering->save();
            }
            $docscategory->save();

            echo json_encode(['type' => 'success', 'message' => 'Document Category Updated Successfully !']);
        } else {
            echo json_encode(['type' => 'error', 'message' => 'Document Category name is Already exists !']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroys(request $request)
    {
        if (!isset($request->type)) {
            return response()->json(['status' => false, 'message' => 'Please Select Action !']);
        }

        if (!isset($request->ids)) {
            return response()->json(['status' => false, 'message' => 'Please Select Document Category !']);
        }

        if (($request->type=='delete')) {
            foreach ($request->ids as $key => $id) {
                $docscategories = DocumentCategory::findOrfail($id);
                $docscategories->delete();
                // dd($request->type=='delete');
            }
            return response()->json(["status" =>true, "message" => "Document Category Deleted !"]);
        } else if ($request->type == 0) {
            foreach ($request->ids as $key => $id) {
                $docscategories = DocumentCategory::findOrfail($id);
                $docscategories->status = 0;
                $docscategories->save();
                // dd($request->type== 0);
            }
            return response()->json(['status' => true, 'message' => 'Document Category Inactivated !']);
        } else if ($request->type == 1) {
            foreach ($request->ids as $key => $id) {
                $docscategories = DocumentCategory::findOrfail($id);
                $docscategories->status = 1;
                $docscategories->save();
            }
            return response()->json(['status' => true, 'message' => 'Document Category Activated !']);
        } else {
            return response()->json(['status' => false, 'message' => 'Could Not Successfully Done !']);
        }

        // dd(!isset($request->ids));
    }

}
