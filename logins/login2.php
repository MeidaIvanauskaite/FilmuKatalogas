<?php 
    session_start(); 
    include "../db_conn.php";

    if (isset($_POST['username']) && isset($_POST['password'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $uname = validate($_POST['username']);
        $pass = validate($_POST['password']);

        if (empty($uname)) {
            header("Location: login.php?error=Reikalingas naudotojo vardas");
            exit();
        } else if (empty($pass)) {
            header("Location: login.php?error=Reikalingas slaptažodis");
            exit();
        } else {
            $pass = md5($pass);
            $sql = "SELECT * FROM users WHERE user_name='$uname' AND password='$pass'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) === 1) {
                $row = mysqli_fetch_assoc($result);
                if ($row['user_name'] === $uname && $row['password'] === $pass) {
                    $_SESSION['user_name'] = $row['user_name'];
                    $_SESSION['id'] = $row['id'];
                    if ($_SESSION['user_name'] == 'AllFilms') {
                        header("Location: ../catalogAll.php");
                    } else {
                        header("Location: ../catalog.php");
                    }
                    exit();
                } else {
                    header("Location: login.php?error=Neteisingas naudotojo vardas arba slaptažodis");
                    exit();
                }
            } else {
                header("Location: login.php?error=Neteisingas naudotojo vardas arba slaptažodis");
                exit();
            }
        }
        
    } else {
        header("Location: login.php");
        exit();
    }