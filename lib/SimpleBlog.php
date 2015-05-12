<?php
class SimpleBlog {
	public function __construct( $hostname, $username, $password, $dbname ){
		$this->db = new mysqli( $hostname, $username, $password, $dbname );
		
	}
	
	function __destruct(){
		$this->db->close();
	}
	
	
	public function addPost(){
		
	}
	
	public function deletePost(){
		
	}
	
	public function listPostJSON( $limit ){
	}
	
	public function listPost( $limit ){
	}
	
	public function viewPost( $id ){
		
	}
};

?>
