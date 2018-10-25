<?php 
require_once("../../ecom_resources/config.php");

include(TEMPLATE_BACK .DS. "header.php");
?>

<?php

if(!isset($_SESSION['username'])){
    redirect("../../public/");
    //you can also redirect to login page as that is more sensible
    //but a user cannot login without admin permission
}
?>

        <div id="page-wrapper">

            <div class="container-fluid">


                <!-- codes for the ADMIN center page to go here -->
                <!-- this is created so that each sidebar click will modify this content-->
                <?php


                if ($_SERVER['REQUEST_URI'] ==    "/~deepavarma/WebsiteBuilder/ecommerce/public/admin/"  || 
                $_SERVER['REQUEST_URI'] == "/~deepavarma/WebsiteBuilder/ecommerce/public/admin/index.php" ){
                    include(TEMPLATE_BACK. DS. "admin_content.php");
                } ;

                if(isset($_GET['orders'])){
                    include(TEMPLATE_BACK. DS. "orders.php");
                }
                if(isset($_GET['delete_order_id'])){
                    include(TEMPLATE_BACK. DS. "delete_order.php");
                }
                if(isset($_GET['reports'])){
                    include(TEMPLATE_BACK. DS. "reports.php");
                }
                if(isset($_GET['delete_report_id'])){
                    include(TEMPLATE_BACK. DS. "delete_report.php");
                }
                if(isset($_GET['products'])){
                    include(TEMPLATE_BACK. DS. "products.php");
                }
                if(isset($_GET['add_product'])){
                    include(TEMPLATE_BACK. DS. "add_product.php");
                }
                if(isset($_GET['categories'])){
                    include(TEMPLATE_BACK. DS. "categories.php");
                }
                if(isset($_GET['users'])){
                    include(TEMPLATE_BACK. DS. "users.php");
                }
                if(isset($_GET['slides'])){
                    include(TEMPLATE_BACK. DS. "slides.php");
                }
                if(isset($_GET['delete_slide_id'])){
                    include(TEMPLATE_BACK. DS. "delete_slide.php");
                }
                if(isset($_GET['edit_product'])){
                    include(TEMPLATE_BACK. DS. "edit_product.php");
                }
                if(isset($_GET['delete_product_id'])){
                    include(TEMPLATE_BACK. DS. "delete_product.php");
                }
                if(isset($_GET['edit_category'])){
                    include(TEMPLATE_BACK. DS. "edit_category.php");
                }
                if(isset($_GET['delete_category_id'])){
                    include(TEMPLATE_BACK. DS. "delete_category.php");
                }
                if(isset($_GET['add_user'])){
                    include(TEMPLATE_BACK. DS. "add_user.php");
                }
                if(isset($_GET['edit_user'])){
                    include(TEMPLATE_BACK. DS. "edit_user.php");
                }
                if(isset($_GET['delete_user_id'])){
                    include(TEMPLATE_BACK. DS. "delete_user.php");
                }

                ?>




            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php  include(TEMPLATE_BACK .DS. "footer.php"); ?>