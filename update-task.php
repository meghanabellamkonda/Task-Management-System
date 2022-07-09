<?php
    include('config/constants.php');


    //Check the Task ID in URL
    if(isset($_GET['task_id']))
    {
        //Get the value from database
        $task_id=$_GET['task_id'];

        //connect database
        $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select = mysqli_select_db($conn,DB_NAME) or die(mysqli_error());

        //sql query to get the details of selected task
        $sql ="SELECT * FROM tbl_tasks WHERE task_id= $task_id";

        //execute query
        $res =mysqli_query($conn, $sql);
        
        //check if the qurery executed successfully or not
        if($res==true)
        {
            //query is executed
            $row =mysqli_fetch_assoc($res);

            //get the individual value
            $task_name =$row['task_name'];
            $task_description = $row['task_description'];
            $list_id = $row['list_id'];
            $priority =$row['priority'];
            $deadline =$row['deadline'];

        }


    }
    else
    {
        //Redirect to Homepage
        header('location:'.SITEURL);
    }
?>



<html>
    <head>
        <title>Task Manager With PHP and MYSQL</title>
        <link rel="stylesheet" href ="<?php echo SITEURL; ?>css/style.css" />
    </head>

    <body>
    <div class = "wrapper">
        <h1>TASK MANAGER</h1>

        <p>
            <a class="btn-secoundary" href="<?php echo SITEURL;?>">Home</a>
        </p>

        <h3>Update Task Page</h3>

        <p>
            <?php
                if(isset($_SESSION['update_fail']))
                {
                    echo $_SESSION['update_fail'];
                    unset($_SESSION['update_fail']);
                }
            ?>
        
        </p>

        <form method ="POST" action="">

            <table class="tbl-half">
                <tr>
                    <td>Task Name: </td>
                    <td><input type="text" name ="task_name" value ="<?php echo $task_name; ?>" required ="required"></td>
                </tr>

                <tr>
                    <td>Task Description: </td>
                    <td>
                        <textarea name="task_description">
                        <?php echo $task_description; ?>
                        </textarea>
                    </td>
                    </tr>

                    <tr>
                        <td>Select List: </td>
                        <td>
                            <select name="list_id" id="">

                                <?php
                                    //connect database
                                    $conn2 = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

                                    //select database
                                    $db_select2 = mysqli_select_db($conn2,DB_NAME) or die(mysqli_error());

                                    //sql query to get list
                                    $sql2 ="SELECT * FROM tbl_lists";

                                    //execute query
                                    $res2 =mysqli_query($conn2, $sql2); 

                                    //check if executed successfully or not
                                    if($res2==true)
                                    {
                                        //display the list
                                        //count rows
                                        $count_rows2 =mysqli_num_rows($res2);

                                        //check whether list is added or not

                                        if($count_rows2>0)
                                        {
                                            //list or added

                                            while($row2 =mysqli_fetch_assoc($res2))
                                            {
                                                //get individual value
                                                $list_id_db =$row2['list_id'];
                                                $list_name = $row2['list_name'];
                                                ?>
                                                    <option <?php if($list_id_db==$list_id){echo "selected='selected'";}  ?> value="<?php echo $list_id; ?>"><?php echo $list_name; ?></option>
                                                <?php
                                            }
                                        }
                                        else{
                                        
                                            //no list added
                                             //display none as option
                                        ?>
                                        <option <?php if($list_id=0){echo "selected='selected'";}?> value="0">None</option>
                                        <?php
                                        }
                                    }
                                ?>
                                

                                </select>
                        </td>
                    </tr>

                    <tr>
                    <td>priority</td>
                    <td>
                        <select name="priority" id="">
                            <option <?php if($priority =="High"){echo "selected= 'selected'";} ?> value="High">High</option>
                            <option <?php if($priority =="Medium"){echo "selected= 'selected'";} ?> value="Medium">Medium</option>
                            <option <?php if($priority =="Low"){echo "selected= 'selected'";} ?>value="Low">Low</option>
                        </select>
                    </td>
                </tr>

                    <tr>
                        <td>Deadline: </td>
                        <td><input type="date" name="deadline" value ="<?php echo $deadline; ?>"></td>
                    </tr>

                    <tr>
                        <td><input class="btn-primary btn-lg" type="submit" name ="submit" value ="UPDATE"></td>
                    </tr>
            </table>
        
        </form>
        </div>
    </body>
</html>



<?php

//check if the button is cliked
         if(isset($_POST['submit']))
        {
            //echo "Clicked";

            //get the values from form

            $task_name = $_POST['task_name'];
            $task_description =$_POST['task_description'];
            $list_id = $_POST['list_id'];
            $priority =$_POST['priority'];
            $deadline =$_POST['deadline'];

            //connect to database
            $conn3 = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

            //select database
            $db_select3 = mysqli_select_db($conn3,DB_NAME) or die(mysqli_error());

            //create sql query to update task
            $sql3 ="UPDATE tbl_tasks SET
            task_name = '$task_name',
            task_description ='$task_description',
            list_id ='$list_id',
            priority = '$priority',
            deadline = '$deadline'

            WHERE
            task_id =$task_id
            
            ";

            //execute query

            $res3 = mysqli_query($conn3 ,$sql3);

            //check wheter the query executed or not
            if($res3==true)
            {
                //query executed  and task updated
                $_SESSION['update'] ="Task Update successfully";

                //redirect to home page
                header('location:'.SITEURL);
            }
            else{
                $_SESSION['update_fail'] = "Failed to Update Task";

                //Redirect to the page
                header('location:'.SITEURL.'update-task.php?task_id='.$task_id);
            }
        }

?>