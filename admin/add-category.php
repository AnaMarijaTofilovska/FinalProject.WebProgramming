<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>

        <br><br>

        <?php 
        //Display messages
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset ($_SESSION['add']);
                }
                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset ($_SESSION['upload']);
                }
                
         ?>

         <br><br>

        <!--Add Category Form Starts-->
        <form action="" method="POST" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title">
                        </td>
                    </tr>

                    <tr>
                        <td>Select Image:</td>
                        <td>
                            <input type="file" name="image">
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
                            <input type="submit" name="submit" value="Add Category" class="btn-danger">
                        </td> 
                    </tr>

                </table>
        </form>

         <!--Add Category Form Ends-->

         <?php 
            //Check wheater the submit button is clicked or not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";

                //1.Get the value from the category form
                $title=$_POST['title'];
                    
                    //for radio input type we need to check wheather the button is selected or not 
                    if(isset($_POST['featured']))
                    {
                        //Get the value from form 
                        $featured=$_POST['featured'];
                    }
                    else
                    {
                        //Set the default value
                        $featured="No";
                    }

                    if(isset($_POST['active']))
                    {
                        //Get the value from form 
                        $active=$_POST['active'];
                    }
                    else
                    {
                        //Set the default value
                        $active="No";
                    }

                    //check wheather the image is selected or not and set the value for image name accordingly
                    //print_r($_FILES['image']);
                    //die(); //break the code here 

                    if(isset($_FILES['image']['name']))
                    {
                        //upload the image
                        //to upload image we need image name,source path and destination path 
                        $image_name=$_FILES['image']['name'];

                        //Upload Image only if image is selected
                        if($image_name != "")
                        {

                                //Auto Rename Image 
                                //Get the extension of our image (.jpg,.png,.gf,etc.) e.g. 'specialfood1.jpg'
                                $ext=end(explode('.', $image_name));

                                //rename the image 
                                $image_name="Food_Category_".rand(000,999).'.'.$ext; //e.g. Food_Category_834.jpg


                                $source_path=$_FILES['image']['tmp_name'];

                                $destination_path="../images/category/".$image_name;

                                //finally upload the image 
                                $upload=move_uploaded_file($source_path, $destination_path);

                                //check wheather the image is uploaded or not 
                                //if the image is not uploaded then we will stop the process and redirect with error message 
                                if($upload==false)
                                {
                                    //set message 
                                    $_SESSION['upload']="<div class='error'>Failed to Upload Image.</div>";
                                    //redirect to add category page
                                    header('location:'.SITEURL.'admin/add-category.php');
                                    //stop the process
                                    die();
                                }
                    }
                    }
                    else
                    {
                        //don't upload image and set the image name value as blank
                        $image_name="";
                    }

                //2.Create SQL query to insert Category into DB
                $sql="INSERT INTO tbl_category SET 
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                //3.Execute the query and save into DB
                $res=mysqli_query($conn,$sql);

                //4.Check wheather the query executed or not and data added or not
                if($res==true)
                {
                    //query executed and category added
                    $_SESSION['add']="<div class='success'>Category Added Successfully.</div>";
                    //redirect to category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //failed to add category
                    $_SESSION['add']="<div class='error'>Failed to Add Category.</div>";
                    //redirect to add category
                    header('location:'.SITEURL.'admin/add-category.php');

                }
            }
         
         ?>

    </div>
</div>




<?php include('partials/footer.php'); ?>