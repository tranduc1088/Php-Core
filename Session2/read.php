<?php
    //Kiểm tra get ID
    if(isset($_GET["id"]) && !empty(trim($_GET["id"])))
    {
        //Chưa file config kết nối db
        require_once 'config.php';

        //thực hiện truy vấn select đến đối tượng
        $sql="select * from  employees where id = ?";

        if($stmt=mysqli_prepare($link, $sql))
        {
            //Truyền tham số
            mysqli_stmt_bind_param($stmt,"i",$param_id);

            //Set parameters
            $param_id=trim($_GET["id"]);
            
            //Attempt to excute the prepared statement
            if(mysqli_stmt_execute($stmt))
            {
                $result=mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result)==1)
                {
                    /*
                    Fetch result row as an associative array. Since the result set contains only one row, we don't
                    need to use while loop
                    */
                    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

                    //Retrieve individual field value
                    $name=$row["name"];
                    $address=$row["address"];
                    $salary=$row["salary"];
                }
                else
                {
                    //Url doesn't contain valid id parameter. Redirect to error page
                    header("location: error.php");
                    exit();
                }
            }
            else
            {
                echo "Oop! Something  went wrong. Please try again later.";
            }
        }
        //Close statement
        mysqli_stmt_close($stmt);
        //Close connection
        mysqli_close($link);
    }
    else
    {
        //Url doesn't contain id parameter. Redirect to error page
        
        header("location: error.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <title>View Record</title>
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
                        <h1>View Record</h1>
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <p class="form-control-static"><?php echo $row["name"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <p class="form-control-static"><?php echo $row["address"]; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Salary</label>
                        <p class="form-control-static"><?php echo number_format($row["salary"]); ?></p>
                    </div>
                    <p><a href="index.php" class="btn btn-primary">Back</a></p>
                 </div>
            </div>
        </div>
        
    </div>
</body>
</html>