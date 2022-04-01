<?php
if (! function_exists('components'))
{
	function components($file,$data=[]){
		return view("\App\Views\components\\".$file,$data);
	}
}

if (! function_exists('userinfo'))
{
	function userinfo(){
		$profile = new \App\Models\UserProfileModel;
		return $profile->getProfile();
	}
}

if (! function_exists('fxImage'))
{
	function fxImage($symbol=""){
		$img1 = substr($symbol, 0, 3);
		$img2 = substr($symbol, 3, 6);
		return '<img src="/assets/img/fx/'.$img1.'.jpg" style="height:20px;margin-right:5px;"> <img src="/assets/img/fx/'.$img2.'.jpg" style="height:20px;">';
	}
}