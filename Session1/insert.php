<html>
    <head>Add new | BookStore</head>
</html>
<body>
    <?php
    $bookId=0;
    $authorId=0;
    $title="";
    $isbn="";
    $pub_year=1999;
    $available=1;
    if(!empty($_POST['bookId']))
    {
        $bookId=$_POST['bookId'];
    }

    if(!empty($_POST['authorId']))
    {
        $authorId=$_POST['authorId'];
    }

    if(!empty($_POST['title'])){
        $title=$_POST['title'];
    }

    if(!empty($_POST['isbn']))
    {
        $isbn=$_POST['isbn'];
    }

    if(!empty($_POST['pub_year']))
    {
        $pub_year=$_POST['pub_year'];
    }

    if(!empty($_POST['available']))
    {
        $available=$_POST['available'];
    }
    
    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        BookID: <input type="text" name="bookid"/>
        AuthorID: <input type="text" name="authorid"/>
        Title: <input type="text" name="title"/>
        ISBN: <input type="text" name="isbn"/>
        Public Year: <input type="text" name="pub_year"/>
        Available: <input type="text" name="available"/>
                <input type="submit" value="Add Book">
    </form>

    <?php
    $myDB=new mysqli('localhost','root','','library');
    //khai báo chuỗi kết nối
    if($myDB->connect_error)
    {
        die('Connect Error('.$myDB->connect_erro.')'.$myDB->connect_error);
    }
    
    if($title !='' && $isbn !='')
    {
        $insert="insert into books (bookid,authorid,title,isbn,pub_year,available) values
        ($bookId,$authorId,'$title','$isbn',$pub_year,$available)";
        echo $insert;
        $myDB->query($insert);
        echo "New record created successfully";
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
        echo $row["title"];
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
</html>