<?php 
session_start();
if (!isset($_SESSION['key']) || !isset($_SESSION['token']) ) {
	header('location:index.php');
}

//handle board add request
if (isset($_POST['add_board'])) {

$data = [
    'name' => $_POST['name'],
    'desc' => $_POST['description'],
    'prefs_permissionLevel'=> 'public',
    'idOrganization' => $_SESSION['organizationId'],
];


$url = 'https://api.trello.com/1/boards?key='.$_SESSION["key"].'&token='.$_SESSION["token"]; 

$ch = curl_init(); 
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

$res = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 

if ($httpstatus == 200) {
	header('location:boards.php');
}

}

//handle board update request
if (isset($_POST['edit_board'])) {

$url = 'https://api.trello.com/1/boards/'. $_POST['id'].'?name='. urlencode($_POST['name']).'&desc='.urlencode($_POST['description']).'&idOrganization='.$_SESSION['organizationId'] .'&key='.$_SESSION["key"].'&token='.$_SESSION["token"];  

$ch = curl_init(); 
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_PUT, true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

$res = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 

if ($httpstatus == 200) {
	header('location:boards.php');
}
}

//handle add list request 
if (isset($_POST['add_list'])) {
	$data = [
    'name' => $_POST['name'],
    'idBoard' => $_POST['id'],
];

$url = 'https://api.trello.com/1/lists?key='.$_SESSION["key"].'&token='.$_SESSION["token"]; 

$ch = curl_init(); 
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

$res = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 

if ($httpstatus == 200) {
	header('location:viewBoard.php?boardId='.$_POST['id']);
}

}

//handle add card request 
if (isset($_POST['add_card'])) {
	$data = [
    'name' => $_POST['name'],
    'desc' => $_POST['description'],
    'idList' => $_POST['id'],
];

$url = 'https://api.trello.com/1/cards?key='.$_SESSION["key"].'&token='.$_SESSION["token"]; 

$ch = curl_init(); 
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

$res = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 

if ($httpstatus == 200) {
	header('location:viewList.php?listId='.$_POST['id']);
}

}
//handle board delete request
if (isset($_GET['boardId'])) {
	$url = 'https://api.trello.com/1/boards/'.$_GET['boardId'].'?key='.$_SESSION["key"].'&token='.$_SESSION["token"]; 

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 

$res = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 

if ($httpstatus == 200) {
	header('location:boards.php');
}
}