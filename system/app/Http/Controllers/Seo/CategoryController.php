<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Str;

use App\Models\Category;

class CategoryController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        if ($request->type == "delete") {
           foreach ($request->ids as $row) {
                $category=Category::with('preview')->find($row);
                if (!empty($category->preview->content)) {
                    if (file_exists($category->preview->content)) {
                        unlink($category->preview->content);
                    }
                }
                
                $category->delete();
           }
        }

        return response()->json(['Success']);
    }
}
