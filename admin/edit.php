<?php
include('../lib/SimpleBlog.php');

$blog = new SimpleBlog('localhost','root','','test');

function bailOut(){
	header('Location: list.php');
}

if( !isset($_GET['id']) ) bailOut();

$post_id = intval( $_GET['id'] );
$resource = $blog->getPostById( $post_id );
if( $resource->num_rows == 0 ) bailOut();

$post_content = ''; $post_title = ''; $post_date = '';

if( isset($_POST['post-title']) && isset($_POST['post-content']) && isset( $_POST['post-date']) )
{
	$blog->updatePost( $post_id, $_POST['post-title'], $_POST['post-content'], $_POST['post-date'] );
	
	$post_content = addslashes( $_POST['post-content'] );
	$post_title = addslashes( $_POST['post-title'] );
	$post_date = addslashes( $_POST['post-date'] );
}
else {
	$data = $resource->fetch_assoc();

	$post_content = $data['content'];
	$post_title = $data['title'];
	$post_date = $data['date_created'];
}


?>

<html>
<head>
	<title>Edit Post</title>
	<link rel="stylesheet" href="../css/smoothness/jquery-ui.css">
	<script src="../js/jquery-1.10.2.js"></script>
	<script src="../js/jquery-ui.js"></script>
</head>
<body>
	<form action="edit.php?id=<?php echo $post_id; ?>" method=POST>
	<table>
		<tr>
			<td colspan=2>
				<h1>Edit Post</h1>
		<tr>
			<td>Judul : 
			<td>
				<input name='post-title' style="width:640px; font-family : Arial" value="<?php echo $post_title; ?>" />
		<tr>
			<td> Tanggal :
			<td>
				<input name='post-date' id=datepicker type=text value="<?php echo $post_date ?>" />
				<span id=post-date-error></span>
		<tr>
			<td valign=top> Konten : 
			<td>
				<textarea name='post-content' style="width:640px; height : 300px; font-family : Arial" autofocus><?php echo $post_content ?></textarea>
		<tr>
			<td>
			<td>
				<input type=submit name='submit' value='change' />
	</table>
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			minDate : new Date(),
			defaultDate : new Date()
			
		});
	
		function isValidPostDate(){
			var d = new Date();
			var strippedD = new Date(d.getFullYear(), d.getMonth(), d.getDay() );
			// pake Date.parse karena kalau new Date bisa ngaco kalau tahun nya < 1970
			var selectedTime = Date.parse( $('#datepicker').val() );
			
			return selectedTime >= strippedD.getTime();
		}
	
		function validateDate(){
			if( !isValidPostDate() )
			{
				$('#post-date-error')
					.html('Error : Tanggal seharusnya lebih dari hari ini')
					.show();
				return false;
			}
			else {
				$('#post-date-error')
					.hide();
			}
			return true;
		}
	
		$('#datepicker').change(function( event ){
			validateDate();
		});
	
		$('.addpostform').submit(function( event ){
			if( !validateDate() )
			{
				event.preventDefault();
			}
		});
	});
	
	</script>
	
	</form>
</body>
</html>