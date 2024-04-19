<?php
    session_start(); 
    include "../db_conn.php";

    if (isset($_POST['add_title']) && isset($_POST['add_type']) && isset($_POST['add_score']) && isset($_FILES['add_image'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $uname = $_SESSION['user_name'];
        $title = validate($_POST['add_title']);
        $type = validate($_POST['add_type']);
        $score = validate($_POST['add_score']);

        $img_name = $_FILES['add_image']['name'];
        $img_size = $_FILES['add_image']['size'];
        $tmp_name = $_FILES['add_image']['tmp_name'];
        $img_error = $_FILES['add_image']['error'];

        if (empty($title)) {
            header("Location: ../catalog.php?error=Reikalingas filmo pavadinimas");
            exit();
        } else if ($type == "-" || empty($type)) {
            header("Location: ../catalog.php?error=Reikalingas filmo tipas");
            exit();
        } else if ($img_error !== UPLOAD_ERR_OK) {
            header("Location: ../catalog.php?error=Failo įkėlimo klaida. Bandykite dar kartą");
            exit();
        } else if ($img_size > 125000) {
            header("Location: ../catalog.php?error=Failo dydis yra per didelis (< 125 KB)");
            exit();
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array('jpg', 'jpeg', 'png', 'webp', 'avif');

            if (!in_array($img_ex_lc, $allowed_exs)) {
                header("Location: ../catalog.php?error=Failo tipas yra netinkamas (tinkami: jpg, jpeg, png, webp, avif)");
                exit();
            } else if (!file_exists("../images/".$uname."_images")) {
                mkdir("../images/".$uname."_images");
            }
            
            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
            $img_upload_folder = "../images/".$uname."_images";
            move_uploaded_file($tmp_name, $img_upload_folder.'/'.$new_img_name);

            $sql = "SELECT * FROM $uname WHERE title='$title'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                header("Location: ../catalog.php?error=Filmo pavadinimas yra pakartotas. Įveskite kitokį pavadinimą");
                exit();
            } else {
                $sql2 = "INSERT INTO $uname(title, watch, score, img) VALUES('$title', '$type', '$score', '$new_img_name')";
                $result2 = mysqli_query($conn, $sql2);

                $sql22 = "SELECT * FROM $uname WHERE title='$title'";
                $result22 = mysqli_query($conn, $sql22);
                $row = mysqli_fetch_assoc($result22);
                $film_id = $row['id'];

                $sql3 = "INSERT INTO allfilms(user, film_id, title, watch, score, img) VALUES('$uname', '$film_id', '$title', '$type', '$score', '$new_img_name')";
                $result3 = mysqli_query($conn, $sql3);
                
                if ($result2) {
                    header("Location: ../catalog.php?success=Filmas pridėtas!");
                    exit();
                } else {
                    header("Location: ../catalog.php?error=Pasitaikė nežinoma klaida");
                    exit();
                }
            }
        }
    } else {
        header("Location: ../catalog.php?error=Pasitaikė nežinoma klaida");
        exit();
    }   