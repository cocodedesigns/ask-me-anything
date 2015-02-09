<?php
class FileCache {
	private $cache_dir;
	public $serialize = false;
	public $expires = 86400; // expires in 24 hours

	function __construct() {
		$this->cache_dir = __DIR__ . '/../cache/';
	}

	public function check($key) {
		$file = $this->file($key);
		return file_exists($file) && filemtime($file) > time() - $this->expires;
	}
 
	public function get($key) {
		if (!$this->check($key)) {
			return false;
		}
		
		if ($this->serialize) {
			return unserialize(file_get_contents($this->file($key)));
		} else {
			return file_get_contents($this->file($key));
		}
	}
 
	public function set($key, $value) {
		if ($this->serialize) {
			$value = serialize($value);
		}
		return file_put_contents($this->file($key), $value);
	}
 
	public function flush() {
		foreach (glob($this->cache_dir . '/ama_*.txt') as $file) {
			unlink($file);
		}
		return true;
	}
	
	//Gets the hashed file name. Useful for removing or updating individual cache files.
	public function getFileName($key){
		$file = 'ama_' . md5(__FILE__ . $key) . ".txt";
		return (file_exists($this->cache_dir.$file) ? $file : false);
	}
	
	private function file($key) {
		return $this->cache_dir . '/ama_' . md5(__FILE__ . $key) . ".txt";
	}
}
?>