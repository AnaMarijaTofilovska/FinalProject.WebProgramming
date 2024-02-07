<?php 
    //Include constants page 
    include('../config/constants.php');

    //echo "Delete Food Page";

    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Process to delete 
        echo "Process to delete";

        //1.Get ID and Image Name
            $id=$_GET['id'];
            $image_name=$_GET['image_name'];

        //2.Remove the image if available
            //check wheather the image is available or not and Delete only if available
            if($image_name != "")
            {
                //has image and need to remove from folder
                //get image path 
                $path="../images/food/".$image_name;

                //remove image file from folder 
                $remove=unlink($path);

                //check wheather the image is removed or not 
                if($remove==false)
                {
                    //failed to remove image 
                    $_SESSION['upload']="<div class='error'>Failed to Remove Image File.</div>";
                   //redirect to Manage Food
                    header('location:'.SITEURL.'admin/manage-food.php');
                    //stop the process of deleting food 
                    die();
                }
            }

        //3.Delete Food from DB
        $sql="DELETE FROM tbl_food WHERE id=$id";
            //execute sql query
        $res=mysqli_query($conn,$sql);

        //check wheather it executed or not,and set session message
        //4.Redirect to Manage Food with session message
        if($res==true)
        {
            //food deleted
            $_SESSION['delete']="<div class='success'>Food Deleted Successfully.</div>";
            //redirect to Manage Food
            header('location:'.SITEURL.'admin/manage-food.php');
             
        }
        else
        {
            //failed to delete food
             $_SESSION['delete']="<div class='error'>Failed to Delete Food.</div>";
             //redirect to Manage Food
             header('location:'.SITEURL.'admin/manage-food.php');
        }


      
    }
    else
    {
        //redirect to Manage Food
        //echo "Redirect";
        $_SESSION['unauthorized']="<div class='error'>Unauthorized Access.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }



?>