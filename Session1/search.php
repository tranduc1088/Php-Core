<HTML>
    <head>
        <title>Search | BookSotre</title>
    </head>
    <body>
        <?php
        $title='';
            if(!empty($_POST['title']))
            {
                $title=$_POST['title'];
                echo "Finding record, {$_POST['title']}, and result";
            }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            Enter your name: <input type="text" name="title"/>
            <input type="submit" value="Search"/>
        </form>
        <?php
            $myDB=new mysqli('localhost','root','','library');
            //khai báo chuỗi kết nối
            if($myDB->connect_error)
            {
                die('Connect Error('.$myDB->connect_erro.')'.$myDB->connect_error);
            }

            if($title !='')
            {
                $sql="select * from books where available = 1 and title like '%{$title}%'
                order by title";
            }
            else
            {
                $sql="select * from books where available = 1 order by title";
            }
            $result=$myDB->query($sql);
            ?>
            <table cellSpacing="2" cellPadding="6" align="center" border="1"> 
                <tr>
                    <td colspan="4">
                        <h3 align="center">These Books are curently available</h3>
                    </td>
                </tr>
                <tr>
                    <td align="center">Title</td>
                    <td align="center">Year Published</td>
                    <td align="center">ISBN</td>
                </tr>
            <?php
            while ($row =$result->fetch_assoc())
            {
                echo"<tr>";
                echo"<td>";
                echo stripcslashes($row["title"]);
                echo "</td><td align='center'>";
                echo $row["pub_year"];
                echo "</td><td>";
                echo $row["isbn"];
                echo "</td>";
                echo "</tr>";
            }
            ?>
            </table>
    </body>
</HTML>