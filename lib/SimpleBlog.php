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
		
		$postTableQuery = "
			CREATE TABLE IF NOT EXISTS posts (
				id int(11) NOT NULL AUTO_INCREMENT,
				title VARCHAR(256) NOT NULL,
				content VARCHAR(2048) NOT NULL,
				date_created TIMESTAMP,
				PRIMARY KEY(id)
			);
		";

		if( !$result = $db->query( $postTableQuery )) {
			die('There was an error running the query [' . $db->error . ']');
		}
		
		$commentTableQuery = "
			CREATE TABLE IF NOT EXISTS comments (
				id int(11) NOT NULL AUTO_INCREMENT,
				postId int(11) NOT NULL,
				name VARCHAR(256) NOT NULL,
				email VARCHAR(256) NOT NULL,
				comment VARCHAR(1024) NOT NULL,
				date_created TIMESTAMP,
				FOREIGN KEY ( postId ) REFERENCES posts (id),
				PRIMARY KEY (id)
			);
		";
		
		if( !$result = $db->query( $commentTableQuery )) 
		{
			die('There was an error running the query [' . $db->error . ']');
		}
	}
	
	public function addPost( $title, $content, $date = 0 ){
		$db = $this->db;
		
		if( empty( $date ) ){
			$date = date("Y-m-d H:i:s", time()); ;
		}
		else {
			$date = date("Y-m-d H:i:s", strtotime($date) ); ;
		}
		
		$title = addslashes( $db->real_escape_string( $title ) );
		$content = addslashes( $db->real_escape_string( $content ) );
		$date = addslashes( $db->real_escape_string( $date ) );
		
		$sql = "
			INSERT INTO posts ( title, content, date_created )
			VALUES ('$title','$content','$date');
		";
		
		if( !$result = $db->query( $sql )) {
			die('There was an error running the query [' . $db->error . ']');
		}
	}
	
	public function deletePost( $pid ){
		$db = $this->db;
		
		// just to be save
		$pid = intval( $pid );
		
		$sql = "
			DELETE FROM posts WHERE id = $pid LIMIT 1;
		";
		
		if( !$result = $db->query( $sql )) {
			die('There was an error running the query [' . $db->error . ']');
		}
	}
	
	public function updatePost( $pid, $title, $content, $date = 0 ){
		$db = $this->db;
		
		if( empty( $date ) ){
			$date = date("Y-m-d H:i:s", time()); ;
		}
		else {
			$date = date("Y-m-d H:i:s", strtotime($date) ); ;
		}

		$pid = intval( $pid );
		$title = addslashes( $db->real_escape_string( $title ) );
		$content = addslashes( $db->real_escape_string( $content ) );
		$date = addslashes( $db->real_escape_string( $date ) );
		
		$sql = "
			UPDATE posts
			SET title = '$title', content = '$content', date_created = '$date'
			WHERE id = $pid;
		";
		
		if( !$result = $db->query( $sql )) {
			die('There was an error running the query [' . $db->error . ']');
		}
	}
	
	public function listPostJSON( $limit ){
		
	}
	
	public function listPost( $limit = 10 ){
		$db = $this->db;
		$sql = "
			SELECT id, title, content, date_created 
			FROM posts 
			ORDER BY date_created DESC
			LIMIT $limit;
		";
		
		if( !$result = $db->query( $sql )) {
			die('There was an error running the query [' . $db->error . ']');
		}
		
		return $result;
	}
		
	public function getPostById( $id ){
		$db = $this->db;
		// filter input
		$id = intval( $id );
		
		$sql = "
			SELECT id, title, content, date_created
			FROM posts
			WHERE id = $id
			LIMIT 1;
		";
		
		if( !$result = $db->query( $sql )) {
			die('There was an error running the query [' . $db->error . ']');
		}
		
		return $result;
	}
	
	public function addComment( $pid, $name, $email, $content ){
		$db = $this->db;
		$pid = intval( $pid );
		
		$name = addslashes( $db->real_escape_string( $name ) );
		$email = addslashes( $db->real_escape_string( $email ) );
		$content = addslashes( $db->real_escape_string( $content ) );
		
		$sql = "
			INSERT INTO comments ( postId, name, email, comment )
			VALUES ( '$pid', '$name', '$email', '$content');
		";
		
		if( !$result = $db->query( $sql )) {
			die('There was an error running the query [' . $db->error . ']');
		}
	}
	
	public function getCommentsByPostId( $id ){
		$db = $this->db;
		$id = intval( $id );
		
		$sql = "
			SELECT name, email, comment, date_created 
			FROM comments
			WHERE postId = '$id';
		";
		
		if( !$result = $db->query( $sql )) {
			die('There was an error running the query [' . $db->error . ']');
		}
		
		return $result;
	}
};

?>
