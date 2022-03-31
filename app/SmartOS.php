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