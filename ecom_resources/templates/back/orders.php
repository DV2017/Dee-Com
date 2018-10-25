<div class="col-md-12">
<div class="row">
<h4 class="bg-info"><?php display_message();?></h4>
<h1 class="page-header">
   All Orders

</h1>
</div>

<div class="row">
<table class="table table-hover">
    <thead>

      <tr>
           <th>Order Id</th>
           <th>Transaction</th>
           <th>Amount</th>
           <th>Currency</th>
           <th>Status</th>
           <th>Delete</th>
      </tr>
    </thead>
    <tbody>     
        <?php echo show_orders_in_admin();?>
    </tbody>
</table>
</div>