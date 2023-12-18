<?php
session_start();
require_once('/home/ajoshi7/data/connect.php');
$conn = db_connect();
function getRandomDestinationId($conn) {
    $query = "SELECT destination_id FROM destination";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error executing query: " . mysqli_error($conn));
    }

    $destination_ids = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push($destination_ids, $row['destination_id']);
    }

    return $destination_ids[array_rand($destination_ids)];
}

$random_destination_id = getRandomDestinationId($conn);



if (isset($_SESSION["user"])) {
    if (isset($_SESSION["email"])) {
        $message_appointment = "";
        $email = "";
        $email = $_SESSION["email"];
    }
}
$msg = "";
    if(isset($_SESSION['msg'])){
        $msg = $_SESSION["msg"];
        unset($_SESSION["msg"]);
    }
$season_filter = isset($_POST['season_filter']) ? $_POST['season_filter'] : (isset($_GET['season_filter']) ? $_GET['season_filter'] : "");
$budget_filter = isset($_POST['budget_filter']) ? $_POST['budget_filter'] : (isset($_GET['budget_filter']) ? $_GET['budget_filter'] : "");
$rating_filter = isset($_POST['rating_filter']) ? $_POST['rating_filter'] : (isset($_GET['rating_filter']) ? $_GET['rating_filter'] : "");

$search = "";
if (isset($_POST['submit'])) {
    $search = isset($_POST['search']) ? trim($_POST['search']) : "";
    if (isset($_POST['clear'])) {
        $search = "";
    }
}
if (empty($budget_filter)) {
    $starting_budget = 0;
    $end_budget = 9999999.999;
} else {
    if ($budget_filter == "lowest") {
        $starting_budget = 0;
        $end_budget = 9.999;
    } else if ($budget_filter == "average") {
        $starting_budget = 10.000;
        $end_budget = 19.999;
    } else if ($budget_filter == "highest") {
        $starting_budget = 20.000;
        $end_budget = 9999999999.99;
    }
}
if (empty($rating_filter)) {
    $starting_rating = 0;
    $end_rating = 5;
} else {
    if ($rating_filter == "lowest") {
        $starting_rating = 0;
        $end_rating = 2.99;
    } else if ($rating_filter == "average") {
        $starting_rating = 3.00;
        $end_rating = 4.4;
    } else if ($rating_filter == "highest") {
        $starting_rating = 4.5;
        $end_rating = 5.0;
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./includes/styles/edit-images.css">
    <link rel="stylesheet" href="./includes/styles/footer.css">
    <title>View Destination</title>

</head>

<body>
    <?php
    include("./includes/header.php");



    ?>
    <main class="container">
        <section class="row justify-content-center py-3 my-2">
            <div class="col-12 col-lg-10 col-lg-8">
                <h1 class="fw-light">
                Hello Explorer, browse destinations through here. 
                </h1>
                <h5 class="fw-light">You can also <a href="one-time-destination.php?id=<?php echo $random_destination_id; ?>&random=true">get a random destination picked by us</a></h5>

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="d-flex flex-wrap">
                    <div class="col-md-4 col-sm-12 d-flex align-items-center filter-container mb-2">
                        <label for="season_filter" class="form-label me-2">Season:</label>
                        <select class="form-select w-auto" name="season_filter" id="season_filter"
                            onchange="this.form.submit()">
                            <option value="" disabled selected>Select a Season</option>
                            <option value="Spring" <?php echo $season_filter == "Spring" ? "selected" : ""; ?>>Spring
                            </option>
                            <option value="Summer" <?php echo $season_filter == "Summer" ? "selected" : ""; ?>>Summer
                            </option>
                            <option value="Fall" <?php echo $season_filter == "Fall" ? "selected" : ""; ?>>
                                Fall</option>
                            <option value="Winter" <?php echo $season_filter == "Winter" ? "selected" : ""; ?>>Winter
                            </option>
                            <option value="All Weather" <?php echo $season_filter == "All Weather" ? "selected" : ""; ?>>
                                All Weather
                            </option>
                        </select>
                        <?php if (!empty($season_filter)): ?>
                            <button type="button" class="btn btn-link"
                                onclick="document.getElementById('season_filter').value = ''; this.form.submit();">Clear
                                Filter
                            </button>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-4 col-sm-12 d-flex align-items-center filter-container mb-2">
                        <label for="budget_filter" class="form-label me-2 ">Budget:</label>
                        <select class="form-select w-auto" name="budget_filter" id="budget_filter"
                            onchange="this.form.submit()">
                            <option value="" disabled selected>Pick a budget range</option>
                            <option value="lowest" <?php echo $budget_filter == "lowest" ? "selected" : ""; ?>>Below 10(k)
                            </option>
                            <option value="average" <?php echo $budget_filter == "average" ? "selected" : ""; ?>>10k-20(k)
                            </option>
                            <option value="highest" <?php echo $budget_filter == "highest" ? "selected" : ""; ?>>Above
                                20(k)
                            </option>

                        </select>
                        <?php if (!empty($budget_filter)): ?>
                            <button type="button" class="btn btn-link"
                                onclick="document.getElementById('budget_filter').value = ''; this.form.submit();">Clear
                                Filter
                            </button>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4 col-sm-12 d-flex align-items-center filter-container mb-2">
                        <label for="rating_filter" class="form-label me-2"> Rating:</label>
                        <select class="form-select w-auto" name="rating_filter" id="rating_filter"
                            onchange="this.form.submit()">
                            <option value="" disabled selected>Pick a range</option>
                            <option value="lowest" <?php echo $rating_filter == "lowest" ? "selected" : ""; ?>>
                                Below 3
                            </option>
                            <option value="average" <?php echo $rating_filter == "average" ? "selected" : ""; ?>>3-4.5
                            </option>
                            <option value="highest" <?php echo $rating_filter == "highest" ? "selected" : ""; ?>>Above 4.5
                            </option>

                        </select>
                        <?php if (!empty($rating_filter)): ?>
                            <button type="button" class="btn btn-link"
                                onclick="document.getElementById('rating_filter').value = ''; this.form.submit();">Clear
                                Filter
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
                <?php
                $query = "SELECT * FROM destination WHERE (name LIKE '%$search%' OR nearest_airport LIKE '%$search%')";
                if (!empty($season_filter)) {
                    $query .= " AND best_season = '$season_filter'";
                }

                if (!empty($budget_filter)) {
                    $query .= "AND average_budget BETWEEN '$starting_budget' AND '$end_budget'";
                }
                if (!empty($rating_filter)) {
                    $query .= "AND rating BETWEEN '$starting_rating' AND '$end_rating'";
                }
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    die("Error executing query: " . mysqli_error($conn));
                }
                $num = mysqli_num_rows($result);
                $number_of_records = 6;
                //ceil Returns the next highest integer value by rounding up num if necessary
                $total_pages = ceil($num / $number_of_records);
                //creating pagination buttons, the will same as number of total pages 
                for ($btn = 1; $btn <= $total_pages; $btn++) {
                    echo '<a href="destination.php?page=' . $btn . '&season_filter=' . urlencode($season_filter) . '&budget_filter=' . urlencode($budget_filter) .  '&rating_filter=' . urlencode($rating_filter) .'"><button class="btn btn-dark mx-1" style="text-decoration: none;">' . $btn . '</button></a>';
                }

                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                } else {
                    $page = 1;
                }
                $starting_limit = ($page - 1) * $number_of_records;
                $query = "SELECT * FROM destination WHERE (name LIKE '%$search%' OR nearest_airport LIKE '%$search%')";
                if (!empty($season_filter)) {
                    $query .= " AND best_season = '$season_filter'";
                }
                if (!empty($budget_filter)) {
                    $query .= "AND average_budget BETWEEN '$starting_budget' AND '$end_budget'";
                }
                if (!empty($rating_filter)) {
                    $query .= "AND rating BETWEEN '$starting_rating' AND '$end_rating'";
                }
                $query .= " LIMIT $starting_limit, $number_of_records";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    die("Error executing query: " . mysqli_error($conn));
                }
                ?>
                <p class="lead">
                    Click on the view details to know more about the destination
                    place.
                </p>
                Want to go back? <a href="index.php">Take me home</a>
                <?php 
if(!empty($msg)){ ?>
    <p class="alert alert-info" style="font-size: 10px;">
      <?php echo $msg; ?>
    </p> 
<?php }
?>
                <?php
                if (isset($Fail)) {
                    echo '<p class="alert alert-danger"> An error occurred while deleting the image and its data. Please try again.</p>';
                }
                if (isset($success)) {
                    echo '<p class="alert alert-success"> The image and its data have been successfully deleted.</p>';
                }
                ?>


                <?php

                echo '<hr class="my-5">';
                echo '<div class="card-frame">';

                while ($row = mysqli_fetch_array($result)) {
                    $destination_id = $row['destination_id'];
                    $title = $row['name'];
                    $description = $row['description'];
                    $airport = $row['nearest_airport'];
                    $budget = $row['average_budget'];
                    $rating = $row['rating'];
                    $season = $row['best_season'];
                    $file_name = $row['file_name'];
                    echo "<div class=\"image-card col-12 col-md-4 col-lg-3\">";
                    echo "<img src=\"Thumbs/$file_name\" alt=\"$description\" class=\"img-fluid mb-4\">";
                    echo "<div class=\"text-center\">";
                    echo "<h5>$title</h5>";
                    echo "<p class=\"text-muted\">Description: $description</p>";
                    echo "<p class=\"text-muted\">Rating: $rating</p>";
                    echo "<p class=\"text-muted\">Rating: $airport</p>";
                    echo "<p class=\"text-muted\">Average Budget: $budget(K)</p>";
                    echo "<p class=\"text-muted\">Best Season: $season</p>";
                    echo '<form method="post" action="';
                    echo htmlspecialchars($_SERVER['PHP_SELF']);
                    echo '">';
                    echo "<div class=\"btn-container\">";
                    echo "<a href=\"one-time-destination.php?id=" . $row['destination_id'] . "\" class=\"btn btn-primary mt-3\">View Details</a>";
                    echo "</div>";
                    echo "<input type=\"hidden\" name=\"destination_id\" value=\"$destination_id\">";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                }

                echo '</div>';

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
    <script>
        function editDestination(destination_id) {
            window.location.href = "edit-destination-process.php?id=" + destination_id;
        }
    </script>
</body>

</html>