<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-12-21
 * Time: 16:16
 */
class bUser {
	public const loginUrl='/login';
	public const logoutUrl='/logout';
	public const sessionName='aaUser'; //file,db,redis
	public const cookieName='aaUser'; //file,db,redis
	public static function passWord($userName,$passWord,$salt='') {
		return md5(aApp::name.'_'.$userName.'_'.$passWord.'_'.$salt);
	}
	public static function hashWord($userName,$passWord,$salt='') {
		return sha1(aApp::name.'_'.$userName.'_'.$passWord.'_'.$salt);
	}
	public static function checkUserLogin() {
		session_start();
		if(isset($_SESSION[static::sessionName])) {
			aApp::$user=$_SESSION[static::sessionName];
			return true;
		} elseif (isset($_COOKIE[static::cookieName])) {
			return true;
		} else {
			aApp::$user=[];
			return false;
		}
	}
	public static function login($data) {
		session_start();
		$_SESSION[static::sessionName]=$data;
		aApp::$user=$data;
	}
	public static function logout() {
		session_start();
		$_SESSION[static::sessionName]=null;
		//setcookie(static::cookieName,0);
		aApp::$user=null;
	}
	public static function remember($second) {
		setcookie(static::cookieName,0);
	}
}