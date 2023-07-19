<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Category extends Model
{

	public function gateway_users()
	{
		return $this->hasMany('App\Models\Gateway');
	}

	public function active_getway()
	{
		return $this->hasOne('App\Models\Gateway')->where('user_id',Auth::id());
	}

	public function preview()
	{
		return $this->hasOne('App\Models\Categorymeta')->where('type','preview')->select('category_id','type','content');
	}

	public function description()
	{
		return $this->hasOne('App\Models\Categorymeta')->where('type','description')->select('category_id','type','content');
	}

	public function credentials()
	{
		return $this->hasOne('App\Models\Categorymeta')->where('type','credentials')->select('category_id','type','content');
	}

}
