<?php require_once("../../ecom_resources/config.php");

if(isset($_GET['delete_product_id'])){

$product_id = escape_string($_GET['delete_product_id']);

$query = query("DELETE FROM products WHERE product_id = '$product_id' ");
confirm($query);

set_message("Product deleted");

} else {
set_message("Product could not be deleted");
}

redirect("index.php?products");
?>