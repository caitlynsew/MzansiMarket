<?php
session_start();
include("includes/db.php");

if(isset($_POST['register'])){

    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (fullname, email, password, role)
            VALUES ('$fullname', '$email', '$password', '$role')";

    if(mysqli_query($conn, $sql)){
        $success = "Registration successful. You can now login.";
    } else {
        $error = "Registration failed: " . mysqli_error($conn);
    }
}

include("includes/header.php");
?>

<div class="auth-wrapper">

    <div class="auth-panel">

        <p class="market-category">Join MzansiMarket</p>

        <h1>Create your marketplace account</h1>

        <p>
            Register as a buyer or seller and start trading safely with local South African users.
        </p>

    </div>

    <div class="auth-card">

        <h2>Create Account</h2>

        <?php if(isset($success)){ ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php } ?>

        <?php if(isset($error)){ ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <label>Full Name</label>
            <input type="text" name="fullname" required>

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Account Type</label>
            <select name="role" required>
                <option value="buyer">Buyer</option>
                <option value="seller">Seller</option>
            </select>

            <button type="submit" name="register">
                Register
            </button>

        </form>

        <p class="auth-link">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

    </div>

</div>

<?php
include("includes/footer.php");
?>