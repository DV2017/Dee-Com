<!-- edit_user.php-->
<?php update_user();?>

<?php
//display details to edit
if(isset($_GET['id'])){
    $user_id = escape_string($_GET['id']);

    $query = query("SELECT * FROM users WHERE user_id='$user_id' ");
    confirm($query);

    while($row = fetch_array($query)){
        $firstname = escape_string($row['firstname']);
        $lastname = escape_string($row['lastname']);
        $username = escape_string($row['username']);
        $email = escape_string($row['email']);
        $password = escape_string($row['password']);
        $user_image = escape_string($row['user_image']);
    }
}
?>


<div class="col-lg-12">

    <p class="bg-info"></p>
    
    <h1 class="page-header">
        Edit User
        <small>Page</small>
    </h1>

    <!-- add image -->
    <div class="col-md-4 user_img_box">
    
        <img width="250" src="../../ecom_resources/uploads/<?php echo $user_image;?>" alt="">
    
    </div>


    <form action="" method="post" enctype="multipart/form-data">

        <div class="col-md-6">

            <div class="form-group">
              <input type="file" name="file">
            </div>

            <div class="form-group">
              <label for="firstname">Firstname</label>
              <input type="text" name="firstname" class="form-control" value="<?php echo $firstname;?>" required>
            </div>

            <div class="form-group">
              <label for="lastname">Lastname</label>
              <input type="text" name="lastname" class="form-control" value="<?php echo $lastname;?>" required>
            </div>

            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" class="form-control" value="<?php echo $username;?>">
            </div>

            <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $email;?>">
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" value="<?php echo $password;?>">
            </div>
        
            <div class="form-group">
                <input type="submit" name="update_user" class="btn btn-primary pull-right" value="Update">            
            </div>
        
        </div>
       
    </form>
    
</div>
