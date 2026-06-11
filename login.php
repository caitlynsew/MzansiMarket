<?php
session_start();
include("includes/db.php");

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1){

        $user = mysqli_fetch_assoc($result);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role'] = $user['role'];

            if($user['role'] == 'seller'){
                header("Location: seller/dashboard.php");
            }
            elseif($user['role'] == 'admin'){
                header("Location: admin/dashboard.php");
            }
            else{
                header("Location: index.php");
            }

            exit();

        } else {
            $error = "Incorrect password.";
        }

    } else {
        $error = "User not found.";
    }
}

include("includes/header.php");
?>

<div class="auth-wrapper">

    <div class="auth-panel">

        <p class="market-category">Welcome Back</p>

        <h1>Login to MzansiMarket</h1>

        <p>
            Access your orders, wishlist, seller dashboard and marketplace account.
        </p>

    </div>

    <div class="auth-card">

        <h2>Sign In</h2>

        <?php if(isset($error)){ ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">
                Login
            </button>

        </form>

        <p class="auth-link">
            Dont have an account?
            <a href="register.php">Register here</a>
        </p>

    </div>

</div>

<?php
include("includes/footer.php");
?>