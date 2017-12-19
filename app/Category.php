<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use App\Http\Requests;
use Carbon\Carbon;

class Category extends Model
{
	public function __construct()
    {
		$this->date = Carbon::now('Asia/Kolkata');
    }
    protected  function has_parent($id){
    	$abc =''; 
		$data = DB::table('category')->where('id',$id)->get();
		$p_id = $data[0]->parent_id;
		$p_name = $data[0]->name;	
		if($p_id)
		{
		$child = new self($p_id);
		return $child->has_parent($p_id)  . ' >> ' . $p_name;;
		}	
		else
		return $p_name;
	}
    public function category_list()
	{
		$category = DB::table('category')->where('status','1')->get();
		foreach ($category as $key=>$value){
			$category[$key]->slug = $this->has_parent($value->id);
		}
		return $category;
	}
    public function category_add($parent,$company,$name,$description)
    {
		$user_id = Auth::id();
		return $category_id = DB::table('category')->insertGetId(
		    ['parent_id' => $parent,'company_id' => $company,'name' => $name,'description' => $description,'created_at' => $this->date,'created_by' => $user_id]
		);
    }
	public function category_edit($id)
	{
		return DB::table('category')->where('id',$id)->get();
	}
	public function category_update($id,$parent,$company,$name,$description)
    {
		$user_id = Auth::id();
		return DB::table('category')
            ->where('id', $id)
            ->update(['parent_id' => $parent,'company_id' => $company,'name' => $name,'description' => $description,'updated_at' => $this->date,'updated_by' => $user_id]);
    }
    public function category_delete($id)
	{
		$user_id = Auth::id();
		$category = DB::table('category')->where('id',$id)->get();
		foreach($category as $value){
			$parent = $value->parent_id;
			$company = $value->company_id;
			$name = $value->name;
			$description = $value->description;
		}
		return DB::table('category')
            ->where('id', $id)
            ->update(['status' => '0','updated_at' => $this->date,'updated_by' => $user_id]);
	}
}
