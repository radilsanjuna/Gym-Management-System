<?php
include '../Components/DatabaseConnection.php';
// Fetch trainer data from the database
$query = "SELECT * FROM trainers_pro";
$result = $conn->query($query);
?>

<!-- Team Start -->
<div class="container pt-5 team">
    <div class="d-flex flex-column text-center mb-5">
        <h4 class="text-primary font-weight-bold">Our Trainers</h4>
        <h4 class="display-4 font-weight-bold">Meet Our Expert Trainers</h4>
    </div>
    <div class="row justify-content-center">
        <?php while ($trainer = $result->fetch_assoc()) : ?>
        <div class="col-lg-3 col-md-6 mb-5">
            <div class="card border-0 bg-secondary text-center text-white">
                <img class="card-img-top" src="uploads/<?php echo $trainer['profile_img']; ?>" alt="">
                <div class="card-social d-flex align-items-center justify-content-center">
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="<?php echo $trainer['twitter_link']; ?>"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="<?php echo $trainer['facebook_link']; ?>"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="<?php echo $trainer['linkedin_link']; ?>"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="<?php echo $trainer['instagram_link']; ?>"><i class="fab fa-instagram"></i></a>
                </div>
                <div class="card-body bg-secondary">
                    <h4 class="card-title text-primary"><?php echo $trainer['full_name']; ?></h4>
                    <p class="card-text"><?php echo $trainer['position']; ?></p>
                    <p class="card-text"><?php echo $trainer['bio']; ?></p>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>
<!-- Team End -->
