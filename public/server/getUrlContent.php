<?php
header('Access-Control-Allow-Origin: *');
echo file_get_contents($_POST['address']);
?>
