<?php
session_start();

if (!isset($_SESSION['user_role'])) {
    header("Location: login.php");
} 
$user_role = $_SESSION['user_role'];
if ( ('admin' == $user_role) || ('manager' == $user_role) ) { 
    $username = '';
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = $_POST["username"];
        $new_role = $_POST["new_role"];

        // $file_path = 'users.csv';
        $file_path = 'users.txt';
        $lines = file($file_path);

        foreach ($lines as $key => $line) {
            list($existing_username, $email, $password, $role) = explode(',', trim($line));
            if ($existing_username === $username) {
                $lines[$key] = "$existing_username,$email,$password,$new_role\n";
                break;
            }
        }

        file_put_contents($file_path, $lines);
        header("Location: index.php");
    }
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Edit User Role</title>
    </head>
    <body>
        <h1>Edit User Role</h1>
        <form method="POST" action="" class="form-design">
            <label for="username">Username:</label>
            <span><?php echo $username; ?></span>
            <input type="hidden" name="username" value="<?php echo $username; ?>" required><br>
            <div class="item">
            <label for="new_role">New Role:</label>
            <select name="new_role">
                <?php if ('admin' == $user_role) { ?>
                <option value="admin">Admin</option>
                <?php } ?>
                <option value="manager">Manager</option>
                <option value="user">User</option>
            </select>
            </div>
            <input class="logoutBtn" type="submit" value="Update Role">
        </form>
        <p>Only admin can create an another admin.</p>
    </body>
    </html>
<?php
}else{
    header("Location: login.php");
}
?>


<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 30px;
        flex-direction: column;
        font-size: 24px;
        font-weight: 700;
        color: #1b1c17;
        text-align: center;
    }
    .form-design{
        max-width: 500px;
        width: 100%;
        padding: 20px;
        border-radius: 15px;
        background-color: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin: 20px;
    }
    .form-design .item{
        padding: 20px 0;
    }
    .form-design .item label{
        display: block;
        font-size: 18px;
        font-weight: 700;
        line-height: 18px;
        color: #1b1c17;
        padding-bottom: 16px;
    }
    .form-design span{
        text-transform: capitalize;
    }
    .logoutBtn{
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