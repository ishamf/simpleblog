<?php
class SimpleBlog {
	private $db;
	
	public function __construct( $hostname, $username, $password, $dbname ){
		$this->db = new mysqli( $hostname, $username, $password, $dbname );
		if($this->db->connect_errno > 0){
			die('Unable to connect to database [' . $this->db->connect_error . ']');
		}
		
		$this->init();
	}
	
	function __destruct(){
		$this->db->close();
	}
	
	function init(){
		$db = $this->db;
		
		$sql = "
			CREATE TABLE IF NOT EXISTS posts (
				id int(11) NOT NULL AUTO_INCREMENT,
				title VARCHAR(256) NOT NULL,
				content VARCHAR(2048) NOT NULL,
				date_created TIMESTAMP,
				PRIMARY KEY(id)
			);
		";

		if( !$result = $db->query( $sql )) {
			die('There was an error running the query [' . $db->error . ']');
		}
	}
	
	public function addPost( $title, $content, $date = 0 ){
		$db = $this->db;
		
		if( empty( $date ) ){
			$date = date("Y-m-d H:i:s", time()); ;
		}
		
		$sql = "
			INSERT INTO posts ( title, content, date_created )
			VALUES ('$title','$content','$date');
		";
		
		echo $sql;
		
		
		if( !$result = $db->query( $sql )) {
			die('There was an error running the query [' . $db->error . ']');
		}
	}
	
	public function deletePost( $pid ){
		
	}
	
	public function listPostJSON( $limit ){
	}
	
	public function listPost( $limit ){
	}
	
	public function viewPost( $id ){
		
	}
};

?>
