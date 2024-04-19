<?php 
    session_start();
    include "db_conn.php";
    if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Visų Filmų Katalogas</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" href="./images/icon.png" type="image/x-icon">
    </head>
    <body class="body_catalog">
        <div class="catalog_main" id="catalog_main_insert">
            <p class="catalog_title">Visų filmų katalogas</p>

            <form action="" method="GET" class="form_sort_films">
                <select name='sort_films' class='select_sort_films'>
                    <option selected></option>
                    <option value='a-z' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 'a-z') {echo 'selected';}?>>Abecėlės tvarka (A-Ž)</option>
                    <option value='z-a' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 'z-a') {echo 'selected';}?>>Abecėlės tvarka (Ž-A)</option>
                    <option value='u-r' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 'u-r') {echo 'selected';}?>>Naudotojų tvarka (A-Ž)</option>
                    <option value='r-u' <?php if (isset($_GET['sort_films']) && $_GET['sort_films'] == 'r-u') {echo 'selected';}?>>Naudotojų tvarka (Ž-A)</option>
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
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname ORDER BY title ASC";
                    } else if ($_GET['sort_films'] == 'z-a') {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname ORDER BY title DESC";
                    } else if ($_GET['sort_films'] == 'u-r') {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname ORDER BY user ASC";
                    } else if ($_GET['sort_films'] == 'r-u') {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname ORDER BY user DESC";
                    } else if ($_GET['sort_films'] == 'y-n') {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname ORDER BY watch ASC";
                    } else if ($_GET['sort_films'] == 'n-y') {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname ORDER BY watch DESC";
                    } else if ($_GET['sort_films'] == 't-z') {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname ORDER BY score DESC";
                    } else if ($_GET['sort_films'] == 'z-t') {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname ORDER BY score ASC";
                    } else {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname";
                    }
                } else if (isset($_GET['filter_films'])) {
                    if ($_GET['filter_films'] == 'm-n') {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname WHERE watch = 'Matytas'";
                    } else if ($_GET['filter_films'] == 'n-m') {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname WHERE watch = 'Nematytas'";
                    } else {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname";
                    }
                } else if (isset($_GET['search_films'])) {
                    if ($_GET['search_films'] != null) {
                        $getTitle = $_GET['search_films'];
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname WHERE title = '$getTitle'";
                    } else {
                        $sql1 = "SELECT id, user, title, watch, score, img FROM $uname";
                    }
                } else {
                    $sql1 = "SELECT id, user, title, watch, score, img FROM $uname";
                }

                $result1 = $conn->query($sql1);
                if ($result1->num_rows > 0) {
                    $nr_count = 0;
                    while($row1 = $result1->fetch_assoc()) {
                        $id = $row1["id"];
                        $user = $row1["user"];
                        $title = $row1["title"];
                        $watch = $row1["watch"];
                        $score = $row1["score"];
                        $img = $row1["img"];
                        $nr_count++;
                        echo "<div class='film_from_db' id='film_".$id."'>
                        <p style='font-weight: bold; font-size: 30px; margin-top: 10px; margin-bottom: 30px'>".$nr_count.": ".$title."</p>
                        <p style='margin-top: 10px; margin-bottom: 25px;'><b>Naudotojas: </b>".$user."</p>
                        <p style='margin-top: 10px; margin-bottom:25px'><b>Tipas:</b> ".$watch."</p><p><b>Įvertinimas:</b> ".$score."/10</p>
                        <img class='film_image' src='./images/".$user."_images/".$img."'></div><br>";
                    }
                } else if (isset($_GET['search_films']) && $_GET['search_films'] != null){
                    echo "<p style='margin-bottom:5px; font-size: 20px'><b>Rasti filmai:</b> 0</p>";
                } else {
                    echo "<p style='margin-bottom:5px; font-size: 20px'><b>Visi išsaugoti filmai:</b> 0</p><br>
                    <p style='margin-top: 5px; font-size: 18px'>Naudotojai dar nepradėjo žymėtis savo filmų</p>";
                }
            ?>
        </div>

        <h1 class="username"><?php echo $_SESSION['user_name']; ?></h1>
        <a class="a_logout" href="./logins/logout.php">Atsijungti</a>
    </body>
</html>

<?php 
    } else {
        header("Location: index.php");
        exit();
    }
?>