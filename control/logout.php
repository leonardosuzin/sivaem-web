<?php
session_start();
session_destroy();
header('location: /sivaem-web-main/index.php');
?>