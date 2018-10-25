<?php require_once("../../ecom_resources/config.php");

if(isset($_GET['delete_slide_id'])){

$slide_id = escape_string($_GET['delete_slide_id']);

//get the slide file name so that the file can be deleted from its folder
$slide_image = get_slide_name($slide_id);
$image_path = UPLOAD_DIRECTORY. DS. $slide_image;

delete_slide($slide_id);

//unlinking will permanently delete the file from the uploads folder
//unlink($image_path);

set_message("Slide deleted");

} else {
set_message("Slide could not be deleted");
}

redirect("index.php?slides");
?>