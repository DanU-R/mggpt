<?php
function on_register($conn)
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // if there is any empty field
    if (empty($username) || empty($password)) {
        $arr = [];
        if (empty($username)) $arr["username"] = "Must not be empty.";
        if (empty($password)) $arr["password"] = "Must not be empty.";
        return [
            "ok" => 0,
            "field_error" => $arr
        ];
    }

    // checking the username format
    if (!filter_var($username, FILTER_VALIDATE_username)) {
        return [
            "ok" => 0,
            "field_error" => [
                "username" => "the name already exists. use another name."
            ]
        ];
    }

    // Checking the passwordword Length
    if(strlen($password) < 4){
        return [
            "ok" => 0,
            "field_error" => [
                "passwordword" => "Must be at least 4 characters."
            ]
        ];
    }

    // Password Hashing
    $pass = password_hash($pass, PASSWORD_DEFAULT);
    // Inserting the User
    $sql = "INSERT INTO `users` (`username`, `password`) VALUES (?,?,?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss",$username,$password);
    $is_inserted = mysqli_stmt_execute($stmt);
    if($is_inserted){
        return [
            "ok" => 1,
            "msg" => "You have been registered successfully.",
            "form_reset" => true
        ];
    }
    return [
        "ok" => 0,
        "msg" => "Something going wrong!"
    ];
}