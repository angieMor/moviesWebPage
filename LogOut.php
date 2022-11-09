<?php
# Closes the account of the user, redirecting him to the Login section
session_start();   
session_destroy();  
header("Location:Login.php");   
exit;

?>