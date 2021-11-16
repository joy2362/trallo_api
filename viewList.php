<?php
session_start();
if (!isset($_SESSION['key']) || !isset($_SESSION['token']) ) {
	header('location:index.php');
}

if (!isset($_GET['listId'])) {
	header('location:boards.php');
}

$url = 'https://api.trello.com/1/lists/'.$_GET['listId'].'/cards?key='.$_SESSION["key"].'&token='.$_SESSION["token"]; 

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 

$cards = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 
$cards = json_decode($cards);
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
				<div class="card" >
						  <div class="card-header">
						     <img src="https://trello-members.s3.amazonaws.com/<?php echo $_SESSION["id"] ?>/<?php echo $_SESSION["avatar"] ?>/50.png" class=" img-thumbnail" alt="<?php echo $_SESSION['name'] ?>" >

						    <?php echo $_SESSION['name'] ?>
						     <a href="boards.php" class="float-end btn btn-sm btn-primary" >Go Back</a>
						  </div>
						  <div class="card-body">
						  	 <p class="card-text"> Organization: <?php echo $_SESSION['organizationName'] ?>
						    <p class="card-text"> Cards
	    	                <a href="#" class="float-end btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#add_card">Add Card</a>
						    </p>
						    <table class="table table-hover">
						    	 <thead>
								    <tr>
								      <th >Name</th>
								       <th >Description</th>
								    </tr>
  								</thead>
								<tbody>
									<?php
									foreach ($cards as $key => $card) {
									?>
								    <tr>
								      <td > <?php echo $card->name ?></td>
								      <td > <?php echo $card->desc ?></td>
								    </tr>
								    <?php 
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="add_card" tabindex="-1" aria-labelledby="add_card_Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add_list_Label">Add Card</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="handler.php" >
                    <div class="modal-body">
                        <div class="mb-3">
						  <label for="name" class="form-label">Name</label>
						  <input type="text" class="form-control" id="name" required="required" name="name">
						</div>  
						<div class="mb-3">
						  <label for="description" class="form-label">Description</label>
						  <textarea class="form-control" id="description" rows="3" required="required" name="description"></textarea>
						</div>                      
                    </div>
                    <input type="hidden" name="id" value="<?php echo $_GET['listId'] ?>">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="add_card" value="card">Save</button>
                    </div>
                    </form>
                </div>
            </div>
    </div>
	
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>