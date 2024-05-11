<?php

session_start();
$conn = mysqli_connect("localhost","root","","project_web");
if(mysqli_connect_errno()){
    echo "Connection Failed".mysqli_connect_error();
    exit;
}

$clientID = '937725869990-8l9bjrm77la23h2n2e4mad80hcrp36u5.apps.googleusercontent.com' ;
$clientSecret = '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' ;

?>