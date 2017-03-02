<?php

namespace App;

/**
 * The MIT License (MIT)
 *
 * Copyright (c) 2016 Atbox
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN
 * AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH
 * THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @package    Invi
 * @version    0.8.13 l5
 * @author     Sajjad Rad [sajjad.273@gmail.com]
 * @license    MIT License (3-clause)
 * @copyright  (c) 2016
 * @link       http://atbox.io/pages/opensource
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
	protected $table = 'invitations';
	protected $fillable = array('code','email','expiration','active','used','league_id');


	public static function generate($email,$expire,$active,$league_id)
	{
		if(self::checkEmail($email,$league_id))
		{
			$now = strtotime("now");
			$format = 'Y-m-d H:i:s ';
			$expiration = date($format, strtotime('+ '.$expire, $now)); 
			$code = Str::random(8) . self::hash_split(hash('sha256',$email)) . self::hash_split(hash('sha256',time())) . Str::random(8);
			$newInvi = array(
					"code"			=> $code,
					"email"			=> $email,
					"expiration"	=> $expiration,
					"active"		=> $active,
					"used"			=> "0",
					"league_id"		=> $league_id
				);
			Invitation::create($newInvi);
			return true;
		}
		else
		{
			return false;
		}
		
	}

	public static function used($code,$email){
		Invitation::where('code','=',$code)->where('email','=',$email)
				->update(array('used'=>True));
	}

	public static function unexpire($code,$email,$expire)
	{
		$now = strtotime("now");
		$format = 'Y-m-d H:i:s ';
		$expiration = date($format, strtotime('+ '.$expire, $now)); 
		Invitation::where('code','=',$code)->where('email','=',$email)
				->update(array('expiration'=>$expiration));
	}

	public static function status($code,$email)
	{
		$temp = Invitation::where('code', '=', $code)->where('email','=',$email)
					->first();
		if($temp)
		{
			if(!$temp->active)
				return "deactive";
			else if($temp->used)
				return "used";
			else if(strtotime("now") > strtotime($temp->expiration))
				return "expired";
			else
				return "valid";
		}
		else
			return "not exist";
	}

	protected static function checkEmail($email,$league_id)
	{
		$temp = Invitation::where('email', '=', $email)
		->where('league_id', $league_id)
		->first();
		
		if($temp)
			return False;
		else
			return True;
	}

	protected static function hash_split($hash)
	{
		$output = str_split($hash,8);
		return $output[rand(0,1)];
	}
}