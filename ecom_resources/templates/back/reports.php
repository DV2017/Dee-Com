<div class="col-md-12">
<div class="row">
<h4 class="bg-info"><?php display_message();?></h4>
<h1 class="page-header">
   All Reports

</h1>
</div>

<div class="row">
<table class="table table-hover">
    <thead>

      <tr>
           <th>Order Id</th>
           <th>Report Id</th>
           <th>Product Id</th>
           <th>Product Title</th>
           <th>Product Price</th>
           <th>Product Quantity</th>
           <th>Delete</th>
      </tr>
    </thead>
    <tbody>     
        <?php echo show_reports_in_admin();?>
    </tbody>
</table>
</div>