<?php
// Start a session to manage user sessions
session_start();

if (isset($_SESSION['user_role'])) {
    header("Location: index.php");
} 

function authenticate_user($email, $password) {

    // $file_path = 'users.csv';
    $file_path = 'users.txt';

    if (!file_exists($file_path)) {
        return null;
    }

    if (($handle = fopen($file_path, "r")) !== false) {
        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            list($existing_username, $existing_email, $existing_password, $existing_role) = $data;
            if ($existing_password === $password && $existing_email === $email) {
                fclose($handle);
                return $existing_role;
            }
        }
        fclose($handle);
    }

    // Authentication failed
    return null;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        echo "Please enter your email and password.";
    } else {
        $user_role = authenticate_user($email, $password);

        if ($user_role) {
            $_SESSION['user_role'] = $user_role;
            header("Location: index.php");
            exit;
        } else {
            echo "Authentication failed. Please check your email and password.";
        }
    }
}
?>

<!-- HTML Login Form -->
<form method="POST" action="" class="form-design">
    <div class="item">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    </div>
    <div class="item">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" required>
    </div>
    <div class="item-btn">
    <input type="submit" value="Login">
    <a href="register.php">Register Account</a>
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