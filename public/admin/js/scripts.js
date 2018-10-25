$(document).ready(function(){

// $('#demo').hover(
//   function () {
//     $(this).toggle();

 
// });

$('.image_container').click(function(){
var delete_file;

//reloads. this unsets any messages displayed.
location.reload();
return delete_file = confirm("Do you want to delete the file from this page?");
});


});