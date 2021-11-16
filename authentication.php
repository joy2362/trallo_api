<?php
session_start();


$_SESSION["key"] = $_POST['key'];
$_SESSION["token"] = $_POST['token'];

header("Access-Control-Allow-Origin: *");

$url = 'https://api.trello.com/1/members/me?key='.$_SESSION["key"].'&token='.$_SESSION["token"]; 

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 

$data = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 
$data = json_decode($data);

$_SESSION["id"] =$data->id;
$_SESSION["name"] =$data->fullName;
$_SESSION["email"] =$data->aaEmail;
$_SESSION["avatar"] =$data->avatarHash;

$url = 'https://api.trello.com/1/members/'.$_SESSION["id"].'/organizations?key='.$_SESSION["key"].'&token='.$_SESSION["token"]; 

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 

$res = curl_exec($ch); 
$httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); 
$res = json_decode($res);

$_SESSION["organizationId"] = $res[0]->id;
$_SESSION["organizationName"] = $res[0]->name;

header('location:boards.php');

