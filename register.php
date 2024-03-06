<?php
session_start();
if(isset($_SESSION['logged_user_id'])){
    header('Location: home.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") :
    require_once __DIR__ . "/db_connection.php";
    require_once __DIR__."/on_register.php";
    if (
        isset($conn) &&
        isset($_POST["username"]) &&
        isset($_POST["password"])
        ) {
        $result = on_register($conn);
    }
endif;

// If the user is registered successfully, don't show the post values.
$show = isset($result["form_reset"]) ? true : false;

function post_value($field){
    global $show;
    if(isset($_POST[$field]) && !$show){
        echo ''.trim(htmlspecialchars($_POST[$field])).'';
        return;
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
    <link rel="stylesheet" href="css_login.css">
</head>
<body>
<section class="container">
            <div class="login-container">
                <div class="circle circle-one"></div>
                <div class="form-container">
                    <img src="https://raw.githubusercontent.com/hicodersofficial/glassmorphism-login-form/master/assets/illustration.png" alt="illustration" class="illustration" />
                    <h1 class="opacity">REGISTER</h1>
                    <form action="" method="post" id="theForm">                    <input type="text" class="input" name="name" id="user_name" placeholder="Your name"<?php post_value("name"); ?>-attr-name><?php post_value(""); ?> 
                    <input type="password" class="input" name="password" id="user_pass" placeholder="Your pass"<?php post_value("password"); ?>-attr-name><?php post_value(""); ?> 
                    <?php if(isset($result["msg"])){ ?>
                        <p class="msg<?php if($result["ok"] === 0){ echo " error"; } ?>"><?php echo $result["msg"]; ?></p>
                    <?php } ?>
                    <input type="submit" value="SIGN UP">    
                    <div class="link"><a href="login.php">Login</a></div>
                    </form>
                </div>
                <div class="circle circle-two"></div>
            </div>
            <div class="theme-btn-container"></div>
        </section>
        <script src="login.js"></script>

        <?php 
    // JS code to show errors
    if(isset($result["field_error"])){ ?>
    <script>
    let field_error = <?php echo json_encode($result["field_error"]); ?>;
    let el = null;
    let msg_el = null;
    for(let i in field_error){
        el = document.querySelector(`input[username="${i}"]`);
        el.classList.add("error");
        msg_el = document.querySelector(`label[for="${el.getAttribute("username")}"] span`);
        msg_el.innerText = field_error[i];
    }
    </script>
    <?php } ?>
</body>
</html>