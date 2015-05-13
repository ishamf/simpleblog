<?php
include('../lib/SimpleBlog.php');

$blog = new SimpleBlog('localhost','root','','test');

$resource = $blog->listPost();

var_dump( $resource );
while( $row = $resource->fetch_assoc() ){
	echo "
		<h2>$row[title]</h2>
		$row[date_created]
		<p>
		$row[content]
		</p>
		<hr>
	
	";
}
	


?>