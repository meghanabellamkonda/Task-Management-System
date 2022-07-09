<?php
include('config/constants.php');
?>

<html>
    <head>
        <title>Task Manager with PHP AND MYSQL</title>
        <link rel="stylesheet" href ="<?php echo SITEURL; ?>css/style.css" />
    </head>
    <body>
    <div class = "wrapper">
            <h1>TASK MANAGER</h1>
            <a class="btn-secoundary" href="<?php echo SITEURL; ?>">Home</a>
            <h3>Manage List Page</h3>

            <p>
            
            <?php
             // check whetehr the session is SET

                if(isset($_SESSION['add']))
                {   //Display message
                    echo $_SESSION['add'];
                    //remove the message after displaying one time
                    unset($_SESSION['add']);
                }



                //check the session for delete
                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);


                }
                    //check session message for update
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);


                }



                //check for delete fail

                if(isset($_SESSION['delete_fail']))
                {
                    echo $_SESSION['delete_fail'];
                    unset($_SESSION['delete_fail']);
                }
            ?>
            
            </p>
            <!--Table to display lists starts here-->
            <div class="all-lists">
                <a class="btn-primary" href="<?php echo SITEURL; ?>add-list.php">Add List</a>
                <table class="tbl-half">
                    <tr>
                        <th>S.N.</th>
                        <th>List Name</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        //connect the database
                        $conn =mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

                        //select database
                        $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error());

                        //SQL query to display all data from database
                        $sql ="SELECT * FROM tbl_lists";

                        //Execute the query
                        $res = mysqli_query($conn,$sql);

                        //check whether the query executed successfully or not
                        if($res == true)
                        {
                            //work on displaying data
                            //echo "Executed";

                            //count the rows of data in database
                            $count_rows = mysqli_num_rows($res);

                            //create a serial number variable
                            $sn =1;

                            //check whether there is data in database or not
                            if($count_rows>0)
                            {
                                //There's data in database 'Display in table'

                                while($row =mysqli_fetch_assoc($res))
                                {//getting the data from database
                                    $list_id =$row['list_id'];
                                    $list_name =$row['list_name'];
                                    ?>
                                        <tr>
                                            <td><?php echo $sn++; ?> </td>
                                            <td><?php echo $list_name; ?></td>
                                            <td>
                                            <a href="<?php echo SITEURL; ?>update-list.php?list_id=<?php echo $list_id; ?>">Update</a>
                                            <a href="<?php echo SITEURL; ?>delete-list.php?list_id=<?php echo $list_id; ?>">Delete</a>
                                            </td>
                                        </tr>


                                    <?php


                                }
                            }
                            else
                            {
                                //no data in database
                                ?>

                                <tr>
                                <td colspan ="3">No List Added Yet.</td>
                                </tr>
                                <?php

                            }
                        }
                    ?>
                    
                </table>
            </div>
            <!--Table to display lists ends here-->
            </div>
    </body>
</html>