<?php

    //Include constants.php
    include('config/constants.php');
    //echo "Delete List Page";

    //check wheter the list_id assigned or not

    if(isset($_GET['list_id']))
    {
        //delete the list from databse

        //get the list_id value from URL OR GET method
        $list_id = $_GET['list_id'];
        //connect to the database
        $conn= mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

        //write the query to delete list from database
        $sql = "DELETE FROM tbl_lists WHERE list_id=$list_id";

        //Execute the Query
        $res = mysqli_query($conn,$sql);

        //check whether the query executed query successfully or not
        if($res==true)
        {
            //Queery Executed Successfully which means list is deleted successfully
            $_SESSION['delete'] ="List Deleted Successfully";

            //Redirect to Manage List Page
            header('location:'.SITEURL.'manage-list.php');
        }
        else
        {
            $_SESSION['delete_fail'] = "Failed to Delete List";
            header('location:'.SITEURL.'manage-list.php');
        }
    }
    else
    {
        //Redirect to Manage List page
        header('location:'.SITEURL.'manage-list.php');

    }
    
    

    
    
    
?>