<?php 
    //Include constants.php file here
    include('../config/constants.php');

    //1.Get ID of Admin to be deleted 
     $id=$_GET['id'];

    //2.Create SQL Query to delete Admin
    $sql="DELETE FROM tbl_admin WHERE id=$id";

    //Execute the Query
    $res=mysqli_query($conn,$sql);

    //Check wheather the query executed successfully or not 
    if($res==true)
    {
        //query executed successfully and admin deleted 
        //echo "Admin deleted";

        //Creating session variable to display message 
        $_SESSION['delete']="<div class='success'>Admin Deleted Successfully.</div>";
        //Redirect to Manage Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');

    }
    else
    {
        //failed to delete admin 
        //echo "Failed to delete Admin";

        //Creating session variable to display message 
        $_SESSION['delete']="<div class='error'>Failed to Delete Admin. Try Again Later.</div>";
        //Redirect to Manage Admin page
        header('location:'.SITEURL.'admin/manage-admin.php');

    }

    //3.Redirect to Manage Admin Page with message (success/error)



?>