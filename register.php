<?php
session_start();

if (isset($_SESSION['user_role'])) {
    header("Location: index.php");
}

function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function user_exists($file_path, $username, $email) {
    if (($handle = fopen($file_path, "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            list($existing_username, $existing_email, $existing_password) = $data;
            if ($existing_username === $username || $existing_email === $email) {
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = "user";

    
    if (empty($username) || empty($email) || empty($password) || !is_valid_email($email)) {
        echo "Please fill in all fields with valid data.";
    } else {
        $user_data = "$username,$email,$password,$role" . PHP_EOL;
        // $file_path = 'users.csv';
        $file_path = 'users.txt';

        if (!file_exists($file_path)) {
            $header = "Username,Email,Password,Role" . PHP_EOL;
            file_put_contents($file_path, $header);
            $admin_data = "admin,admin@gmail.com,1234,admin" . PHP_EOL;
            file_put_contents($file_path, $admin_data, FILE_APPEND);
        }

        if (user_exists($file_path, $username, $email)) {
            echo "Username or email already exists. Please choose a different one.";
        } else {
            file_put_contents($file_path, $user_data, FILE_APPEND);
            echo "Registration successful. You can now log in.";
        }
    }
}
?>

<!-- HTML Registration Form -->
<form method="POST" action="" class="form-design">
    <div class="item">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
    </div>
    <div class="item">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
    </div>
    <div class="item">
        <label for="password">Password:</label>
        <input type="password" name="password" required>
    </div>
    <div class="item-btn">
        <input type="submit" value="Register">
        <a href="login.php">Login</a>
    </div>
</form>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
        font-size: 24px;
        font-weight: 700;
        color: #1b1c17;
    }
    .form-design{
        max-width: 350px;
        width: 100%;
        padding: 20px;
        border-radius: 15px;
        background-color: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin: 20px;
    }
    .form-design .item{
        position: relative;
        padding-bottom: 20px;
    }
    .form-design .item label{
        display: block;
        font-size: 14px;
        font-weight: 700;
        line-height: 18px;
        color: #1b1c17;
        padding-bottom: 16px;
    }
    .form-design .item input{
        width: 100%;
        padding: 10px;
        border: 1px solid #00000080;
        border-radius: 5px;
    }
    .form-design .item input:focus{
        outline: none;
    }
    .form-design .item-btn{
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .form-design .item-btn input{
        padding: 8px 10px;
        background-color: #cdef84;
        border: 0;
        border-radius: 5px;
        font-size: 18px;
        font-weight: 600;
        color: #1b1c17;
    }
    .form-design .item-btn a{
        display: inline-block;
        padding: 8px 10px;
        background-color: #1b1c17;
        border: 0;
        border-radius: 5px;
        text-decoration: none;
        font-size: 18px;
        font-weight: 600;
        color: #fff;
    }
</style>