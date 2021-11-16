<?php 
session_start();
if (isset($_SESSION['key']) && isset($_SESSION['token'])) {
	header('location:boards.php');
}
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
			<div class="col-sm-4 "> 
				<form method="post" action="authentication.php">
					<div class="mb-3 ">
					    <label for="key" class="form-label">Api key</label>
					    <input type="text" class="form-control" id="key" name="key" required="required">
				  	</div>
					 <div class="mb-3">
					    <label for="token" class="form-label">Api secret</label>
					    <input type="text" class="form-control" id="token" name="token" required="required">
					</div>
			  		<button type="submit" class="btn btn-primary">Authorize</button>
				</form>
			</div>
		</div>
	</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>