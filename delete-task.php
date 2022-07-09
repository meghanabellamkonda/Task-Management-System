<?php
    include('config/constants.php');
    //check task_id in URL

    if(isset($_GET['task_id']))
    {
        //delete the task from database
        //get the task ID
        $task_id =$_GET['task_id'];

        //connect database
        $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select =mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

        //SQL query to delete task
        $sql = "DELETE FROM tbl_tasks WHERE task_id =$task_id";

        //execute query
        $res = mysqli_query($conn, $sql);

        //check if the query executed successfully or not
        if($res==true)
        {
            //query executed successfully and task deleted
            $_SESSION['delete'] ="Task Deleted Successfully";
            //Redirect to Homepage
            header('location:'.SITEURL);
        }
        else
        {
            //Failed to delete task
            $_SESSION['delete_fail'] = "Failed to Delete Task";

            //Redirect to Home page
            header('location:'.SITEURL);
        }
    }
    else
    {
        //Redirect to Home
        header('location:'.SITEURL);
    }
?>
