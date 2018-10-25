<?php add_slide(); ?>

<div class="row">

  <p class="bg-info"><?php display_message();?></p>

  <div class="col-xs-3">

    <form action="" method="post" enctype="multipart/form-data">
      <br>
        <div class="form-group">
        <label for="image">Slider Image</label>
          <input type="file" name="file">
        </div>

      <div class="form-group">
        <label for="title">Slide Title</label>
        <input type="text" name="slide_title" class="form-control" required>
      </div>

      <div class="form-group">
        <input class="btn btn-primary" type="submit" name="add_banner">
      </div>
    </form>

  </div>
  
  <!-- view uploaded files -->
  <div class="col-xs-8">  
      <?php  get_current_slide_in_admin(); ?>
  </div>

</div><!-- ROW-->

<hr>

<h1>Slides Available</h1>

<div class="row">
  
<?php show_slides_in_admin();?>

</div>


