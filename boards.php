<?php
session_start();
if (!isset($_SESSION['key']) || !isset($_SESSION['token']) ) {
	header('location:index.php');
}

$url = 'https://api.trello.com/1/organizations/'.$_SESSION["organizationId"].'/boards?key='.$_SESSION["key"].'&token='.$_SESSION["token"]; 

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 

$boards = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 
$boards = json_decode($boards);

function logout(){
	session_unset();
	session_destroy();
	header('location:index.php');
}

if (isset($_GET['logout'])) {
	logout();
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Boards</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
	<div class="container-fluid">
		<div class="row min-vh-100 justify-content-center align-items-center">
			<div class="col-sm-6 "> 
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="organization" role="tabpanel" aria-labelledby="organization-tab">
				 		<div class="card" >
						  <div class="card-header">
						  	 <img src="https://trello-members.s3.amazonaws.com/<?php echo $_SESSION["id"] ?>/<?php echo $_SESSION["avatar"] ?>/50.png" class=" img-thumbnail" alt="<?php echo $_SESSION['name'] ?>" >

						    <?php echo $_SESSION['name'] ?>
						    <a href="?logout=true" class="float-end btn btn-sm btn-danger">Log Out</a>
						  </div>
						  <div class="card-body">
						    <p class="card-text"> Organization: <?php echo $_SESSION['organizationName'] ?>
	    	                <a href="#" class="float-end btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#add_board">Add Board</a>
						    </p>
						     <p class="card-text"> Boards:  </p>

						    <table class="table table-hover">
						    	 <thead>
								    <tr>
								      <th  colspan="2">Name</th>
								      <th  colspan="3">Action</th>
								    </tr>
  								</thead>
								<tbody>
									<?php
									foreach ($boards as $key => $board) {
									?>
								    <tr>
								      <td colspan="2"> <?php echo $board->name ?></td>
								      <td colspan="3">
								      	<a href="viewBoard.php?boardId=<?php echo $board->id ?>" class="btn btn-sm btn-outline-success">View</a>
							      		<a href="editBoard.php?boardId=<?php echo $board->id ?>"  class="btn btn-sm btn-outline-primary">Edit</a>
							      		<a href="handler.php?boardId=<?php echo $board->id ?>" class="btn btn-sm btn-outline-danger">Delete</a>
								      </td>
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
		</div>
	</div>
	  <!-- Modal for add  -->
        <div class="modal fade" id="add_board" tabindex="-1" aria-labelledby="add_board_Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="add_board_Label">Add Board</h5>
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="add_board" value="board">Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
            <!-- end Modal for add-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>