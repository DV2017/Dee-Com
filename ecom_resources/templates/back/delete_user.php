<?php require_once("../../ecom_resources/config.php");

if(isset($_GET['delete_user_id'])){

$user_id = escape_string($_GET['delete_user_id']);

delete_user($user_id);

set_message("User deleted");

} else {
set_message("User could not be deleted");
}

redirect("index.php?users");
?>