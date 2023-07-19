<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FrontEndSearch extends Model
{
    use HasFactory;

    protected $table = "front_end_search";



    public function scopeSearch($query, $src){
        if($src == ''){
            return $query->where('keyword', 'like', '%%');
        }else{
            return $query->where('keyword', 'like', '%' .$src. '%');
        }
        
    }
}
