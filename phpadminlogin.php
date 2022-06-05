<?php
session_start();

$admin=$_POST['admin'];
$pass=$_POST['pass'];
if($admin=="admin" and $pass=="admin"){
	echo "LOGIN SUCCESSFUL";
	$_SESSION['admin']=$admin;
}else{
	echo "ADMIN NAME OR PASSWORD IS WRONG";
}