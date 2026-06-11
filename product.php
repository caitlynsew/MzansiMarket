<?php
session_start();
include("includes/db.php");
include("includes/header.php");

$product_id = $_GET['id'];

$sql = "SELECT products.*, users.fullname, users.verified
        FROM products
        JOIN users ON products.seller_id = users.user_id
        WHERE product_id='$product_id'";

$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);
?>

<div class="product-detail-page">

    <div class="product-detail-grid">

        <div class="product-detail-image">
            <img src="uploads/<?php echo $product['image']; ?>">
        </div>

        <div class="product-detail-info">

            <p class="market-category">
                <?php echo $product['category']; ?>
            </p>

            <h1>
                <?php echo $product['product_name']; ?>
            </h1>

            <h2>
                R<?php echo $product['price']; ?>
            </h2>

            <p class="product-description">
                <?php echo $product['description']; ?>
            </p>

            <div class="stock-box">
                <?php if($product['stock'] > 0){ ?>
                    <span class="in-stock">
                        <?php echo $product['stock']; ?> available
                    </span>
                <?php } else { ?>
                    <span class="out-stock">
                        Out of Stock
                    </span>
                <?php } ?>
            </div>

            <div class="seller-box">

                <p>Seller</p>

                <a href="seller_profile.php?id=<?php echo $product['seller_id']; ?>">
                    <?php echo $product['fullname']; ?>
                </a>

                <?php if($product['verified'] == 'yes'){ ?>
                    <span class="verified-badge">Verified Seller</span>
                <?php } else { ?>
                    <span class="unverified-badge">Unverified Seller</span>
                <?php } ?>

            </div>

            <div class="product-actions">

                <?php if($product['stock'] > 0){ ?>
                    <a href="buyer/add_to_cart.php?id=<?php echo $product['product_id']; ?>"
                       class="cart-btn">
                        Add to Cart
                    </a>
                <?php } else { ?>
                    <button class="disabled-btn" disabled>
                        Out of Stock
                    </button>
                <?php } ?>

                <a href="buyer/add_to_wishlist.php?id=<?php echo $product['product_id']; ?>"
                   class="details-btn">
                    ♡ Wishlist
                </a>

            </div>

        </div>

    </div>

</div>

<hr class="section-divider">

<div class="review-section">

    <h2>Customer Reviews</h2>

    <?php if(isset($_SESSION['user_id'])){ ?>

        <form method="POST" action="buyer/add_review.php" class="review-form">

            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

            <label>Rating</label>

            <select name="rating" required>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>

            <label>Comment</label>

            <textarea name="comment" rows="4" required></textarea>

            <button type="submit">
                Submit Review
            </button>

        </form>

    <?php } else { ?>

        <p>
            <a href="login.php">Login</a> to leave a review.
        </p>

    <?php } ?>

    <?php
    $review_sql = "SELECT reviews.*, users.fullname
                   FROM reviews
                   JOIN users ON reviews.user_id = users.user_id
                   WHERE reviews.product_id='$product_id'
                   ORDER BY reviews.created_at DESC";

    $review_result = mysqli_query($conn, $review_sql);

    while($review = mysqli_fetch_assoc($review_result)){
    ?>

        <div class="review-card">

            <div class="review-top">

                <strong>
                    <?php echo $review['fullname']; ?>
                </strong>

                <span>
                    <?php echo $review['rating']; ?> Stars
                </span>

            </div>

            <p>
                <?php echo $review['comment']; ?>
            </p>

            <small>
                <?php echo $review['created_at']; ?>
            </small>

        </div>

    <?php } ?>

</div>

<?php
include("includes/footer.php");
?>