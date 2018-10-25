<?php require_once("../../ecom_resources/config.php");

if(isset($_GET['delete_report_id'])){

$report_id = escape_string($_GET['delete_report_id']);

//call function to delete from functions.php
//this hides all database calls from being visible
delete_report($report_id);

set_message("Report deleted");

} else {
set_message("Report could not be deleted");
}

redirect("index.php?reports");
?>