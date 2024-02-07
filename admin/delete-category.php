<?php 
    //Include constants file
    include('../config/constants.php');  
    //echo "Delete Page";
    //Check wheather the id and image_name value is set or not 
    if(isset($_GET['id']) AND isset($_GET['image_name']) )
    {
        //Get the value and delete
        //echo "Get Value and Delete";
        $id=$_GET['id'];
        $image_name=$_GET['image_name'];

        //Remove the physical image file if available 
        if($image_name != "")
        {
            //Image is available.So remove it
            $path="../images/category/".$image_name;
            //Remove the image 
            $remove=unlink($path);

            //if failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                //Set the session message 
                $_SESSION['remove']="<div class='error'>Failed to Remove Category Image.</div>";
                //Redirect to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');
                //Stop the process
                die();
            }

        }

        //Delete Data From DB
            //sql query for delete data from db
        $sql="DELETE FROM tbl_category WHERE id=$id";
            //execute the query
        $res=mysqli_query($conn,$sql);

            //Check wheather the data is deleted from DB or not
        if($res==true)
        {
            //set success message and redirect
            $_SESSION['delete']="<div class='success'>Category Deleted Successfully.</div>";
            //redirect to Manage Category 
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //set failed message and redirect 
            $_SESSION['delete']="<div class='error'>Failed to Delete Category.</div>";
            //redirect to Manage Category 
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        
    }
    else
    {
        //redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }


?>