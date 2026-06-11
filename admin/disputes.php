<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login.php");
    exit();
}

$sql = "SELECT disputes.*, users.fullname 
        FROM disputes
        JOIN users ON disputes.user_id = users.user_id
        ORDER BY disputes.created_at DESC";

$result = mysqli_query($conn, $sql);
?>

<h2 class="mb-4">Customer Disputes</h2>

<div class="table-responsive">
<table class="table table-bordered table-hover bg-white">

<thead class="table-dark">
<tr>
    <th>Dispute ID</th>
    <th>Order ID</th>
    <th>Customer</th>
    <th>Description</th>
    <th>Status</th>
    <th>Date</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
    <td><?php echo $row['dispute_id']; ?></td>
    <td><?php echo $row['order_id']; ?></td>
    <td><?php echo $row['fullname']; ?></td>
    <td><?php echo $row['description']; ?></td>
    <td>
        <span class="badge bg-warning text-dark">
            <?php echo $row['status']; ?>
        </span>
    </td>
    <td><?php echo $row['created_at']; ?></td>
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