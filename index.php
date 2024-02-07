<?php include('partials-front/menu.php'); ?>

    <!-- Food Search Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- Food Search Section Ends Here -->

    <?php 
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset ($_SESSION['order']);
        }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //Create SQL Query to display categories from DB
                $sql="SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                //Execute the query
                $res=mysqli_query($conn,$sql);
                //count the rows to check if the category is available or not 
                $count=mysqli_num_rows($res);
                
                if($count>0)
                {
                    //Categories Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                       //Get the values like id,title,image_name  
                       $id=$row['id'];
                       $title=$row['title'];
                       $image_name=$row['image_name'];
                       ?>

                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php
                                    //Check if Image is available or not 
                                        if($image_name=="")
                                        {
                                            //Display message
                                            echo "<div class='error'>Image Not Available.</div>";
                                        }
                                        else
                                        {
                                            //Image Available 
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                                    
                                    ?>
                                    

                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>

                       <?php
                    }
                }
                else
                {
                    //Categories Not Available
                    echo "<div class='error'>Category not Added.</div>";
                }
             ?>

           

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- Food Menu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

                //Getting Foods From DB that are ACTIVE and FEATURED
                $sql2="SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
                //Execute the query
                $res2=mysqli_query($conn,$sql2);
                //Count the rows
                $count2=mysqli_num_rows($res2);
                //Check if food available or not 
                if($count2>0)
                {
                    //Food Available 
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        //Get All the Values
                        $id=$row['id'];
                        $title=$row['title'];
                        $price=$row['price'];
                        $description=$row['description'];
                        $image_name=$row['image_name'];
                        
                        ?>

                            <div class="food-menu-box">
                                            <div class="food-menu-img">
                                                <?php 
                                                    //Check if Image Available or Not
                                                    if($image_name=="")
                                                    {
                                                        //Image Not Available 
                                                        echo "<div class='error'>Image Not Available.</div>";
                                                        
                                                    }
                                                    else
                                                    {
                                                        //Image Available
                                                        ?>
                                                            <img src="<?php echo SITEURL; ?>images/food/<?php  echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                                        <?php
                                                    }
                                                
                                                ?>
                                               
                                            </div>

                                            <div class="food-menu-desc">
                                                <h4><?php echo $title; ?></h4>
                                                <p class="food-price">$<?php echo $price; ?></p>
                                                <p class="food-detail">
                                                    <?php echo $description; ?>
                                                </p>
                                                <br>

                                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                            </div>
                             </div>`

                        <?php
                    }
                    
                }
                else
                {
                    //Food Not Available
                    echo "<div class='error'>Food Not Available.</div>";
                }

             ?>

            


            <div class="clearfix"></div>

            

        </div>

        <p class="text-center">
            <a href="<?php echo SITEURL;?>foods.php">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>