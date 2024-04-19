<?php 
    session_start(); 
    include "../db_conn.php";

    if (isset($_GET['deleteid'])){
        $uname=$_SESSION['user_name'];
        $id=$_GET['deleteid'];

        $sql="DELETE from $uname where id='$id'";
        $result=mysqli_query($conn, $sql);

        $sql1="DELETE from allfilms where user='$uname' AND film_id='$id'";
        $result1=mysqli_query($conn, $sql1);

        if ($result) {
            header("Location: ../catalog.php?success=Filmas ištrintas!");
            exit();
        } else {
            header("Location: ../catalog.php?error=Pasitaikė nežinoma klaida");
            exit();
        }
    }