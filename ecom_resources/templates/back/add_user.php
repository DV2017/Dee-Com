<!-- add_user.php-->

<?php 
//function to add the new user
add_new_user(); 
?>


<div class="col-lg-12">

    <p class="bg-info"><?php display_message();?></p>
    
    <h1 class="page-header">
        Add User
        <small>Page</small>
    </h1>

    <!-- add image -->
    <div class="col-md-4 user_img_box">
    
        <span id="user_admin" class="fa fa-user fa-4x"></span>
    
    </div>


    <form action="" method="post" enctype="multipart/form-data">

        <div class="col-md-6">

            <div class="form-group">
              <input type="file" name="file">
            </div>

            <div class="form-group">
              <label for="firstname">Firstname</label>
              <input type="text" name="firstname" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="lastname">Lastname</label>
              <input type="text" name="lastname" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>

            <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
        
            <div class="form-group">
            
            <a href="" class="btn btn-danger">Delete</a>
            <input type="submit" name="add_user" class="btn btn-primary pull-right" value="Add User">
            
            </div>
        
        </div>
       
    </form>
    
</div>
