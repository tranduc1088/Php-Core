<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style type="text/css">
        .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{
            margin-right: 15px;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix"></div>
                    <h2 class="pull-left">Employees Details</h2>
                    <a href="create.php" class="btn btn-success pull-right">Add New Employee</a>
                </div>
                <?php
                //Include config file
                require_once 'config.php';
                //Attempt select query execution
                $sql="select * from employees";
                if($result=mysqli_query($link,$sql))
                {
                    if(mysqli_num_rows($result)>0)
                    {
                        echo "<table class='table table-bordered table-striped'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>#</th>";
                                    echo "<th>Name</th>";
                                    echo "<th>Address</th>";
                                    echo "<th>Salary</th>";
                                    echo "<th>Action</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row=mysqli_fetch_array($result))
                            {
                                echo "<tr>";
                                    echo "<td>" .$row['id']. "</td>";
                                    echo "<td>" .$row['name']. "</td>";
                                    echo "<td>" .$row['address']. "</td>";
                                    echo "<td>" .number_format($row['salary']). "</td>";
                                    echo "<td>";
                                        echo "<a href='read.php?id=". $row['id'] . "' title='View Record' data-toggle='tooltip'>
                                        <span class='glyphicon glyphicon-eye-open'></span></a>";

                                        echo "<a href='update.php?id=". $row['id'] . "' title='Update Record' data-toggle='tooltip'>
                                        <span class='glyphicon glyphicon-pencil'></span></a>";

                                        echo "<a href='delete.php?id=". $row['id'] . "' title='Delete Record' data-toggle='tooltip'>
                                        <span class='glyphicon glyphicon-trash'></span></a>";
                                    echo "</td>";
                                echo "</tr>";

                            }
                            echo "</tbody>";
                        echo "</table>";
                        // free result set
                        mysqli_free_result($result);
                    }
                    else
                    {
                        echo "<p class='lead'><en>No records were found</en></p>";
                    }
                }
                else
                {
                    echo "Error: Could not able to execute $sql.". mysqli_error($link);
                }
                //close connection
                mysqli_close($link);
                ?>
            </div>
        </div>
    </div>
</body>
</html>