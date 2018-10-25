<?php require_once("../../ecom_resources/config.php");

if(isset($_GET['delete_order_id'])){

$order_id = escape_string($_GET['delete_order_id']);

delete_order($order_id);

set_message("Order deleted");

} else {
set_message("Order could not be deleted");
}

redirect("index.php?orders");
?>