<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form name="WDsample.php" method="POST" enctype="multipart/form-data">
    <table cellpadding="5" cellspacing="3" align="center">
    <tr>
        <td>Employee ID:</td>
        <td><input type="text" name="empID" maxlength="4" placeholder="####"></td>
    </tr>

    <tr>
        <td>Employee Name:</td>
        <td><input type="text" name="empName" maxlength="20" placeholder="Juan Dela Cruz"></td>
    </tr>

    <tr>
        <td>Employee Salary:</td>
        <td><input type="text" name="empSalary" maxlength="100" placeholder="######"></td>
    </tr>
    </table>

    <center>
        <input type="submit" name="insertSub" value="INSERT" >
        <input type="submit" name="deleteSub" value="DELETE" >
        <input type="submit" name="updateSub" value="UPDATE" >
        <input type="submit" name="viewSub" value="VIEW" >
        <input type="submit" name="searchSub" value="SEARCH" ><br><br>
        <label>File Name </label>
        <input type="text" name="title" placeholder="Input Document Name">
        <input type="file" name="file" value="upload"><br><br>
        <input type="submit" name="importSub" value="IMPORT FILE" >
    </center>
    </form>
    
    <?php
    $DBHost = "localhost"; 
    $DBUser = "root"; 
    $DBPass = ""; 
    $DBName = "db_employee"; 

    $conn = mysqli_connect($DBHost, $DBUser, $DBPass, $DBName);
    if(isset($_POST['insertSub'])!=''){
        $errZip = "";
    $sql = "INSERT into tbl_employee (`emp_ID`,`emp_name`,`emp_Salary`) values ('$_POST[empID]','$_POST[empName]','$_POST[empSalary]')";
    $result = mysqli_query($conn,$sql);
    echo "<br>Record Added";
    }

    if(isset($_POST['deleteSub'])!=''){
    $sql = "DELETE from tbl_employee WHERE `emp_ID`='$_POST[empID]'";
    $result = mysqli_query($conn,$sql);
    echo "<br>Record Deleted";
    }

    if(isset($_POST['updateSub'])!=''){

        if($_POST['empID']=="" && $_POST['empSalary']==""){

        }else{
        $sql = "UPDATE tbl_employee SET `emp_Salary`='$_POST[empSalary]' WHERE
        `emp_ID`='$_POST[empID]'";
        $result = mysqli_query($conn,$sql);
        echo "<br>Record Updated";
        }
        }
    if(isset($_POST['viewSub'])!=''){
        echo "<center>";
        $sql = "Select * from tbl_employee";
        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0 ){
            echo "<table border = 3>" . "<th> Employee ID </th> <th>Employee Name </th> <th> Employee Salary </th>";
            while($rows=mysqli_fetch_assoc($result)){
                echo"
                <tr>
                <td>".$rows["emp_ID"]."</td>
                <td>".$rows["emp_Name"]."</td>
                <td>".$rows["emp_Salary"]."</td>
                </tr>";
            }
            echo"</table>";
        }
        if($result){
            echo"<br>Record Viewed";
        }
        echo "</center>";
    }
   
    if(isset($_POST['searchSub'])!=''){
            if($_POST['empName']==""){ 
            echo "Fill Employee Name field you want to search.";
            }else{        
            if(preg_match("/[A-Z | a-z]+/", $_POST['empName'])){
            $empname = $_POST['empName'];
            $sql = "SELECT `emp_ID`, `emp_Name`, `emp_Salary` FROM tbl_employee WHERE
            `emp_name` LIKE '%". $empname ."%'";
            $result = mysqli_query($conn,$sql);
            
            echo "<table align = center border=1 cellspacing=3 cellpadding=5 >";
            echo "<th>Employee ID</th><th>Employee Name</th><th>Employee Salary</th>";
            
            while($row = mysqli_fetch_assoc($result)){
            $empid_ = $row["emp_ID"];
            $empname_ = $row["emp_Name"];
            $empsalary_ = $row["emp_Salary"];
            echo "
            <tr>
<td>" . $empid_ ." </td>
<td> ". $empname_ ."</td>
<td> ". $empsalary_ . "</td>
</tr>";
}
echo "</table>";
}
echo "Record Searched";
}
}
    if(isset($_POST["importSub"])){
        $title = $_POST["title"];
        $pname = rand(1000, 10000)."-".$_FILES["file"]["name"];
        $tname = $_FILES["file"]["tmp_name"];
        $uploads_dir = 'uploads';

    move_uploaded_file($tname, $uploads_dir.'/'.$pname);

    $sql = "INSERT into tbl_employee (`emp_ID`, `emp_Name`, `emp_Salary`, `title`, `image`) values
     ('$_POST[empID]', '$_POST[empName]', '$_POST[empSalary]', '$title', '$pname')";
    
    if(mysqli_query($conn,$sql)){

        echo"<center>";
        echo"<br><b>RECORD</b></br>";
        echo"File successfully uploaded";
        echo"</center>";
     }
    
     else{
        echo"error";
     }
     }

    ?>
</body>
</html>