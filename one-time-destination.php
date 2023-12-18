<?php
session_start();
$is_random = isset($_GET['random']) && $_GET['random'] == 'true';

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./includes/styles/image.css">
    <link rel="stylesheet" href="./includes/styles/footer.css">
    <title>Lab 7: Destination Details</title>

</head>

<body>
    <?php
    include("./includes/header.php");
    require_once('/home/ajoshi7/data/connect.php');
    $conn = db_connect();


    ?>
    <main class="container">
        <section class="row justify-content-center py-3 my-2">
            <div class="col-12 col-lg-10 col-xl-8">
                <h1 class="fw-light text-center mb-4">
                    Destination Details
                </h1>
                <?php

                if (isset($_GET['id'])) {
                    $destination_id = $_GET['id'];
                    $query = "select * from destination where destination_id = '$destination_id'";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) < 1) {
                        echo "<p class='text-center fs-5'> The query did not return any rows </p>";
                    } else {
                         if ($is_random) {
                                echo '<p class="alert alert-info">This destination was picked randomly for you.</p>';
                         }
                            
                        
                        echo '<p class="lead text-center">Find the details for your image. The average time to reach the place is calculated from the Capital of India - New Delhi, and the currency used in budget is INR</p>';
                        
                        echo '<div class="card-frame">';

                        while ($row = mysqli_fetch_array($result)) {

                            $destination_id = $row['destination_id'];
                            $title = $row['name'];
                            $description = $row['description'];
                            $file_name = $row['file_name'];
                            $airport = $row['nearest_airport'];
                            $season = $row['best_season'];
                            $population = $row['population'];
                            $avg_time = $row['average_time'];
                            $avg_budget = $row['average_budget'];
                            $language = $row['language'];
                            $altitude = $row['altitude'];
                            $trek_length = $row['trek_length'];
                            $rating = $row['rating'];
                            echo "<div class=\"text-center\">";
                            echo "<img src=\"Uploads/$file_name\" alt=\"$description\" class=\"img-fluid mb-4\">";
                            echo "</div>";
                            echo "<div>";
                            echo "<h5 class=\"text-center\">$title</h5>";
                            echo "<p class=\"text-center text-muted\">About: $description</p>";
                            echo "<p class=\"text-center text-muted\">Nearest airport: $airport</p>";
                            echo "<p class=\"text-center text-muted\">Best season: $season</p>";
                            echo "<p class=\"text-center text-muted\">Population: $population</p>";
                            echo "<p class=\"text-center text-muted\">Average time: $avg_time</p>";
                            echo "<p class=\"text-center text-muted\">Average budget: $avg_budget</p>";
                            echo "<p class=\"text-center text-muted\">Language: $language</p>";
                            echo "<p class=\"text-center text-muted\">Altitude: $altitude</p>";
                            echo "<p class=\"text-center text-muted\">Trek length: $trek_length</p>";
                            echo "<p class=\"text-center text-muted\">Rating: $rating</p>";
                            echo "</div>";
                        }
                        echo '<a href="destination.php" class="btn btn-outline-primary mb-5 d-block mx-auto btn-small">Go Back</a>';
                        echo '</div>';
                    }
                } else {
                    header("Location:index.php");
                }
                ?>

            </div>
        </section>
    </main>
    <?php
    include("./includes/footer.php");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>