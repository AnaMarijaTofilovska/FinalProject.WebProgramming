<?php include('partials/menu.php') ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br/> <br/>

        <?php 
            //1.Get id of current admin
            $id=$_GET['id'];

            //2.Create SQL query to get details
            $sql="SELECT * FROM tbl_admin WHERE id=$id";

            //3.Execute the query
            $res=mysqli_query($conn,$sql);

            //4.Check wheather the query is executed or not 
            if($res==TRUE)
            {
                //check if the data is availble or not 
                $count=mysqli_num_rows($res);
                //check if we have admin data or not 
                if($count==1)
                {
                    // get the details
                    //echo "Admin Available";
                    $row=mysqli_fetch_assoc($res);

                    $full_name=$row['full_name'];
                    $username=$row['username'];
                }
                else
                {
                    //redirect to manage admin page 
                    header('location:'.SITEURL.'admin/manage-admin.php'); 
                }
            }

            
        ?>

        <form action="" method="POST">
        <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name  ?>">
                    </td>
                </tr>

                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username  ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-danger">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>


<?php 
    //Check wheather the Submit button is clicked or not 
    if(isset($_POST['submit']))
    {
        //echo "Button clicked";
        //1.Get all the values from form to update
        $id=$_POST['id'];
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];

        //2.SQL query to update admin
        $sql="UPDATE tbl_admin SET
            full_name='$full_name',
            username='$username'
            WHERE id='$id'
        ";

        //3.Execute the query
        $res=mysqli_query($conn,$sql);

        //Check wheather the query executed succesfully or not 
        if($res==true)
        {
            //query executed-admin updated
            $_SESSION['update']="<div class='success'>Admin Updated Successfully</div>";
            //redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //failed to update admin
            //query executed-admin updated
            $_SESSION['update']="<div class='error'>Failed to Update Admin</div>";
            //redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }


    }


?>



<?php include('partials/footer.php') ?>