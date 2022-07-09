<?php
include('config/constants.php');
?>

<html>
    <head>
        <title>Task Manager with PHP and MYSQL</title>
        <link rel="stylesheet" href ="<?php echo SITEURL; ?>css/style.css" />

        <body>
        <div class = "wrapper">
            
        <h1>TASK MANAGER</h1>
        
        <a class="btn-secoundary" href="<?php echo SITEURL; ?>">Home</a>
        <a class ="btn-secoundary" href="<?php echo SITEURL; ?>manage-list.php">Manage List</a>

        <h3>Add List Page</h3>

        <p>
        <?php
        //Check whether the session is created or not

        if(isset($_SESSION['add_fail']))
        {
            echo $_SESSION['add_fail'];
            //Remove the message after displaing once
            unset($_SESSION['add_fail']);
        }
        ?>
        </p>

        <!--Form to add list start here-->

        <form method ="POST" action ="">
            <table class="tbl-half">
                <tr>
                    <td>List Name: </td>
                    <td ><input type="text" name="list_name" placeholder ="Type list name here" required="required"/></td>
                </tr>
                <tr>
                    <td>List Description:</td>
                    <td><textarea name="list_description" id="" cols="30" rows="10" placeholder="Type list Description Here"></textarea></td>
                </tr>

                <tr>
                    <td><input class="btn-primary btn-lg" type="submit" name="submit" value ="SAVE"></td>
                </tr>
            </table>
        </form>
        <!--Form to add list ends  here-->
        </div>
        </body>
    </head>
</html>

<?php

    //Check whether the form is submitted or not
    if(isset($_POST['submit']))
    {
        //echo "Form submitted";

        //Get the values from the form and save it in variales
        $list_name =$_POST['list_name'];
        $list_description =$_POST['list_description'];

        //Connect Database

        $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

        //Check whether the database connected or not
        /*
        if($conn==true)
        {
            echo "Database connected";
        }

        */

        //Select Database

        $db_select=mysqli_select_db($conn,'task_manager');

        //check whether database is connectd or not
        /*
        if($db_select==true)
        {
            echo "Database selected";
        }
        */
    
        //SQL QUERY Insert into database
     $sql ="INSERT INTO tbl_lists SET
        list_name = '$list_name',
        list_description ='$list_description'
    ";

    //Execute query and insert into database
    $res =mysqli_query($conn,$sql);
    

    //check whether the query executed successfully or not

    if($res==true)
    {
        //Data inserted successfully
        //echo "Data inserted";

        //create a SESSION variable to Display message
        $_SESSION['add'] = 'List Added Successfully';
        //Redirect to Manage List page
        header('location:'.SITEURL.'manage-list.php');

    }
    else
    {
        //Failed to insert data
        //echo "Failed to Insert Data";
        //Create session to save message
        $_SESSION['add_fail'] = "Failed to Add List";
        //Redirect to same page
        header('location:'.SITEURL.'add-list.php');
    }
    }

?>