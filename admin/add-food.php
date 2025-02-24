<?php include('partials/menu.php');  ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>
        
        <?php 
        //Display messages
                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset ($_SESSION['upload']);
                }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Title of the Food">
                        </td>
                    </tr>

                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price" >
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>

                    <tr>
                        <td>Category: </td>
                        <td>
                            <select name="category">

                                <?php
                                    //Create php code to display categories from DB
                                    //1.Create SQL query to get all active categories from DB
                                        $sql="SELECT * FROM tbl_category WHERE active='Yes' ";
                                        $res=mysqli_query($conn,$sql); //executing the query
                                        
                                        //count rows to check if we have categories or not
                                        $count=mysqli_num_rows($res);

                                        //if count is greater than 0 we have categories,else we do not 
                                        if($count>0)
                                        {
                                            //we have categories
                                            while($row=mysqli_fetch_assoc($res))
                                            {
                                                //get the details of category 
                                                $id=$row['id'];
                                                $title=$row['title'];
                                                ?>

                                                    <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                                <?php
                                            }
                                        }
                                        else
                                        {
                                            //we do not have category
                                            ?>

                                            <option value="0">No Category Found.</option>

                                            <?php

                                        }

                                    //2.Display on drop down

                                 ?>

                              
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input type="radio" name="featured" value="Yes"> Yes
                            <input type="radio" name="featured" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input type="radio" name="active" value="Yes"> Yes
                            <input type="radio" name="active" value="No"> No
                        </td>
                    </tr>

                    
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Food" class="btn-danger">
                        </td> 
                    </tr>


            </table>

        </form>

            <?php

                    //Check wheather the button is clicked or not 
                    if(isset($_POST['submit']))
                    {
                        //Add the Food in DB
                        //echo "Button clicked";
                        
                        //1.Get Data from form
                            $title=$_POST['title'];
                            $description=$_POST['description'];
                            $price=$_POST['price'];
                            $category=$_POST['category'];
                            
                                //check wheather the radio button of featured/active are checked or not 
                                if(isset($_POST['featured']))
                                {
                                    $featured=$_POST['featured'];
                                }
                                else
                                {
                                    $featured="No"; //setting default value
                                }

                                if(isset($_POST['active']))
                                {
                                    $active=$_POST['active'];
                                }
                                else
                                {
                                    $active="No"; //setting default value
                                }
                        //2.Upload the Image if selected 
                                //check wheather the select image is clicked or not and upload the image only if the image is selected
                                if(isset($_FILES['image']['name']))
                                {
                                    //get the details of the selected image 
                                    $image_name=$_FILES['image']['name'];

                                    //check if image is selected or not and upload image only if selected
                                    if($image_name != "")
                                    {
                                        //image is selected
                                            //A.Rename the image
                                                    //Auto Rename Image 
                                        //Get the extension of our image (.jpg,.png,.gf,etc.) e.g. 'specialfood1.jpg'
                                        $ext=end(explode('.', $image_name));

                                        //rename the image 
                                        $image_name="Food_Name_".rand(0000,9999).'.'.$ext; //e.g. Food_Name_834.jpg


                                        $src=$_FILES['image']['tmp_name'];

                                        $dst="../images/food/".$image_name;

                                        //finally upload the image 
                                        $upload=move_uploaded_file($src, $dst);

                                        //check wheather the image is uploaded or not 
                                        //if the image is not uploaded then we will stop the process and redirect with error message 
                                        if($upload==false)
                                        {
                                            //set message 
                                            $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";
                                            //redirect to add category page
                                            header('location:'.SITEURL.'admin/add-food.php');
                                            //stop the process
                                            die();
                                }
                                           
                                           
                                    }

                                }
                                else
                                {
                                    $image_name=""; //default value as blank
                                }

                        //3.Insert into DB
                                //sql query to save or add food
                                //for numerical value we dont pass value inside ''
                                $sql2="INSERT INTO tbl_food SET 
                                title='$title',
                                description='$description',
                                price=$price,
                                image_name='$image_name',
                                category_id=$category,
                                featured='$featured',
                                active='$active'
                            ";

                                //Execute the query and save into DB
                                $res2=mysqli_query($conn,$sql2);

                         //4.Redirect with message to manage-food page
                        if($res2==true)
                        {
                            //query executed and food added
                            $_SESSION['add']="<div class='success'>Food Added Successfully.</div>";
                            //redirect to food page
                            header('location:'.SITEURL.'admin/manage-food.php');
                        }
                        else
                        {
                            //failed to add food
                            $_SESSION['add']="<div class='error'>Failed to Add Food.</div>";
                            //redirect to add food
                            header('location:'.SITEURL.'admin/manage-food.php');
        
                        }

                       
                    }
            
            
            ?>

    </div>
</div>


<?php include('partials/footer.php');  ?>