<?php include('partials/menu.php'); ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>

        <form action="" method="POST">
            <table class="tb-30">
                <tr>
                    <td>Current Password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Enter current password">
                    </td>
                </tr>

                <tr>
                    <td>New Password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="Enter new password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm new password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                       <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-danger">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>


<?php
    //Check wheather the submit button is clicked or not 
    
    if(isset($_POST['submit']))
    {
        //echo "Clicked";
        //1.Get data from form
        $id=$_POST['id'];
        $current_password=md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        //2.Check wheather the user with current id and current password exist or not 
        $sql="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

            //execute query
            $res=mysqli_query($conn,$sql);
            if($res==true)
            {
                //check if data is available or not 
                $count=mysqli_num_rows($res);
                if($count==1)
                {
                    //User Exsists and Password can be changed 
                    //echo "User Found";
                    //check wheather the new pass and confirm pass match
                    if($new_password==$confirm_password)
                    {
                        //update password
                        //echo "Password match";
                        $sql2="UPDATE tbl_admin SET
                            password='$new_password'
                            WHERE id=$id
                        ";
                        //Execute query
                        $res2=mysqli_query($conn,$sql2);

                        //Check if query executed or not 
                        if($res2==true)
                        {
                            //display success message
                            $_SESSION['change-pwd']="<div class='success'>Password Changed Successfully.</div>";
                            //Redirect User 
                             header('location:'.SITEURL.'admin/manage-admin.php');

                            
                        }
                        else
                        {
                            //display error message
                            $_SESSION['change-pwd']="<div class='error'>Failed to Change Password.</div>";
                            //Redirect User 
                             header('location:'.SITEURL.'admin/manage-admin.php');

                        }

                    }
                    else
                    {
                        //redirect to manage admin page with error message 
                        //User Does not Exsists,Sent Message and Redirect
                        $_SESSION['pwd-not-match']="<div class='error'>Password Did Not Match.</div>";
                        //Redirect User 
                         header('location:'.SITEURL.'admin/manage-admin.php');

                    }
                }
                else
                {
                    //User Does not Exsists,Sent Message and Redirect
                    $_SESSION['user-not-found']="<div class='error'>User Not Found.</div>";
                    //Redirect User 
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

        //3.Check wheather the new password and confirm password match or not 

        //4.Change password if all above is true
    }



?>

<?php include('partials/footer.php'); ?>