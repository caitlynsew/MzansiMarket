<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id'])){
    header("Location: ../login.php");
    exit();
}

$order_id = $_GET['order_id'];
$user_id = $_SESSION['user_id'];

if(isset($_POST['submit_dispute'])){

    $description = $_POST['description'];

    $sql = "INSERT INTO disputes
            (order_id, user_id, description)
            VALUES
            ('$order_id', '$user_id', '$description')";

    if(mysqli_query($conn, $sql)){
        $success = "Dispute submitted successfully.";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card shadow">
            <div class="card-body p-4">

                <h2 class="mb-4">Report Dispute</h2>

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

                    <div class="mb-3">
                        <label class="form-label">
                            Describe the issue
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="6"
                                  required></textarea>
                    </div>

                    <button type="submit"
                            name="submit_dispute"
                            class="btn btn-dark">
                        Submit Dispute
                    </button>

                    <a href="orders.php" class="btn btn-outline-secondary">
                        Back to Orders
                    </a>

                </form>

            </div>
        </div>

    </div>
</div>

<?php
include("../includes/footer.php");
?>