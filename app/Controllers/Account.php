<?php

namespace App\Controllers;

class Account extends BaseController
{

	public function updateVip(){
		return _go("/signal");
	}
	/**
	 * Connect with Google
	 */
	public function connect_with_google()
	{
		require_once APPPATH . "ThirdParty/google/vendor/autoload.php";

		$provider = new League\OAuth2\Client\Provider\Google([
			'clientId' => $this->general_settings->google_client_id,
			'clientSecret' => $this->general_settings->google_client_secret,
			'redirectUri' => base_url() . 'connect-with-google',
		]);
		
		if (!empty($_GET['error'])) {
			// Got an error, probably user denied access
			exit('Got error: ' . htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'));
		} elseif (empty($_GET['code'])) {

			// If we don't have an authorization code then get one
			$authUrl = $provider->getAuthorizationUrl();
			$_SESSION['oauth2state'] = $provider->getState();
			$this->session->set_userdata('g_login_referrer', $this->agent->referrer());
			header('Location: ' . $authUrl);
			exit();

		} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
			// State is invalid, possible CSRF attack in progress
			unset($_SESSION['oauth2state']);
			exit('Invalid state');
		} else {
			// Try to get an access token (using the authorization code grant)
			$token = $provider->getAccessToken('authorization_code', [
				'code' => $_GET['code']
			]);
			// Optional: Now you have a token you can look up a users profile data
			try {
				// We got an access token, let's now get the owner details
				$user = $provider->getResourceOwner($token);

				$g_user = new stdClass();
				$g_user->id = $user->getId();
				$g_user->email = $user->getEmail();
				$g_user->name = $user->getName();
				$g_user->avatar = $user->getAvatar();

				$this->auth_model->login_with_google($g_user);

				if (!empty($this->session->userdata('g_login_referrer'))) {
					redirect($this->session->userdata('g_login_referrer'));
				} else {
					redirect(base_url());
				}

			} catch (Exception $e) {
				// Failed to get user details
				exit('Something went wrong: ' . $e->getMessage());
			}
		}
	}
}
