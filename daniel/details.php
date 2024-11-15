
<?php
include('./header.php');
$id = $_GET['id'];
include('./connect.php');
$result = $conn->query("SELECT * FROM product WHERE id = '$id'");
while($row = $result->fetch_assoc()) {
	$item = $row['item'];
	$description = $row['description'];
	$price = $row['price'];
	$image = $row['image'];
	$category = $row['category'];
	
}

$r = mysqli_query($conn,"SELECT *, AVG(rating) as av FROM rating WHERE item = '$id'");
$r2 = mysqli_query($conn,"SELECT * FROM rating WHERE item = '$id'");
$s = mysqli_num_rows($r2);
while($r1 = mysqli_fetch_array($r)) {
	$rating = $r1['av'];
}
?>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
<style>

@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

.wrapper {
	background: var(--white);
	padding: 2rem;
	max-width: 576px;
	width: 100%;
	border-radius: .75rem;
	box-shadow: var(--shadow);
	text-align: center;
}
.wrapper h3 {
	font-size: 1.5rem;
	font-weight: 600;
	margin-bottom: 1rem;
}
.rating {
	display: flex;
	justify-content: center;
	align-items: center;
	grid-gap: .5rem;
	font-size: 2rem;
	color: var(--yellow);
}
.rating .star {
	cursor: pointer;
}
.rating .star.active {
	opacity: 0;
	animation: animate .5s calc(var(--i) * .1s) ease-in-out forwards;
}

@keyframes animate {
	0% {
		opacity: 0;
		transform: scale(1);
	}
	50% {
		opacity: 1;
		transform: scale(1.2);
	}
	100% {
		opacity: 1;
		transform: scale(1);
	}
}


.rating .star:hover {
	transform: scale(1.1);
}
textarea {
	width: 100%;
	background: var(--light);
	padding: 1rem;
	border-radius: .5rem;
	border: none;
	outline: none;
	resize: none;
	margin-bottom: .5rem;
}
.btn-group {
	display: flex;
	grid-gap: .5rem;
	align-items: center;
}
.btn-group .btn {
	padding: .75rem 1rem;
	border-radius: .5rem;
	border: none;
	outline: none;
	cursor: pointer;
	font-size: .875rem;
	font-weight: 500;
}
.btn-group .btn.submit {
	background: var(--blue);
	color: var(--white);
}
.btn-group .btn.submit:hover {
	background: var(--blue-d-1);
}
.btn-group .btn.cancel {
	background: var(--white);
	color: var(--blue);
}
.btn-group .btn.cancel:hover {
	background: var(--light);
}
</style>
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="<?php echo $image ?>" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="<?php echo $image ?>" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="<?php echo $image ?>" alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src="<?php echo $image ?>" alt="Image">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
			<form action="add_cart.php" method="GET">
                <div class="h-100 bg-light p-30">
                    <h3><?php echo $item ?></h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
						<?php
							if($rating == '5') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>';
							}
							if($rating >= '4' && $rating < '5') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '3' && $rating < '4') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '2' && $rating < '3') {
									echo '<small class="fa fa-star text-primary mr-1"></small>
									<small class="fa fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>
									<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating >= '1' && $rating < '2') {
											echo '
											<small class="fa fa-star text-primary"></small>
											<small class="far far-star text-primary mr-1"></small>
											<small class="far fa-star text-primary mr-1"></small>
											<small class="far fa-star text-primary mr-1"></small>
											<small class="far fa-star text-primary mr-1"></small>
											<small class="far fa-star text-primary mr-1"></small>';
							}
							if($rating == '') {
									echo '<small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small><small class="far fa-star text-primary mr-1"></small>';
							}
										
										?>
                        </div>
                        <small class="pt-1">(<?php echo $s ?> Reviews)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">₱ <?php echo number_format($price,2) ?></h3>
                    <p class="mb-4"><?php  echo $description?></p>
                 
                    <div class="d-flex mb-4" style="display:none !important">
                        <strong class="text-dark mr-3"  style="display:none">Colors:</strong>
                        
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-1" name="color">
                                <label class="custom-control-label" for="color-1">Black</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-2" name="color">
                                <label class="custom-control-label" for="color-2">White</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-3" name="color">
                                <label class="custom-control-label" for="color-3">Red</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-4" name="color">
                                <label class="custom-control-label" for="color-4">Blue</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" id="color-5" name="color">
                                <label class="custom-control-label" for="color-5">Green</label>
                            </div>
                    </div>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="number" class="form-control bg-secondary border-0 text-center" value="1" name="quantity">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus" type="button">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
						
					<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                        <button class="btn btn-primary px-3" type="submit"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                </div>
            </div>
			</form>
        </div>

        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (<?php echo $s ?>)</a>
                    </div>
					<?php
					if(isset($_POST['submit'])) {
						$rating = $_POST['rating'];
						$message = $_POST['message'];
						$name = $_POST['name'];
						$email = $_POST['email'];
						$item = $_GET['id'];
						$date = date('F d, Y');
						mysqli_query($conn,"INSERT INTO rating (rating, message, name,email,item,date)VALUES ('$rating', '$message', '$name','$email','$item','$date')");
						echo '<script>alert("Review has been posted");window.location="details.php?id='.$item.'"</script>';
					}
					?>
                                    <form method="POST" action="#">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <small>Your email address will not be published. Required fields are marked *</small>
                                    <div class="d-flex my-3">
							
                                        <p class="mb-0 mr-2">Your Rating * :</p>
                                        		
			<div class="rating">
				<input type="number" name="rating" hidden>
				<i class='bx bx-star star' style="--i: 0;"></i>
				<i class='bx bx-star star' style="--i: 1;"></i>
				<i class='bx bx-star star' style="--i: 2;"></i>
				<i class='bx bx-star star' style="--i: 3;"></i>
				<i class='bx bx-star star' style="--i: 4;"></i>
			</div>
                                    </div>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea id="message" cols="30" rows="5" class="form-control" name="message" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Your Email *</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3" name="submit">
                                        </div>
                                    </form>
									
                        <br>
                            <div class="row">
							<?php
							$id = $_GET['id'];
							$r = mysqli_query($conn,"SELECT * FROM rating WHERE item = '$id'");
							while($row = mysqli_fetch_array($r)) {
								$rating = $row['rating'];
							?>
							<div class="col-md-12">
								<div class="media mb-4">
									<div class="media-body">
										<h6><?php echo $row['name'] ?><small> - <i><?php echo $row['date'] ?></i></small></h6>
										<div class="text-primary mb-2">
										<?php
											if($rating == '5') {
													echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
											}
											if($rating == '4') {
													echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i>';
											}
											if($rating == '3') {
													echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
											}
											if($rating == '2') {
													echo '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
											}
											if($rating == '1') {
													echo '<i class="fas fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
											}
											if($rating == '') {
													echo '<i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i><i class="far fa-star"></i>';
											}
										
										?>
											
										</div>
										<p><?php echo $row['message'] ?></p>
									</div>
								</div>
							</div>
							<?php
							}
							?>
                            </div>
                        
									<script>
									const allStar = document.querySelectorAll('.rating .star')
const ratingValue = document.querySelector('.rating input')

allStar.forEach((item, idx)=> {
	item.addEventListener('click', function () {
		let click = 0
		ratingValue.value = idx + 1

		allStar.forEach(i=> {
			i.classList.replace('bxs-star', 'bx-star')
			i.classList.remove('active')
		})
		for(let i=0; i<allStar.length; i++) {
			if(i <= idx) {
				allStar[i].classList.replace('bx-star', 'bxs-star')
				allStar[i].classList.add('active')
			} else {
				allStar[i].style.setProperty('--i', click)
				click++
			}
		}
	})
})
									</script>
                    <div class="tab-content">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
				
          <?php
		include('./connect.php');
		$result = $conn->query("SELECT * FROM product ORDER BY ID DESC LIMIT 10");
		while($row = $result->fetch_assoc()) {
		  ?>
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="<?php echo $row['image'] ?>" alt="">
                            <div class="product-action">
                            <a class="btn btn-outline-dark btn-square" href="add_cart.php?id=<?php echo $row['id'] ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href="add_heart.php?id=<?php echo $row['id'] ?>"><i class="far fa-heart"></i></a>
                            <a class="btn btn-outline-dark btn-square" href="details.php?id=<?php echo $row['id'] ?>"><i class="fa fa-search"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href=""><?php echo $row['item'] ?></a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>₱<?php echo number_format($row['price'],2) ?></h5></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small class="fa fa-star text-primary mr-1"></small>
                                <small>(99)</small>
                            </div>
                        </div>
                    </div>
					<?php
		}
					?>
                  
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

<?php
include('./footer.php');
?>