<?php
session_start();
require_once('/home/ajoshi7/data/connect.php');
$conn = db_connect();
if (isset($_SESSION["user"])) {
    if (isset($_SESSION["email"])) {
        $message_appointment = "";
        $email = "";
        $email = $_SESSION["email"];
    }
} else {
    header("Location:login.php");
}
$season_filter = isset($_POST['season_filter']) ? $_POST['season_filter'] : (isset($_GET['season_filter']) ? $_GET['season_filter'] : "");
$budget_filter = isset($_POST['budget_filter']) ? $_POST['budget_filter'] : (isset($_GET['budget_filter']) ? $_GET['budget_filter'] : "");
$rating_filter = isset($_POST['rating_filter']) ? $_POST['rating_filter'] : (isset($_GET['rating_filter']) ? $_GET['rating_filter'] : "");
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
$search = "";
if (isset($_POST['submit'])) {
    $search = isset($_POST['search']) ? trim($_POST['search']) : "";
    if (isset($_POST['clear'])) {
        $search = "";
    }
}
if (isset($_POST['delete']) && isset($_POST['destination_id'])) {
    $destination_id = $_POST['destination_id'];
    $sql_select = "SELECT file_name FROM destination WHERE destination_id = '$destination_id';";
    $result = mysqli_query($conn, $sql_select);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $file_name = $row['file_name'];

        $file_path_original = "Uploads/" . $file_name;
        $file_path_thumbnail = "Thumbs/" . $file_name;
        $file_path_medium = "Display/" . $file_name;

        if (file_exists($file_path_original)) {
            unlink($file_path_original);
        }
        if (file_exists($file_path_thumbnail)) {
            unlink($file_path_thumbnail);
        }
        if (file_exists($file_path_medium)) {
            unlink($file_path_medium);
        }
    }

    $sql_delete = "DELETE FROM destination where destination_id = '$destination_id';";
    $delete_result = mysqli_query($conn, $sql_delete);
    $affected_rows = mysqli_affected_rows($conn);

    if ($affected_rows > 0) {
        $success = "The image and its data have been successfully deleted.";
    } else {
        $Fail = "An error occurred while deleting the image and its data. Please try again.";

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./includes/styles/edit-images.css">
    <link rel="stylesheet" href="./includes/styles/footer.css">
    <title>Lab 7 : Edit Destinations</title>

</head>

<body>
    <?php
    include("./includes/header.php");



    ?>
    <main class="container">
        <section class="row justify-content-center py-2 my-3">
            <div class="col-12 col-lg-10 col-lg-8">
                <h1 class="fw-light">
                    Update or Delete Destinations
                </h1>
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

                    <div class="col-md-4 col-sm-12 d-flex align-items-center">
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
                    <div class="col-md-4 col-sm-12 d-flex align-items-center">
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
                <p class="lead">Hello
                    <?php echo $email ?>, edit or delete the existing destinations through here. You don't have to
                    fill out all details from scratch, update your desired field, hit submit and your changes will be
                    reflected very shortly.
                </p>
                Changed your mind? <a href="index.php">Take me back home</a>
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
                        $rating = $row['rating'];
                        $file_name = $row['file_name'];
                        $airport = $row['nearest_airport'];
                        $budget = $row['average_budget'];
                        $rating = $row['rating'];
                        $season = $row['best_season'];
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
                        echo "<input type=\"hidden\" name=\"destination_id\" value=\"$destination_id\">";
                        echo '<div class="buttons-container">';
                        echo "<button type=\"button\" class=\"btn btn-primary\" onclick=\"editDestination($destination_id)\">Edit</button>";
                        echo "<button type=\"submit\" name=\"delete\" class=\"btn btn-danger\">Delete</button>";
                        echo '</div>';
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