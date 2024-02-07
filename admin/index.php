<?php include('partials/menu.php')?>

        <!--Main Content section starts-->
        <div class="main-content">
            <div class="wrapper">
               <h1>Dashboard</h1>

               <br><br>
               <?php 
                    if(isset($_SESSION['login']))
                    {
                         echo $_SESSION['login'];
                         unset ($_SESSION['login']);
                    }
                ?>
                <br><br>

               <div class="col-4 text-center">
                    <?php
                         $sql="SELECT * FROM tbl_category " ; //sql query
                         $res=mysqli_query($conn,$sql); //execute query
                         $count=mysqli_num_rows($res); //count rows
                     ?>
                    <h1><?php echo $count; ?></h1>
                    <br/>
                    Categories
               </div>
               <div class="col-4 text-center">
                     <?php
                         $sql2="SELECT * FROM tbl_food " ; //sql query
                         $res2=mysqli_query($conn,$sql2); //execute query
                         $count2=mysqli_num_rows($res2); //count rows
                     ?>
                    <h1><?php echo $count2 ?></h1>
                    <br/>
                    Foods
               </div>
               <div class="col-4 text-center">
                    <?php
                         $sql3="SELECT * FROM tbl_order " ; //sql query
                         $res3=mysqli_query($conn,$sql3); //execute query
                         $count3=mysqli_num_rows($res3); //count rows
                     ?>
                    <h1><?php echo $count3; ?></h1>
                    <br/>
                    Total Orders
               </div>
               <div class="col-4 text-center">
                    <?php 
                    //Create SQL Query to Get Total Revenue Generated
                    $sql4="SELECT SUM(total) AS Total FROM tbl_order WHERE status='Delivered' ";
                    $res4=mysqli_query($conn,$sql4); //execute
                    $row4=mysqli_fetch_assoc($res4); //get value
                    $total_revenue=$row4['Total']; //get total revenue

                    ?>
                    <h1>$<?php  echo $total_revenue; ?></h1>
                    <br/>
                    Revenue Generated
               </div>
              
               <div class="clearfix"></div>

            </div>
        </div>
        <!--Main Content  section ends-->

<?php include('partials/footer.php') ?>