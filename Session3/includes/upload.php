<?php
    if(isset($_POST['submit']))
    {
        $newFilename=$_POST['filename'];
        if(empty($newFilename))
        {
            $newFilename="gallery";
        }
        else
        {
            $newFilename=strtolower(str_replace(" ","-",$newFilename));
        }
        $imageTitle=$_POST['filetitle'];
        $imageDesc=$_POST['filedesc'];
        $file=$_FILES['file'];
        $fileName=$file["name"];
        $fileType=$file["type"];
        $fileTempName=$file["tmp_name"];
        $fileError=$file["error"];
        $fileSize=$file["size"];
        $fileExt=explode(".",$fileName);
        $fileActualExt=strtolower(end($fileExt));
        $allowed=array("jpg","jpeg","png");

        if(in_array($fileActualExt,$allowed))
        {
            if($fileError===0){
                //check File có kích thước nhỏ hơn 4mb
                if($fileSize<4000000)
                {
                    $imageFullName=$newFilename .".".uniqid("",true). ".".$fileActualExt;
                    $fileDescription ="../img/gallery/".$imageFullName;
                    include_once "config.php";
                    if(empty($imageTitle)||empty($imageDesc)){
                        header("location:../gallery.php?upload=empty");
                        exit();
                    }
                    else{
                        $sql="select * from gallery";
                        $stmt=mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            echo "SQL statement failed";
                        }else{
                            mysqli_stmt_execute($stmt);
                            $result=mysqli_stmt_get_result($stmt);
                            $rowCount=mysqli_num_rows($result);
                            $setImageOrder=$rowCount+1;

                            $sql="insert into gallery(titleGAllery,descGallery,imgFullNameGallery,orderGallery) values
                            (?,?,?,?)";
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                echo "SQL Statement failed";
                            }else {
                                mysqli_stmt_bind_param($stmt,"ssss",$imageTitle,$imageDesc,$imageFullName,$setImageOrder);
                                mysqli_stmt_execute($stmt);

                                move_uploaded_file($fileTempName,$fileDescription);
                                header("location: ../gallery.php?upload=success");
                            }
                        }
                    }
                }
                else{
                    echo "File size is too big";
                    exit();
                }
                
            }
            else{
                echo "You had an error";
                exit();
            }
            
        }
        else{
            echo "You need to upload a proper file type";
            exit();
        }
    }
?>