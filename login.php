<?php session_start(); ?>
<?php require_once("includes/connection.php"); ?>

<?php
if (isset($_SESSION["session_username"])) {
    $username = '';
    $username = $_SESSION['session_username'];
    $q_base = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
    $tag = mysqli_fetch_assoc($q_base)['tag'];

    if ($tag == 'c') {
        header("Location: client/client.php");

    } elseif ($tag == 'o') {
        header("Location: operator/operator.php");
    }

}

$message = '';
$dbusername = '';
$dbpassword = '';
$tag = '';


if (isset($_POST["login"])) {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        $query = mysqli_query($link, "SELECT * FROM users WHERE username = '" . $username . "'");
        $numrows = mysqli_num_rows($query);

        if ($numrows != 0) {
            $row = mysqli_fetch_assoc($query);
            $dbusername = $row['username'];
            $dbpassword = $row['password'];
            $tag = $row['tag'];

            if ($username == $dbusername && password_verify($password, $dbpassword)) {
                $_SESSION['session_username'] = $username;

                if ($tag == 'c') {
                    header("Location: client/client.php");
                    exit();

                } else if ($tag == 'o') {
                    header("Location: operator/operator.php");
                    exit();
                }

            } else {
                $message = '<span class = "bad">Неверный пароль</span></br>';
            }


        } else {
            $message = '<span class = "bad">Неверное имя пользователя</span></br>';

        }
    } else {
        $message = '<span class = "bad">Все поля обязательны для заполнения!</span></br>';
    }
}
?>


<?php include("includes/header.php"); ?>
    <body>
    <div class="container mlogin">
        <div id="login">
            <h1>Вход</h1>
            <?php echo $message; ?>
            <form action="" id="loginform" method="post" name="loginform">
                <p><label for="user_login">Логин<br>
                        <input class="input" id="username" name="username" size="20" type="text" value=""></label></p>
                <p><label for="user_pass">Пароль<br>
                        <input class="input" id="password" name="password" size="20" type="password" value=""></label></p>
                <p class="submit"><input class="button" name="login" type="submit" value="Вход"></p>
                <p class="regtext">Еще не зарегистрированы? <br><a href="register.php">Регистрация!</a></p>
                <p class="regtext">Вы что, забыли пароль? <br><a href="restore.php">Восстановить пароль!</a></p>
            </form>
        </div>
    </div>
    </body>
<?php include("includes/footer.php"); ?>