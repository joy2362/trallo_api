<?php
session_start();
if (!isset($_SESSION['key']) || !isset($_SESSION['token']) ) {
	header('location:index.php');
}

if (!isset($_GET['boardId'])) {
	header('location:boards.php');
}

$url = 'https://api.trello.com/1/boards/'.$_GET['boardId'].'?key='.$_SESSION["key"].'&token='.$_SESSION["token"]; 

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 

$board = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 
$board = json_decode($board);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Trello</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
	<div class="container-fluid">
		<div class="row min-vh-100 justify-content-center align-items-center">
			<div class="col-sm-6 "> 
				<form method="post"  action="handler.php">
					  <div class="mb-3">
						  <label for="name" class="form-label">Name</label>
						  <input type="text" class="form-control" id="name" required="required" name="name" value="<?php echo $board->name ?>">
						</div>
						<input type="hidden" name="id" value="<?php echo $_GET['boardId'] ?>">
						<div class="mb-3">
						  <label for="description" class="form-label">Description</label>
						  <textarea class="form-control" id="description" rows="3" required="required" name="description">
						  	<?php echo $board->desc ?>
						  </textarea>
						</div>
			  		 <button type="submit" class="btn btn-primary" name="edit_board" value="board">Update</button>
				</form>
			</div>
		</div>
	</div>
	
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>