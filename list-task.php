<?php
    include('config/constants.php');

    //get the list if from URL

    $list_id_url = $_GET['list_id'];
?>

<html>
    <head>
        <title>Task Manager with PHP and MYSQL</title>
        <link rel="stylesheet" href ="<?php echo SITEURL; ?>css/style.css" />
    </head>

    <body>
    <div class = "wrapper">
        
        <h1>TASK MANAGER</h1>

        <!--Menu starts here-->
        <div
        class ="menu">
        <a href="<?php echo SITEURL; ?>">Home</a>

            <?php
                //connect displaying lists from database in our menu
                $conn2 = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

                //select database
                $db_select2 = mysqli_select_db($conn2,DB_NAME) or die(mysqli_error());

                //query to get the lists from database
                $sql2 = "SELECT * FROM tbl_lists";

                //execute the query
                $res2 = mysqli_query($conn2,$sql2);

                //check wheter the query executed or not
                if($res2==true)
                {
                    //display the lists in menu
                    while($row2 =mysqli_fetch_assoc($res2))
                    {
                        $list_id = $row2['list_id'];
                        $list_name =$row2['list_name'];

                        ?>

                        <a href="<?php echo SITEURL; ?>list-task.php?list_id=<?php echo $list_id; ?>"><?php echo $list_name; ?></a>

                        <?php
                    }
                }
            ?>
        

            <a href="<?php echo SITEURL; ?>manage-list.php">Manage Lists</a>
        </div>
        <!--Menu ends here-->

        <div class ="all-task">
        
                <a class="btn-primary" href="<?php echo SITEURL; ?>add-task.php">Add Task</a>

                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Task Name</th>
                        <th>priority</th>
                        <th>Deadline</th>
                        <th>Action</th>
                    </tr>

                        <?php
                            $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

                            $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error());

                            $sql = "SELECT * FROM tbl_tasks WHERE list_id =$list_id_url";

                            //execute the query
                            $res = mysqli_query($conn,$sql);

                            if($res == true)
                            {
                                //display the tasks based on list
                                //count the rows
                                $count_rows =mysqli_num_rows($res);

                                if($count_rows>0)
                                {
                                    //we have tasks on this list
                                    $sn =1;
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        $task_id = $row['task_id'];
                                        $task_name = $row['task_name'];
                                        $priority =$row['priority'];
                                        $deadline = $row['deadline'];

                                        
                                        ?>
                                            <tr>
                                                <td><?php echo $sn++; ?> </td>
                                                <td><?php echo $task_name; ?></td>
                                                <td><?php echo $priority; ?></td>
                                                <td><?php echo $deadline; ?></td>
                                                <td>
                                                <a href="<?php echo SITEURL; ?>update-task.php?task_id=<?php echo $task_id; ?>">Update</a>

                                                <a href="<?php echo SITEURL; ?>delete-task.php?task_id=<?php echo $task_id; ?>">Delete</a>
                                                </td>
                    
                                            </tr>
                                        <?php
                                    }

                                }
                                else{
                                    //no taks on the list

                                    ?>

                                    <tr>
                                        <td colspan="5">No Tasks added on this list.</td>
                                    </tr>

                                    <?php
                                }
                            }
                        ?>
                    
                </table>
        
        </div>


        </div>      
    </body>
</html>