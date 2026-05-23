<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
	use HasApiTokens;
	protected $table = 'tbl_admin';
	public $primaryKey = 'id';
	public $timestamps = true;
	public $incrementing = false;

	public static function verify_request_base($headers)
	{
		// Check if 'unique-key' exists in the headers array
		if (isset($headers['unique-key']) && !empty($headers['unique-key'])) {
			// Ensure that 'unique-key' is not empty
			$unique_key = $headers['unique-key'][0]; // Assuming it's an array of keys
	
			// Check if a matching admin exists for this unique_key
			$admin = Admin::where('unique_key', '=', $unique_key)->count();
	
			if ($admin <= 0) {
				// Unauthorized Access
				$status = 401;
				$response = array('status' => $status, 'errors' => 'Unauthorized Access!');
				return $response;
			} else {
				// Authorized Access
				$status = 200;
				$response = array('status' => $status, 'errors' => 'Authorized Access!');
				return $response;
			}
		} else {
			// If unique-key doesn't exist in headers, return Unauthorized Access
			$status = 401;
			$response = array('status' => $status, 'errors' => 'Unauthorized Access!');
			return $response;
		}
	}
	
}
