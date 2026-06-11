<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<h2 class="mb-4">Manage Users</h2>

<div class="table-responsive">
<table class="table table-bordered table-hover bg-white">

<thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Verified</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['user_id']; ?></td>
    <td><?php echo $row['fullname']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['role']; ?></td>
    <td>
        <span class="badge bg-<?php echo $row['verified'] == 'yes' ? 'success' : 'secondary'; ?>">
            <?php echo $row['verified']; ?>
        </span>
    </td>
    <td>
        <?php if($row['role'] == 'seller' && $row['verified'] == 'no'){ ?>
            <a href="verify_seller.php?id=<?php echo $row['user_id']; ?>"
               class="btn btn-success btn-sm">
                Verify Seller
            </a>
        <?php } else { ?>
            <span class="text-muted">N/A</span>
        <?php } ?>
    </td>
</tr>
<?php } ?>

</tbody>
</table>
</div>

<a href="dashboard.php" class="btn btn-dark">
    Back to Dashboard
</a>

<?php
include("../includes/footer.php");
?>