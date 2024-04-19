<?php 
    session_start(); 
    include "../db_conn.php";

    if (isset($_POST['username']) && isset($_POST['password1']) && isset($_POST['password2'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $uname = validate($_POST['username']);
        $pass = validate($_POST['password1']);
        $pass2 = validate($_POST['password2']);
        $user_data = 'uname='. $uname;

        if (empty($uname)) {
            header("Location: register.php?error=Reikalingas naudotojo vardas&$user_data");
            exit();
        } else if (empty($pass)) {
            header("Location: register.php?error=Reikalingas slaptažodis&$user_data");
            exit();
        } else if (empty($pass2)) {
            header("Location: register.php?error=Reikalingas pakartotas slaptažodis&$user_data");
            exit();
        } else if ($pass !== $pass2) {
            header("Location: register.php?error=Slaptažodis ir pakartotas slaptažodis nesutampa&$user_data");
            exit();
        } else {
            $pass = md5($pass);
            $sql = "SELECT * FROM users WHERE user_name='$uname' ";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                header("Location: register.php?error=Naudotojo vardas yra paimtas. Įveskite kitokį naudotojo vardą&$user_data");
                exit();
            } else {
                $sql2 = "INSERT INTO users(user_name, password) VALUES('$uname', '$pass')";
                $result2 = mysqli_query($conn, $sql2);

                $sql3 = "CREATE table $uname(id int(7) UNSIGNED AUTO_INCREMENT PRIMARY KEY, title varchar(60) NOT NULL, watch varchar(10) NOT NULL, score int(2), img varchar(100))";
                $result3 = mysqli_query($conn, $sql3);
                
                if ($result2) {
                    header("Location: ../logins/login.php?success=Anketa sukurta!");
                    exit();
                } else {
                    header("Location: register.php?error=Pasitaikė nežinoma klaida&$user_data");
                    exit();
                }
            }
        }
    } else {
        header("Location: register.php");
        exit();
    }   