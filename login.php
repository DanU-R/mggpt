<?php
session_start();
if (isset($_SESSION['logged_user_id'])) {
    header('Location: home.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") :
    require_once __DIR__ . "/db_connection.php";
    require_once __DIR__ . "/on_login.php";
    if (isset($conn) && isset($_POST["email"]) && isset($_POST["password"])) {
        $result = on_login($conn);
    }
endif;

function post_value($field)
{
    if (isset($_POST[$field])) {
        echo '' . trim(htmlspecialchars($_POST[$field])) . '';
        return;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css_login.css">
</head>
<body>
<section class="container">
            <div class="login-container">
                <div class="circle circle-one"></div>
                <div class="form-container">
                    <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
                    <h1 class="opacity">LOGIN</h1>
                    <form action="" method="POST">
                        <input type="text" class="input" name="ID" id="user_ID" placeholder="ID" <?php post_value("ID"); ?>-attr-name><?php post_value(""); ?> 
                        <input type="password" placeholder="PASSWORD" class="input" name="password" id="user_pass"<?php post_value("password"); ?>-attr-name><?php post_value(""); ?> 
                        <button class="opacity">SUBMIT</button>
                    </form>
                    <div class="register-forget opacity">
                    <a href="register.php">REGISTER</a>
                        <a href="">FORGOT PASSWORD</a>
                    </div>
                </div>
                <div class="circle circle-two"></div>
            </div>
            <div class="theme-btn-container"></div>
        </section>
        <script src="login.js"></script>

        <?php
    // JS code to show errors
    if (isset($result["field_error"])) { ?>
    <script>
        let field_error = <?php echo json_encode($result["field_error"]); ?>;
        let el = null;
        let msg_el = null;
        for (let i in field_error) {
            el = document.querySelector(`input[ID="${i}"]`);
            el.classList.add("error");
            msg_el = document.querySelector(`label[for="${el.getAttribute("id")}"] span`);
            msg_el.innerText = field_error[i];
        }
    </script>
    <?php } ?>
</body>
</html>