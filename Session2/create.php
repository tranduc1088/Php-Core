<?php
//Include config file
require_once 'config.php';

//Define variable and initialize with empty values
$name = $address = $salary = "";
$name_err=$address_err=$salary_err="";

//Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    //Validate name
    $input_name=trim($_POST["name"]);
    if(empty($input_name))
    {
        $name_err="Please enter a name.";
    }
    else
    {
        $name=$input_name;
    }

    //Validate address
    $input_address=trim($_POST["address"]);
    if(empty($input_address))
    {
        $address_err="Please enter an address.";
    }
    else
    {
        $address=$input_address;
    }

    //Validate salary
    $input_salary=trim($_POST["salary"]);
    if(empty($input_salary))
    {
        $salary_err="Please enter the salary amout.";
    }elseif(!ctype_digit($input_salary))
    {
        $salary_err='Please enter a positive integer value.';
    }else
    {
        $salary=$input_salary;
    }
    //Check input errors before inserting in database
    if(empty($name_err)&& empty($address_err)&& empty($salary_err))
    {
        //Prepare an insert statement
        $sql="insert into employees (name,address,salary) values(?,?,?)";
        if($stmt=mysqli_prepare($link, $sql))
        {
            //Bind variables to the preapared statement as parameters
            mysqli_stmt_bind_param($stmt,"ssd",$param_name,$param_address,$param_salary);
            //Set parameters
            $param_name=$name;
            $param_address=$address;
            $param_salary=$salary;
            //Attempt to execute the prepared satement
            if(mysqli_stmt_execute($stmt))
            {
                //records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            }
            else
            {
                echo "Something went wrong. Please try again later.";
            }
        }
        //close statement
        mysqli_stmt_close($stmt);
    }
    //Close connection
    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Create Record</h2>
                    </div>
                    <p>Please fill this form and submit to add employees record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <div class="form-group <?php echo (!empty($name_err))? 'has-error':'';?>">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name;?>">
                            <span class="help-block"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($address_err))? 'has-error':'';?>">
                            <label>Address</label>
                            <textarea name="address" class="form-control"><?php echo $address?></textarea>
                            <span class="help-block"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($salary_err))? 'has-error':'';?>">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control" value="<?php echo $salary;?>">
                            <span class="help-block"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>