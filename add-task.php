<?php
 include('config/constants.php');

?>

<html>
    <head>
        <title>Task Manager With PHP AND MYSQL</title>
        <link rel="stylesheet" href ="<?php echo SITEURL; ?>css/style.css" />
    </head>

    <body>
    <div class = "wrapper">
        <h1>TASK MANAGER</h1>
        
        <a class="btn-secoundary" href="<?php echo SITEURL; ?>">Home</a>

        <h3>Add Task Page</h3>

        <p>
            <?php
            if(isset($_SESSION['add_fail']))
            {
                echo $_SESSION['add_fail'];
                unset($_SESSION['add_fail']);
            }
            ?>
        </p>

        <form  method ="POST" action="">
        
            <table class="tbl-half">
                <tr>
                    <td>Task Name: </td>
                    <td><input type="text" name ="task_name" placeholder="Type your Task here" required ="required"></td>               
                </tr>

                <tr>
                    <td>Task Description</td>
                    <td><textarea name="task_description" id="" cols="30" rows="10" placeholder="Type Task Description">
                    
                    </textarea> </td>
                </tr>
                <tr>
                    <td>Select List:</td>

                    <td>
                        <select name="list_id" id="">

                            <?php
                                //Connect Database
                                $conn = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

                                //select database
                                $db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());

                                //SQL query to ger the list from table
                                $sql ="SELECT * FROM tbl_lists";

                                //Execute query
                                $res = mysqli_query($conn,$sql);

                                //check whether the query executed or not

                                if($res == true)
                                {
                                    //create variable to count rows
                                    $count_rows =mysqli_num_rows($res);

                                    //if there is data in database then display all the dropdwon else display none as option

                                    if($count_rows>0)
                                    {
                                        //display all lists on dropdown from database
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            $list_id = $row['list_id'];
                                            $list_name = $row['list_name'];
                                            ?>
                                            <option value="<?php echo $list_id ?>"><?php echo $list_name; ?></option>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        //display rows as option
                                        ?>
                                        <option value="0">None</option>
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
                            <option value="High">High</option>
                            <option value="Medium">Medium</option>
                            <option value="Low">Low</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Deadline</td>
                    <td><input type="date" name ="deadline"></td>
                </tr>

                <tr>
                    <td> <input  class ="btn-primary btn-lg" type="submit" name ="submit" value ="SAVE"></td>
                
                </tr>

            </table>
        
        </form>
        </div>
    </body>

</html>

<?php
//check wheter the save button is clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Button clicked"

        //get all the values from the form
        $task_name = $_POST['task_name'];
        $task_description =$_POST['task_description'];
        $priority =$_POST['priority'];
        $deadline =$_POST['deadline'];

        //connect database
        $conn2 = mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());

        //select the database
        $db_select2 =mysqli_select_db($conn2,DB_NAME);

        //create sql query to insert data into database
           $sql2 ="INSERT INTO tbl_tasks SET
             task_name = '$task_name',
             task_description = '$task_description',
             list_id =$list_id,
             priority = '$priority',
             deadline = '$deadline'
        ";

        //Exccute the query
            $res2 = mysqli_query($conn2, $sql2);

        //check whether the query executed successfully or not
        if($res2==true)
        {
            //query executed  and inserted successfully
            $_SESSION['add'] ="Task Added Successfully.";
            header('location:'.SITEURL);

            //Redirect to Homepage
        
        }
        else
        {
         
            //FAILED TO ADD TASK
            $_SESSION['add_fail'] = "Failed to Add task";

            header('location:'.SITEURL.'add-task.php');
        }
    }
    ?>
