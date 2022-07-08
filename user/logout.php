<?php
session_start();

session_unset();
session_destroy();
echo "Logged out... redirecting to main";
header("refresh:1;../index.php");
