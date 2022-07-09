<?php
include('config/constants.php');
?>

<html>
<head>
<title>Task Manager with PHP and Mysql</title>
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

 <!-- Task Starts Here-->

         <p>
            <?php
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['delete']))
            {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['delete_fail']))
            {
                echo $_SESSION['delete_fail'];
                unset($_SESSION['delete_fail']);
            }

            ?>


         </p>
 <div class="all-tasks">
    
    <a class="btn-primary" href="<?php SITEURL; ?>add-task.php">Add Task</a>

    <table class="tbl-full">

        <tr>

            <th>S.N.</th>
            <TH>Task Name</TH>
            <th>priority</th>
            <th>Deadline</th>
            <th>Actions</th>
        </tr>

        <?php
                //connect database

                $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

                //select database
                $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error());

                //create sql query to get data from database
                $sql =" SELECT * FROM tbl_tasks";

                //Execute query
                $res =mysqli_query($conn, $sql);

                //check whether the query executed or not
                if($res==true)
                {
                    //display the tasks from database
                    //count the tasks on the database first
                    $count_rows =mysqli_num_rows($res);

                    //check whether there is task on database or not
                    if($count_rows>0)
                    {
                        //data is in database
                        $sn =1;
                        while($row=mysqli_fetch_assoc($res))
                        {
                            $task_id = $row['task_id'];
                            $task_name=$row['task_name'];
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
                    else
                    {
                        //no data is in database
                        ?>
                        <tr>
                            <td colspan ="5">No Task Added Yet</td>
                        </tr>
                        <?php
                    }
                }
        ?>
            
    </table>

 </div>
 <!-- Task Ends Here-->

 </div>
</body>
</html>