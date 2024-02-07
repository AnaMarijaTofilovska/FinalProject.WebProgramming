 <?php include('partials/menu.php') ?>


        <!--Main Content section starts-->
        <div class="main-content">
            <div class="wrapper">
               <h1>Manage Admin</h1>

               <br/>

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];  //Displaying add session message 
                        unset($_SESSION['add']); //Removing add session message 
                    }
                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];  //Displaying delete session message 
                        unset($_SESSION['delete']); //Removing  delete session message 
                    }
                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];  //Displaying update session message 
                        unset($_SESSION['update']); //Removing  update session message 
                    }
                    if(isset($_SESSION['user-not-found']))
                    {
                        echo $_SESSION['user-not-found'];  //Displaying user-not-found session message 
                        unset($_SESSION['user-not-found']); //Removing  user-not-found session message 
                    }
                    if(isset($_SESSION['pwd-not-match']))
                    {
                        echo $_SESSION['pwd-not-match'];  //Displaying pwd-not-match session message 
                        unset($_SESSION['pwd-not-match']); //Removing  pwd-not-match session message 
                    }
                    if(isset($_SESSION['change-pwd']))
                    {
                        echo $_SESSION['change-pwd'];  //Displaying change-pwd session message 
                        unset($_SESSION['change-pwd']); //Removing  change-pwd session message 
                    }
                    
                ?>

                <br>  <br> <br>
               <!--Button to add Admin-->
               <a href="add-admin.php" class="btn-primary">Add Admin</a>

               <br/><br/><br/>
               

              <table class="tbl-full">
                    <tr>
                        <th>S.N.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                    </tr>

                    
                    <?php 
                    //Displaying admins from DB
                    $sql="SELECT * FROM tbl_admin";
                    //Exectute query
                    $res=mysqli_query($conn,$sql);

                    //Check wheather the query is executed or not 
                    if($res==TRUE)
                    {
                        //Count rows to check wheather we have data in DB or not
                        $count=mysqli_num_rows($res); //function to get all rows in DB 


                        $sn=1; //create a variable and assign the value 


                        //Check the number of rows 
                        if($count>0)
                        {
                            //we have data in DB
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                //using while-loop to get all data from DB
                                //and while-loop will run as long as we have data in DB

                                //get individual data
                                $id=$rows['id'];
                                $full_name=$rows['full_name'];
                                $username=$rows['username'];

                                //Display the values in our table
                                ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $full_name ?></td>
                                    <td><?php echo $username ?></td>
                                    <td>
                                         <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                         <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                         <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                    </td>
                                </tr>


                                <?php
                            }

                        }
                        else
                        {
                            //we do not have data in DB

                        } 
                    }
                    ?>  
                  
              </table>

            </div>
        </div>
        <!--Main Content  section ends-->

<?php  include('partials/footer.php') ?>