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
	
	public function __destruct(){
		$this->db->close();
	}
	
	private function init(){
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
	
	private function query( $query ){
		$db = $this->db;
		if( !$result = $db->query( $query )) {
			die('There was an error running the query [' . $db->error . ']');
		}
		
		return $result;
	}
	
	private function cleanString( &$str ) {
		$str = addslashes( $this->db->real_escape_string( $str ) );
	}

	public function addPost( $title, $content, $date = 0 ){
		$db = $this->db;
		
		if( empty( $date ) ){
			$date = date("Y-m-d H:i:s", time()); ;
		}
		else {
			$date = date("Y-m-d H:i:s", strtotime($date) ); ;
		}
		
		$this->cleanString( $title );
		$this->cleanString( $content );
		$this->cleanString( $date );
		
		$sql = "
			INSERT INTO posts ( title, content, date_created )
			VALUES ('$title','$content','$date');
		";
		
		return $this->query( $sql );
	}
	
	public function deletePost( $pid ){
		$db = $this->db;
		
		// just to be save
		$pid = intval( $pid );
		
		$deleteCommentQuery = "
			DELETE FROM comments WHERE postid = $pid;
		";
		
		$this->query( $deleteCommentQuery );
		
		$sql = "
			DELETE FROM posts WHERE id = $pid LIMIT 1;
		";
		
		$this->query( $sql );
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
		$this->cleanString( $title );
		$this->cleanString( $date );
		$this->cleanString( $content );
		
		$sql = "
			UPDATE posts
			SET title = '$title', content = '$content', date_created = '$date'
			WHERE id = $pid;
		";
		
		return $this->query( $sql );
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
		
		return $this->query( $sql );
	}
		
	public function getPostById( $id ){
		// filter input
		$id = intval( $id );
		
		$sql = "
			SELECT id, title, content, date_created
			FROM posts
			WHERE id = $id
			LIMIT 1;
		";
		
		return $this->query( $sql );
	}
	
	public function addComment( $pid, $name, $email, $content ){
		$db = $this->db;
		$pid = intval( $pid );
		
		$this->cleanString( $name );
		$this->cleanString( $email );
		$this->cleanString( $content );
		
		$sql = "
			INSERT INTO comments ( postId, name, email, comment )
			VALUES ( '$pid', '$name', '$email', '$content');
		";
		
		$this->query( $sql );
	}
	
	public function getCommentsByPostId( $id ){
		$db = $this->db;
		$id = intval( $id );
		
		$sql = "
			SELECT name, email, comment, date_created 
			FROM comments
			WHERE postId = '$id';
		";
		
		return $this->query( $sql );
	}
		
};

?>
