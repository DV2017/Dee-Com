<?php require_once("../../ecom_resources/config.php");

if(isset($_GET['delete_category_id'])){

$cat_id = escape_string($_GET['delete_category_id']);

delete_category($cat_id);

set_message("Category deleted");

} else {
set_message("Category could not be deleted");
}

redirect("index.php?categories");
?>