<?php 
    session_start();
    include "db_conn.php";
    if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Filmų Katalogas</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="./images/icon.png" type="image/x-icon">
    </head>
    <body class="body_catalog">
        <div class="catalog_main" id="catalog_main_insert">
            <p class="catalog_title">Jūsų filmų katalogas</p>

            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php ; add_film(); } ?>

            <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?> </p>
            <?php } ?>

            <?php 
                if (array_key_exists('add_film', $_POST)) { 
                    add_film(); 
                }
            ?>

            <form action="" method="GET" class="form_sort_films">
                <select name='sort_films' class='select_sort_films'>
                    <option selected></option>
                    <option value='a-z' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 'a-z') {echo 'selected';}?>>Abecėlės tvarka (A-Ž)</option>
                    <option value='z-a' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 'z-a') {echo 'selected';}?>>Abecėlės tvarka (Ž-A)</option>
                    <option value='y-n' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 'y-n') {echo 'selected';}?>>Žiūrėjimo tvarka (Matyti-Nematyti)</option>
                    <option value='n-y' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 'n-y') {echo 'selected';}?>>Žiūrėjimo tvarka (Nematyti-Matyti)</option>
                    <option value='t-z' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 't-z') {echo 'selected';}?>>Įvertinimo tvarka (10-0)</option>
                    <option value='z-t' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 'z-t') {echo 'selected';}?>>Įvertinimo tvarka (0-10)</option>
                </select>
                <button type="submit" class="button_sort_films">Rūšiuoti</button>
            </form>

            <form action="" method="GET" class="form_filter_films">
                <select name='filter_films' class='select_filter_films'>
                    <option selected></option>
                    <option value='m-n' <?php if (isset($_GET['filter_films']) && $_GET['filter_films'] == 'm-n') {echo 'selected';}?>>MATYTI Filmai</option>
                    <option value='n-m' <?php if (isset($_GET['filter_films']) && $_GET['filter_films'] == 'n-m') {echo 'selected';}?>>NEMATYTI Filmai</option>
                </select>
                <button type="submit" class="button_filter_films">Filtruoti</button>
            </form><br><br>

            <form action="" method="GET" class="form_search_films">
                <input name='search_films' class='input_search_films'>
                <button type="submit" class="button_search_films">Ieškoti</button>
            </form><br><br>

            <?php 
                $uname = $_SESSION['user_name'];
                if (isset($_GET['sort_films'])) {
                    if ($_GET['sort_films'] == 'a-z') {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname ORDER BY title ASC";
                    } else if ($_GET['sort_films'] == 'z-a') {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname ORDER BY title DESC";
                    } else if ($_GET['sort_films'] == 'y-n') {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname ORDER BY watch ASC";
                    } else if ($_GET['sort_films'] == 'n-y') {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname ORDER BY watch DESC";
                    } else if ($_GET['sort_films'] == 't-z') {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname ORDER BY score DESC";
                    } else if ($_GET['sort_films'] == 'z-t') {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname ORDER BY score ASC";
                    } else {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname";
                    }
                } else if (isset($_GET['filter_films'])) {
                    if ($_GET['filter_films'] == 'm-n') {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname WHERE watch = 'Matytas'";
                    } else if ($_GET['filter_films'] == 'n-m') {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname WHERE watch = 'Nematytas'";
                    } else {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname";
                    }
                } else if (isset($_GET['search_films'])) {
                    if ($_GET['search_films'] != null) {
                        $getTitle = $_GET['search_films'];
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname WHERE title = '$getTitle'";
                    } else {
                        $sql1 = "SELECT id, title, watch, score, img FROM $uname";
                    }
                } else {
                    $sql1 = "SELECT id, title, watch, score, img FROM $uname";
                }

                $result1 = $conn->query($sql1);
                if ($result1->num_rows > 0) {
                    $nr_count = 0;
                    while($row1 = $result1->fetch_assoc()) {
                        $id = $row1["id"];
                        $title = $row1["title"];
                        $watch = $row1["watch"];
                        $score = $row1["score"];
                        $img = $row1["img"];
                        $nr_count++;
                        echo "<div class='film_from_db' id='film_".$id."'>
                        <button class='button_edit'><a class='a_edit' href='./films/filmEdit.php?editid=".$id."'>Redaguoti</a></button>
                        <button class='button_delete'><a class='a_delete' href='./films/filmDelete.php?deleteid=".$id."'>Ištrinti</a></button>
                        <p style='font-weight: bold; font-size: 30px; margin-top: 10px; margin-bottom: 40px'>".$nr_count.": ".$title."</p>
                        <p style='margin-bottom:35px'><b>Tipas:</b> ".$watch."</p><p><b>Įvertinimas:</b> ".$score."/10</p>
                        <img class='film_image' src='./images/".$uname."_images/".$img."'></div><br>";
                    }
                } else if (isset($_GET['search_films']) && $_GET['search_films'] != null){
                    echo "<p style='margin-bottom:5px; font-size: 20px'><b>Rasti filmai:</b> 0</p>";
                } else {
                    echo "<p style='margin-bottom:5px; font-size: 20px'><b>Jūsų išsaugoti filmai:</b> 0</p><br>
                    <p style='margin-top: 5px; font-size: 18px'>Pradėkite žymėtis savo filmus paspausdami <b>žalią mygtuką</b> apačioje dešinėje</p>";
                }
            ?>
        </div>

        <h1 class="username"><?php echo $_SESSION['user_name']; ?></h1>
        <a class="a_logout" href="./logins/logout.php">Atsijungti</a>
        <form method="post">
            <input type="submit" class="input_addfilm" name="add_film" value="+">
        </form>
    </body>
</html>

<?php 
    } else {
        header("Location: index.php");
        exit();
    }

    function add_film() { echo 
        "<div class='add_film'>
            <h2>Pridėti filmą</h2>
            <form action='./films/filmAdd.php' method='post' enctype='multipart/form-data'>
                <label>Filmo pavadinimas</label>
                <input class='input_title' type='text' name='add_title' placeholder='Filmo pavadinimas'><br>
                <label style='margin-left: 25px'>Filmo tipas</label><label style='margin-left: 20px'>Filmo įvertinimas</label><br>
                <select class='add_filmtype' name='add_type' id='film_type'>
                    <option>-</option>
                    <option value='Matytas'>Matytas</option>
                    <option value='Nematytas'>Nematytas</option></select>
                <input class='input_nr' type='number' name='add_score' min='0' max='10'><br>
                <label>Filmo nuotrauka</label><br>
                <input class='input_image' type='file' name='add_image'><br>
                <button class='add_submit' type='submit'>Pridėti</button>
                <button class='add_cancel'><a style='color: white; text-decoration: none;' href='catalog.php?success=Filmo pridėjimas atšauktas'>Atšaukti</a></button>
            </form>
        </div>";
    }
?>