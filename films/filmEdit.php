<?php 
    session_start();
    include "../db_conn.php";

    $id = $_GET['editid'];
    $uname = $_SESSION['user_name'];

    $sql = "SELECT * from $uname where id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $title = $row['title'];
    $type = $row['watch'];
    $score = $row['score'];
    $img = $row['img'];

    if (isset($_POST['edit_title']) && isset($_POST['edit_type']) && isset($_POST['edit_score']) && isset($_FILES['edit_image'])){
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $title = validate($_POST['edit_title']);
        $type = validate($_POST['edit_type']);
        $score = validate($_POST['edit_score']);

        $img_name = $_FILES['edit_image']['name'];
        $img_size = $_FILES['edit_image']['size'];
        $tmp_name = $_FILES['edit_image']['tmp_name'];
        $img_error = $_FILES['edit_image']['error'];

        if (empty($title)) {
            header("Location: filmEdit.php?error=Reikalingas filmo pavadinimas&editid=".$id."");
            exit();
        } else if ($type == "-") {
            header("Location: filmEdit.php?error=Reikalingas filmo tipas&editid=".$id."");
            exit();
        } else if ($img_error !== UPLOAD_ERR_OK) {
            header("Location: filmEdit.php?error=Failo įkėlimo klaida. Bandykite dar kartą&editid=".$id."");
            exit();
        } else if ($img_size > 125000) {
            header("Location: filmEdit.php?error=Failo dydis yra per didelis (< 125 KB)&editid=".$id."");
            exit();
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);
            $allowed_exs = array('jpg', 'jpeg', 'png', 'webp', 'avif');

            if (!in_array($img_ex_lc, $allowed_exs)) {
                header("Location: filmEdit.php?error=Failo tipas yra netinkamas (tinkami: jpg, jpeg, png, webp, avif)&editid=".$id."");
                exit();
            }
            
            $new_img_name = uniqid("IMG-", true).'.'.$img_ex_lc;
            $img_upload_folder = "../images/".$uname."_images";

            if (file_exists("../images/".$uname."_images/".$new_img_name)) {
                unlink("../images/".$uname."_images/".$new_img_name);
            }

            move_uploaded_file($tmp_name, $img_upload_folder.'/'.$new_img_name);

            $sql = "UPDATE $uname set id='$id',title='$title',watch='$type',score='$score',img='$new_img_name' where id='$id'";
            $result = mysqli_query($conn, $sql);

            $sql1 = "UPDATE allfilms set title='$title',watch='$type',score='$score',img='$new_img_name' where user='$uname' and film_id='$id'";
            $result1 = mysqli_query($conn, $sql1);

            if ($result) {
                header("Location: ../catalog.php?success=Filmas redaguotas!");
                exit();
            } else {
                header("Location: ../catalog.php?error=Pasitaikė nežinoma klaida");
                exit();
            }
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Filmų Katalogas</title>
        <link rel="stylesheet" type="text/css" href="../style.css">
        <link rel="icon" href="../images/icon.png" type="image/x-icon">
    </head>
    <body class="body_catalog">
        <div class='edit_film'>

            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>

            <h2>Redaguoti filmą</h2>
            <form method='post' enctype='multipart/form-data'>
                <label>Filmo pavadinimas</label>
                <input class='input_title' type='text' name='edit_title' value="<?php echo $title?>"><br>
                <label style='margin-left: 25px'>Filmo tipas</label><label style="margin-left: 20px">Filmo įvertinimas</label><br>
                <select class='edit_filmtype' name='edit_type' id='film_type'>
                    <option value='-'>-</option>
                    <option value='Matytas' <?php if ($type=='Matytas') {echo 'selected';} ?>>Matytas</option>
                    <option value='Nematytas' <?php if ($type=='Nematytas') {echo 'selected';} ?>>Nematytas</option></select>
                <input class='input_nr' type='number' name='edit_score' min='0' max='10' value="<?php echo $score?>"><br>
                <label>Filmo nuotrauka</label><br>
                <input class='input_image' type='file' name='edit_image'><br>
                <button class='edit_submit' type='submit' name='edit_submit'>Patvirtinti</button>
                <button class='edit_cancel'><a style='color: white; text-decoration: none;' href='../catalog.php?success=Filmo redagavimas atšauktas'>Atšaukti</a></button>
            </form>
        </div>
    </body>
</html>