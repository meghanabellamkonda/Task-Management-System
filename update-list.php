<?php 

    include('config/constants.php'); 
    
    //get the current values of selected list

    if(isset($_GET['list_id']))
    {   
      

        //get the list_id value 
        $list_id = $_GET['list_id'];

        //connect to the database
        $conn= mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

        //select database
        $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());

        //QUERY TO GET THE Value from database
        $sql = "SELECT * FROM tbl_lists WHERE list_id=$list_id";

        //Execute the Query
        $res = mysqli_query($conn,$sql);
        
        //check wether the query executed successfully or not
        if($res==true)
        {
            //get the value from database
            $row =mysqli_fetch_assoc($res); // value is in array

            //printing $row array
            //print_r($row);

            //creating individual variable to save the data
            $list_name =$row['list_name'];
            $list_description=$row['list_description'];
        }
        else
        {
            //go back to manage list page
            header('location:'.SITEURL.'manage-list.php');
        }


    }

?>



<html>
    <head>
        <title>Task Manager with PHP and MYSQL</title>
        <link rel="stylesheet" href ="<?php echo SITEURL; ?>css/style.css" />
    </head>

    <body>
    <div class = "wrapper">
        <h1>TASK MANAGER</h1>

       
            <a class ="btn-secoundary"  href="<?php echo SITEURL; ?>">Home</a>
            <a class ="btn-secoundary"  href="<>php echo SITEURL; ?>">Manage Lists</a>
        

        <h3>Update List Pages</h3>

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
                <td>List Name: </td>
                <td><input type="text" name ="list_name" value ="<?php echo $list_name; ?>" required ="required"></td>
            </tr>

            <tr>
                <td>List Description: </td>
                <td>
                    <textarea name="list_description">
                    <?php echo $list_description; ?> 
                    </textarea>
                </td>
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
    //check whether the update is clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";

        //Get the updated values from our from
        $list_name =$_POST['list_name'];
        $list_description=$_POST['list_description'];

        //connect database
        $conn2 = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

        //select the database
        $db_select2 =mysqli_select_db($conn2,DB_NAME);

        //query to update list
         $sql2 ="UPDATE tbl_lists SET
            list_name = '$list_name',
            list_description = '$list_description'
            WHERE list_id =$list_id
        "; 

        //execute the query
        $res2 =mysqli_query($conn2,$sql2);

        //check whether the query executed successfully or not
        if($res2==true)
        {
            //update successful
            //set the message
            $_SESSION['update'] ='List Updated Successfully';

            //redirect to manage list page
            header('location:'.SITEURL.'manage-list.php');

        }
        else
        {
            //failed to update
            //set session message
            
            $_SESSION ['update_fail'] = "Failed to Update List";
            //Redirect to the update list page
            header('location:'.SITEURL.'update-list.php?list_id='.$list_id);
        }

    }