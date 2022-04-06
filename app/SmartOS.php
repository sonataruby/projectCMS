<?php
if (! function_exists('components'))
{
	function components($file,$data=[]){
		return view("\App\Views\components\\".$file,$data);
	}
}

if (! function_exists('blocks'))
{
	function blocks($file,$data=[]){
		return view("\App\Views\\".$file,$data);
	}
}


if (! function_exists('admin_url'))
{
	function admin_url($file,$data=[]){
		return "/admin/".$file."?".http_build_query($data);
	}
}


if (! function_exists('userinfo'))
{
	function userinfo(){
		$profile = new \App\Models\UserProfileModel;
		return $profile->getProfile();
	}
}

if (! function_exists('_go'))
{
	function _go($file){
		return redirect()->to($file)->with('message', 'Update data ok');
	}
}

if(!function_exists("posts_options")){
	function posts_options($posts_id){
		$db = db_connect();
        $data = $db->query("SELECT * FROM posts_options WHERE posts_id='".$posts_id."'")->getResult();
        return $data;
	}
}

if (! function_exists('fxImage'))
{
	function fxImage($symbol=""){
		$img1 = substr($symbol, 0, 3);
		$img2 = substr($symbol, 3, 6);
		
		if(strlen($symbol) == 6){
			return '<img src="/assets/img/fx/'.$img1.'.jpg" style="height:20px;margin-right:5px;"> <img src="/assets/img/fx/'.$img2.'.jpg" style="height:20px;">';
		}else{
			return '<img src="/assets/img/fx/'.$symbol.'.svg" style="height:20px;margin-right:5px;">';
		}
		
	}
}