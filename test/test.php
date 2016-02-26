<?php
// if this page was not called by AJAX, die
if (!$_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') die('Invalid request');

// get variable sent from client-side page
$my_variable = isset($_POST['my_variable']) ? strip_tags($_POST['my_variable']) :null;

$vvid = $_REQUEST['status'];
echo $vvid;
//run some queries, printing some kind of result
// $SQL = "SELECT * FROM myTable";
// echo results

echo $my_variable;
?>