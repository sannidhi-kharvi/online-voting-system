<?php
session_start();
    
unset($_SESSION['aadhaar']);
header("location: userlogin.php");