<?php
session_start();

if ( !isset( $_SESSION[ 'user_role' ] ) ) {
    header( "Location: login.php" );
}
$user_role = $_SESSION[ 'user_role' ];
?>
<h2><?php echo ucfirst( $user_role ); ?> Dashboard</h2>
<a class="logoutBtn" href="logout.php">Logout</a>

<?php if ( "admin" == $user_role || "manager" == $user_role ) {

    function get_user_list( $file_path ) {
        $user_list = [];

        if (  ( $handle = fopen( $file_path, "r" ) ) !== false ) {
            for ( $i = 0; $i < 2; $i++ ) {
                fgetcsv( $handle, 1000, "," );
            }
            while (  ( $data = fgetcsv( $handle, 1000, "," ) ) !== false ) {
                list( $username, $email, $password, $role ) = $data;
                $user_list[  ] = [
                    'Username' => $username,
                    'Email'    => $email,
                    'Role'     => $role,
                 ];
            }
            fclose( $handle );
        }
        return $user_list;
    }
    // $file_path = 'users.csv';
    $file_path = 'users.txt';

    $users = get_user_list( $file_path );
?>


<h1>User List</h1>
<div class="form-design">
    <table>
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ( $users as $user ): ?>
        <tr>
            <td><?php echo $user[ 'Username' ]; ?></td>
            <td><?php echo $user[ 'Email' ]; ?></td>
            <td><?php echo $user[ 'Role' ]; ?></td>

            <td>
                <a href="edit.php?username=<?php echo $user[ 'Username' ]; ?>">Edit</a>
                <?php if ( "admin" == $user_role) {;?> <a class="delete" href="delete.php?username=<?php echo $user[ 'Username' ]; ?>" onclick="return confirm('Are you sure you want to delete it?')">Delete</a><?php };?>
            </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    
</div>
    <p>Only admin can delete another user.</p>
    <style>
        table td,table th {
            padding: 10px;
        }
        table td {
            border-bottom: 1px solid #00000050;
        }
    </style>
<?php
} else {
    ?>
    <h4>User Cann't See user list</h4>
    <?php
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
    }
    .form-design{
        max-width: 750px;
        width: 100%;
        padding: 20px;
        border-radius: 15px;
        background-color: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        margin: 20px;
    }
    .form-design table{
        width: 100%;
        border-collapse: separate;
    }
    .form-design table thead{
        background-color: #00000050;
    }
    .form-design table thead th{
        border: none;
    }
    .form-design a{
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
    .form-design a.delete{
        background-color: red;
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