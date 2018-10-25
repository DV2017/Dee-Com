<?php require_once("../ecom_resources/config.php");?>
<?php include(TEMPLATE_FRONT. DS . "header.php"); ?>
    <!-- Page Content -->
    <div class="container">
        <!-- /.row --> 
        <div class="row">
            <p class="bg-danger"><?php display_message(); ?></p> 
            <h1>Checkout</h1>
            <!--paypal form; https://developer.paypal.com/docs/classic/paypal-payments-standard/integration-guide/formbasics/#auto-fill-forms-with-html-variables-->
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_cart">
            <input type="hidden" name="business" value="dbusiness@mail.com">
                <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>Product</th>
                    <th>Product Image</th>
                    <th>Price/unit</th>
                    <th>Quantity</th>
                    <th>Sub-total</th>
                
                    </tr>
                    </thead>
                    <tbody>
                        <?php cart();?>
                    </tbody>
                </table>
                
                <!--paypal button-->
                <?php echo show_paypalButton();?>
            </form>
        <!--  ***********CART TOTALS*************-->     
            <div class="col-xs-4 pull-right ">
                <h2>Cart Totals</h2>

                <table class="table table-bordered" cellspacing="0">
                    <tbody>
                        <tr class="cart-subtotal">
                        <th>Items:</th>
                        <td><span class="amount">
                                    <?php 
                                    //print total Items if isset
                                    echo isset($_SESSION['items_quantity']) ? $_SESSION['items_quantity'] : $_SESSION['items_quantity'] = "0";
                                    ?>
                            </span></td>
                        </tr>

                        <tr class="shipping">
                        <th>Shipping and Handling</th>
                        <td>Free Shipping</td>
                        </tr>

                        <tr class="order-total">
                        <th>Order Total</th>
                        <td><strong><span class="amount">&euro;
                                <?php
                                //print Order Total if is set 
                                echo isset($_SESSION['items_total']) ? $_SESSION['items_total'] : $_SESSION['items_total'] = "";
                                ?>
                            </span></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- CART TOTALS-->
    </div> <!-- row -->
 </div><!--Main Content-->
           <hr>
        <!-- Footer -->
<?php include(TEMPLATE_FRONT. DS . "footer.php"); ?>
