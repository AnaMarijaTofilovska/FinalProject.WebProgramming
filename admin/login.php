<?php include('../config/constants.php'); ?>


<html>
        <head>
            <title>Login - Food Order System</title>
            <link rel="stylesheet" href="../css/admin.css">

            <style>
        body {
            background-color:#ff6b81; /* Set your desired background color for the entire page */  
        }

        .login {
            background-color: #ffffff; /* Set your desired background color for the form */ 
             
        }
    </style>
        </head>

        <body>
            <div class="login">
                <h1 class="text-center">Login</h1> 
                <br><br>
                
                <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset ($_SESSION['login']);
                }
                if(isset($_SESSION['no-login-message']))
                {
                    echo  $_SESSION['no-login-message'];
                    unset( $_SESSION['no-login-message']);
                }
                ?>
                <br><br>

                <!-- Login Form Starts Here -->
                    <form action="" method="POST" class="text-center">
                        Username: <br>
                        <input type="text" name="username" placeholder="Enter Username"><br><br>

                        Password:<br>
                        <input type="password" name="password" placeholder="Enter Password"><br><br>

                        <input type="submit" name="submit" value="Login" class="btn-danger">
                        <br><br>
                    </form>
                    
                    <p class="text-center">
                        <a style="color: pink;" href="<?php echo SITEURL;?>">Access <b>wowFood</b> site!</a>
                    </p>

                 <!-- Login Form Ends Here -->
            </div>
        </body>
</html>

<?php

    //Check wheather the submit button is clicked or not 
    if(isset($_POST['submit']))
    {
        //Process for login 
        //1.Get the data from login form 
         $username=mysqli_real_escape_string($conn,$_POST['username']); //escape unwanted values
         $raw_password=md5($_POST['password']); //and encrypt password
         $password=mysqli_real_escape_string($conn,$raw_password);

        //2.SQL to check wheather the user with username and password exsists or not
        $sql="SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3.Execute the query
        $res=mysqli_query($conn,$sql);

        //4.Count rows to check wheather the user exsists or not 
        $count=mysqli_num_rows($res);

        if($count==1)
        {
            //User available and Login Success
            $_SESSION['login']="<div class='success'>Login Successfull.</div>";
            $_SESSION['user']=$username; //to check wheather the user is logged in or not and logout will unset it 

            //Redirect to homepage/dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //User not availble and Login Failed
            $_SESSION['login']="<div class='error text-center'>Username and Password Didn't Match.</div>";
            //Redirect to Login
            header('location:'.SITEURL.'admin/login.php');
        }

    }


?>