<?php
namespace Kecik;

class Session {

	public function __construct() {
		session_start();
	}

	public function set($name, $value) {
		$_SESSION[$name] = $value;
	}

	public function get($name) {
		return $_SESSION[$name];
	}

	private function encrypt($plantext) {
		$chipertext = '';
		return $chipertext;
	}

	private function decrypt($chipertext) {
		$plantext = '';
		return $plantext;
	}
}