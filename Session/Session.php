<?php
/*///////////////////////////////////////////////////////////////
 /** ID: | /-- ID: Indonesia
 /** EN: | /-- EN: English
 ///////////////////////////////////////////////////////////////*/

/**
 * Session - Library untuk framework kecik, library ini khusus untuk membantu masalah session 
 *
 * @author 		Dony Wahyu Isp
 * @copyright 	2015 Dony Wahyu Isp
 * @link 		http://github.com/kecik-framework/session
 * @license		MIT
 * @version 	1.0.1-alpha
 * @package		Kecik\Session
 **/
namespace Kecik;

/**
 * Session
 * @package 	Kecik\Session
 * @author 		Dony Wahyu Isp
 * @since 		1.0.0-alpha
 **/
class Session {
	/**
	 * @var bool $status
	 **/
	private $status = FALSE;

	/**
	 * @var string $key
	 **/

	private $key;
	/**
	 * @var string $iv
	 **/
	private $iv;
	
	/**
	 * @var Konstata untuk Limiter Session
	 **/
	const LIMITER_PUBLIC	= 'public';
	const LIMITER_PRIVATE 	= 'private';
	const LIMITER_PRIVATE_NO= 'private_no_expire';
	const LIMITER_NO_CACHE	= 'nocache';

	/**
	 * @var Konstanta untuk status session
	 **/
	const STATUS_DISABLED 	= PHP_SESSION_DISABLED;
	const STATUS_NONE		= PHP_SESSION_NONE;
	const STATUS_ACTIVE		= PHP_SESSION_ACTIVE;

	/**
 	 * __construct
 	 * @param Kecik $app
 	 **/
	public function __construct() {
		$app = Kecik::getInstance();
		session_start();
		$config = $app->config;
		$this->status = $config->get('session.encrypt');
		if ( empty( $this->status ) )
			$this->status = FALSE;
		else { 
			$key = $config->get('session.encrypt.key');
			if ( empty( $key ) )
				$this->key = pack('H*', $key);
			else
				$this->key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");

			if (empty($_SESSION['eivk'.md5($app->url->baseUrl())]) || !ctype_print($_SESSION['eivk'.md5($app->url->baseUrl())]))
				unset($_COOKIE['eivk'.md5($app->url->baseUrl())]);

            if (empty($_SESSION['eivk'.md5($app->url->baseUrl())]) && empty($_COOKIE['eivk'.md5($app->url->baseUrl())])) {
				$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	            $this->iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	            $this->iv = base64_encode($this->iv);
	            $_SESSION['eivk'.md5($app->url->baseUrl())] = $this->iv;
	            setcookie('eivk'.md5($app->url->baseUrl()), $this->iv, 0, '/');
        	} else {
        		if (!empty($_SESSION['eivk'.md5($app->url->baseUrl())])) {
            		$this->iv = $_SESSION['eivk'.md5($app->url->baseUrl())];
            		setcookie('eivk'.md5($app->url->baseUrl()), $this->iv, 0, '/');
        		} elseif (!empty($_COOKIE['eivk'.md5($app->url->baseUrl())])) {
        			$this->iv = $_COOKIE['eivk'.md5($app->url->baseUrl())];
            		$_SESSION['eivk'.md5($app->url->baseUrl())] = $this->iv;
        		}
        	}
		}

	}

	/**
	 * newIV
	 **/
	public function newIV() {
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $this->iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $this->iv = base64_encode($this->iv);
        $_SESSION['eivk'.md5($app->url->baseUrl())] = $this->iv;
        setcookie('eivk'.md5($app->url->baseUrl()), $this->iv, 0, '/');
	}

	/**
	 * id
	 * @return session_id()
	 **/
	public function id() {
		return session_id();
	}

	/**
	 * newId
	 * @return session_regenerate_id()
	 **/
	public function newId() {
		return session_regenerate_id();
	}

	/**
	 * set
	 * @param string $name
	 * @param mixed $value
	 **/
	public function set($name, $value) {
		$_SESSION[$name] = $this->encrypt( $value );
	}

	/**
	 * get
	 * @param string $name
	 * @return mixed
	 **/
	public function get($name) {
		if (isset($_SESSION[$name]))
			return $this->decrypt( $_SESSION[$name] );
		else
			return NULL;
	}

	/**
	 * delete
	 * @param string $name
	 **/
	public function delete($name) {
		if (isset($_SESSION[$name]))
			unset($_SESSION[$name]);
	}

	/**
	 * limiter
	 * @param string $limiter
	 **/
	public function limiter($limiter) {
		session_cache_limiter($limiter);
	}

	/**
	 * setExpire
	 * @param int $minute
	 **/
	public function setExpire($minute) {
		session_cache_expire($minute);
	}

	/**
	 * getExpire
	 * @return int minute
	 **/
	public function getExpire() {
		return session_cache_expire();
	}

	/**
	 * commit
	 * Simpan semua perubahan session
	 **/
	public function commit() {
		session_commit();
		session_write_close();
	}

	/**
	 * abort
	 * Batalkan semua perubahan session
	 **/
	public function abort() {
		session_abort();
		session_reset();
	}

	/**
	 * encode
	 * Encode session
	 * @return string
	 **/
	public function encode() {
		return session_encode();
	}

	/**
	 * decode
	 * @param string $data
	 * @return array
	 **/
	public function decode($data) {
		return session_decode($data);
	}

	/**
	 * getCookieParams
	 * @return array
	 */
	public function getCookieParams() {
		return session_get_cookie_params();
	}

	/**
	 * setCookieParams
	 * @param int $lifetime
	 * @param string $path
	 * @param string $domain
	 * @param bool $secure
	 * @param bool $httponly
	 */
	public function setCookieParams($lifetime, $path='/', $domain='', $secure=FALSE, $httponly=FALSE) {
		return session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
	}

	/**
	 * status
	 * @return bool 
	 **/
	public function status() {
		return session_status();
	}

	/**
	 * clear
	 * ID: Hapus semua session | EN: Delete all session
	 **/
	public function clear() {
		session_destroy();
	}

	/**
	 * encrypt
	 * ID: Enkripsi Session | EN: Session Encryption
	 * @param string $plaintext
	 * @return string
	 **/
	private function encrypt($plaintext) {
		if (is_array($plaintext))
			$ciphertext = json_encode($plaintext);
		else
			$ciphertext = $plaintext;

		if ($this->status) {
			$ciphertext = @mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $ciphertext, MCRYPT_MODE_CBC, base64_decode($this->iv));
		}

		return base64_encode($ciphertext);
	}

	/**
	 * decrypt
	 * ID: Dekripsi session | EN: Session Decryption
	 * @param string $ciphertext
	 * @return mixed
	 **/
	private function decrypt($ciphertext) {
		$plaintext = $ciphertext;
		if ($this->status) {
			$plaintext = trim( @mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, base64_decode($ciphertext), MCRYPT_MODE_CBC, base64_decode($this->iv)) );
			$plaintext_array = json_decode($plaintext, TRUE);
			if ($plaintext_array)
				$plaintext = $plaintext_array;
		}

		return $plaintext;
	}
}