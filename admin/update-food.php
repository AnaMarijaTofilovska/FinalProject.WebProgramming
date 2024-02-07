<?php include('partials/menu.php');  ?>


<?php
    //check wheather id is set or not 
    if(isset($_GET['id']))
    {
        //get all the details
        $id=$_GET['id'];

        //SQL query to get the selected food and execute
        $sql2="SELECT * FROM tbl_food WHERE id=$id";
        $res2=mysqli_query($conn,$sql2);

        //Get the value based on query executed
        $row2=mysqli_fetch_assoc($res2);

        //Get individual values of selected food
        $title=$row2['title'];
        $description=$row2['description'];
        $price=$row2['price'];
        $current_image=$row2['image_name'];
        $current_category=$row2['category_id'];
        $featured=$row2['featured'];
        $active=$row2['active'];
    }
    else
    {
        //redirect to Manage Food
        header('location:'.SITEURL.'admin/manage-food.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" ><?php echo $description; ?></textarea>
                        </td>
                    </tr>

                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price" value="<?php echo $price; ?>" >
                        </td>
                    </tr>

                    <tr>
                        <td>Current Image:</td>
                        <td>
                            <?php
                               if($current_image == "")
                               {
                                   //Image not Availble
                                   echo "<div class='error'>Image Not Available</div>";
       
                               }
                               else
                               {
                                  //Image Available 
                                  ?>
                                  <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="100px" >
                                  <?php
                               }
                             ?>
                        </td>
                    </tr>

                    <tr>
                        <td>Select New Image</td>
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
                                                //category available
                                                //get the details of category 
                                                $category_title=$row['title'];
                                                $category_id=$row['id'];
                                               
                                               // echo "<option value='$category_id'>$category_title</option>";
                                               ?>
                                               <option <?php if($current_category==$category_id) {echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                               <?php
                                                }
                                            }
                                            else
                                            {
                                                //category not available
                                                echo "<option value='0'>No Category Found.</option>";
    
                                            }
    
                                     ?>

                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($featured=="Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                            <input <?php if($featured=="No") {echo "checked";} ?> type="radio" name="featured" value="No"> No
                        </td>
                    </tr>

                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                            <input <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No"> No
                        </td>
                    </tr>

                    
                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">


                            <input type="submit" name="submit" value="Update Food" class="btn-danger">
                        </td> 
                    </tr>


            </table>

        </form>

        <?php 

            if(isset($_POST['submit']))
            {
                //echo "Button Clicked";
                //1.Get All The Details from the form 
                $id=$_POST['id'];
                $title=$_POST['title'];
                $description=$_POST['description'];
                $price=$_POST['price'];
                $current_image=$_POST['current_image'];
                $category=$_POST['category'];
                $featured=$_POST['featured'];
                $active=$_POST['active'];

                //2.Upload the image if selected
                    //check wheather upload button is clicked or not 
                    if(isset($_FILES['image']['name']))
                    {
                        //upload button clicked
                        $image_name=$_FILES['image']['name'];//new image name

                        //check wheather the file is available or not 
                        if($image_name !="")
                        {
                            //image is available 
                            //A. Uploading New Image
                            
                            //rename the image 
                            $image_parts = explode('.', $image_name);
                            $ext = end($image_parts);
                            

                            $image_name="Food_Name_".rand(0000,9999).'.'.$ext; //will rename the image

                            //Get the source Path and dest path 
                            $src_path=$_FILES['image']['tmp_name']; 
                            $dest_path="../images/food/".$image_name;

                            //Upload the image 
                            $upload=move_uploaded_file($src_path,$dest_path);

                            //check wheather image is uploaded or not 
                            if($upload==false)
                            {
                                //failed to upload
                                $_SESSION['upload']="<div class='error'>Failed to Upload New Image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php'); //redirect to Manage Foodp page
                                die(); //stop the process
                            }

                            //3.Remove the image if new image is uploaded and current image exsists
                            //B.Remove Current Image if available
                            if($current_image != "")
                            {
                                //current image is available
                                //Remove the image 
                                $remove_path="../images/food/".$current_image;

                                $remove=unlink($remove_path);

                                //check if the image is removed or not 
                                if($remove==false)
                                {
                                    //failed to remove current image 
                                    $_SESSION['remove-failed']="<div class='error'>Failed to Remove Current Image.</div>";
                                    header('location:'.SITEURL.'admin/manage-food.php'); //redirect to Manage Food page
                                    die(); //stop the process
                                }
                            }
                        }
                        else
                    {
                        $image_name=$current_image; //default image when image not selected
                    }

                    }
                    else
                    {
                        $image_name=$current_image; //default image when button is not clicked
                    }
                
                //4.Update the food in DB
        $sql3="UPDATE tbl_food SET
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id='$category',
                featured='$featured',
                active='$active'
                WHERE id=$id
            ";

                //execute the sql query
                $res3=mysqli_query($conn,$sql3);

                //check if it is executed
                if($res3==true)
                {
                    //query executed and food updated
                    $_SESSION['update']="<div class='success'>Food Updated Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php'); //redirect to manage page
                }
                else
                {
                    //failed to update food
                    $_SESSION['update']="<div class='error'>Failed to Update Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php'); //redirect to manage page
                }

                
            }
        ?>


      
    </div>
</div>

<?php include('partials/footer.php');  ?>