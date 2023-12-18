<?php
session_start();
require_once('/home/ajoshi7/data/connect.php');
require_once('includes/functions.php');
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
$file_name = "";
$destination_id = $_GET['id'];
$form_good = null;
$msg = !isset($msg) ? "" : $msg;
$new_file_name = "";
$message_add = "";
$message_title = "";
$message_budget = "";
$message_population = "";
$message_description = "";
$message_altitude = "";
$message_airport = "";
$message_trek = "";
$message_rating = "";
$message_season = "";
$message_avg_time = "";
$message_language = "";
$message_writer = "";
if (isset($_POST['submit'])) {
    $title = isset($_POST['title']) ? trim($_POST['title']) : "";
$description = isset($_POST['description']) ? trim($_POST['description']) : "";
$airport = isset($_POST['airport']) ? trim($_POST['airport']) : "";
$season = isset($_POST['season']) ? trim($_POST['season']) : "";
$avg_time = isset($_POST['avg-time']) ? trim($_POST['avg-time']) : "";
$population = isset($_POST['population']) ? (float) $_POST['population'] : 0.0;
$budget = isset($_POST['avg-budget']) ? (float) $_POST['avg-budget'] : 0.0;
$language = isset($_POST['language']) ? trim($_POST['language']) : "";
$altitude = isset($_POST['altitude']) ? (float) $_POST['altitude'] : 0.0;
$trek = isset($_POST['trek']) ? (float) $_POST['trek'] : 0.0;
$rating = isset($_POST['rating']) ? (float) $_POST['rating'] : 0.0;
    $img_title = isset($_POST['img-title']) ? $_POST['img-title'] : "";
    $form_good = true;
    //validate name
    if (empty($title)) {
        $message_title = "<p>Destination Name is required </p>";
        $form_good = false;
    } else {
        $title = filter_var($title, FILTER_SANITIZE_STRING);
    }
    //validate description
    if (empty($description)) {
        $message_description = "<p>Description is required </p>";
        $form_good = false;
    } else {
        $description = filter_var($description, FILTER_SANITIZE_STRING);
    }



    //validate airport
    if (empty($airport)) {
        $message_airport = "<p>Nearest Airport is required </p>";
        $form_good = false;
    } else {
        $airport = filter_var($airport, FILTER_SANITIZE_STRING);
    }


    //validate season 
    if (empty($season)) {
        $message_season = "<p>Season is required </p>";
        $form_good = false;
    } else {
        $season = filter_var($season, FILTER_SANITIZE_STRING);
    }

    //Validate population 
    if (empty($population)) {
        $message_population = "<p> Population is required </p>";
        $form_good = false;
    } else {
        $population = filter_var($population, FILTER_VALIDATE_FLOAT);
        if ($population < 0) {
            $message_population = "<p> Population  cannot be less than 0 </p>";
            $form_good = false;
        }
    }

    //validate avg-time 
    if (empty($avg_time)) {
        $message_avg_time = "<p>Average time is required </p>";
        $form_good = false;
    } else {
        $avg_time = filter_var($avg_time, FILTER_SANITIZE_STRING);
    }

    //validate average_budget 
    if (empty($budget)) {
        $message_budget = "<p> Average Budget is required </p>";
        $form_good = false;
    } else {
        $budget = filter_var($budget, FILTER_VALIDATE_FLOAT);
        if ($budget < 0) {
            $message_budget = "<p>Average Budget  cannot be less than 0 </p>";
            $form_good = false;
        }
    }
    //validate language
    if (empty($language)) {
        $message_language = "<p>Language(s) spoken is required </p>";
        $form_good = false;
    } else {
        $language = filter_var($language, FILTER_SANITIZE_STRING);
    }
    //validate altitude 
    if (empty($altitude)) {
        $message_altitude = "<p> Altitude is required </p>";
        $form_good = false;
    } else {
        $altitude = filter_var($altitude, FILTER_VALIDATE_FLOAT);
        if ($altitude < 0) {
            $message_altitude = "<p> Altitude  cannot be less than 0 </p>";
            $form_good = false;
        }
    }
    if (!empty($trek)) {
        $trek = filter_var($trek, FILTER_VALIDATE_FLOAT);
        if ($trek < 0) {
            $message_trek = "<p> Hike length  cannot be less than 0 </p>";
            $form_good = false;
        }
    }
    //validate rating 
    if (!empty($rating)) {
        //I have set the rating to allow null in the database
        if (!filter_var($rating, FILTER_VALIDATE_FLOAT, array("options" => array("min_range" => 0, "max_range" => 5)))) {
            $message_rating = "<p>Invalid Rating, must be between 0 to 5</p>";
            $form_good = false;
        } else {
            $rating = filter_var($rating, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        }
    }

    if (isset($_FILES["img-file"]["name"]) && !empty($_FILES["img-file"]["name"])) {
        $filename = $_FILES["img-file"]["name"];
        $tempname = $_FILES["img-file"]["tmp_name"];
        $filepath = "Uploads/" . $filename;
        //These are the three directories that we will be writing too
        $original_folder = "Uploads/";
        $thumbs_folder = "Thumbs/";
        $display_folder = "Display/";
        //let check to see what type of file the user uploaded
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        $types_allowed = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        if (in_array($filetype, $types_allowed)) {
            if (move_uploaded_file($tempname, $filepath)) {
                $this_file = $original_folder . basename($_FILES["img-file"]["name"]);
                createThumbnail($this_file, $thumbs_folder, 256);
                createThumbnail($this_file, $display_folder, 720);

                $new_file_name = $filename;
            } else {
                $msg = "There was an error uploading the file. Please make sure it is an image and does nor exceed 16MB, then try again";
                $form_good = false;
            }
        } else {
            $msg = "File type not allowed";
            $form_good = false;
        }
    } else {
        $sql = "SELECT * FROM destination where  destination_id = '$destination_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $new_file_name = $row['file_name'];
    }
}
if ($form_good) {
    $file_name_update = (isset($_FILES["img-file"]["name"]) && !empty($_FILES["img-file"]["name"])) ? ", file_name = '$filename'" : "";

    $sql_update = "UPDATE destination
    SET name = '$title', description = '$description', nearest_airport = '$airport', best_season = '$season', population = '$population', average_time = '$avg_time', average_budget = '$budget', language = '$language', altitude = '$altitude', trek_length = '$trek', rating = '$rating' $file_name_update
    WHERE destination_id = $destination_id;
    ";
    $update_result = mysqli_query($conn, $sql_update);
    if ($update_result) {
        $msg .= "<p>Image information updated successfully!</p>";
    } else {
        $error_code = $conn->errno;
        $error_message = $conn->error;
        $msg .= "Image information update failed. Error code: " . $error_code . ". Error message: " . htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') . " Please try again.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./includes/styles/footer.css">
    <title>Lab 7: Edit Destination</title>
</head>

<body>
    <?php
    include("./includes/header.php");
    $sql = "SELECT * FROM destination  where destination_id = '$destination_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $filename = $row['file_name'];
    } else {
        $filename = "";
        $msg .= "<p>Image not found.</p>";
    }
    ?>
    <main class="container">
        <section class="row justify-content-center py-3 my-2">
            <div class="col-8 col-xl-6">
                <h1 class="fw-light mb-5">Update the details for destination</h1>

                <!-- Error Message -->
                <?php if ($msg != ""): ?>
                    <div class="alert alert-secondary my-3" role="alert">
                        <?php echo $msg; ?>
                    </div>
                <?php endif; ?>

                <!-- Preview -->
                <?php if (isset($preview)): ?>
                    <div class="card text-bg-dark">
                        <?php echo $preview; ?>
                        <div class="card-img-overlay">
                            <h5 class="card-title">
                                <?php echo $img_title; ?>
                            </h5>
                            <p class="card-text"><small>
                                    <?php echo $img_description; ?>
                                </small></p>
                        </div>
                    </div>
                <?php endif; ?>


                <!-- Without the enctype attribute, we won't be able to upload any files to the server through our form inputs. -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $destination_id; ?>" method="POST"
                    enctype="multipart/form-data">
    
                <div class="mb-3">
                        <label for="img-file" class="form-label">Current Image</label>
                        <?php echo "<img src=\"Uploads/$filename\" alt=\"current image\" class=\"card-img-top\">"; ?>
                    </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Name</label>
                    <input id="title" type="text" name="title" aria-describedby="title-help" class="form-control"
                        value="<?php echo $row['name']; ?>">
                    <div id="title-help" class="form-text">
                        <?php echo $message_title; ?>
                    </div>
                </div>
                <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" aria-describedby="description-help" class="form-control"><?php echo $row['description']; ?></textarea>
    <div id="description-help" class="form-text">
        <?php echo $message_description; ?>
    </div>
</div>


                <div class="mb-3">
                    <label for="airport" class="form-label">Nearest Airport</label>
                    <input id="airport" type="text" name="airport" aria-describedby="airport-help" class="form-control"
                        value="<?php echo $row['nearest_airport']; ?>">
                    <div id="airport-help" class="form-text">
                        <?php echo $message_airport; ?>
                    </div>
                </div>


                <div class="mb-3">
    <label for="season" class="form-label">Best Season</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="Spring" value="Spring"
            <?php echo ($row['best_season'] === 'Spring') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="Spring">
            Spring
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="Summer" value="Summer"
            <?php echo ($row['best_season'] === 'Summer') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="Summer">
            Summer
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="Fall" value="Fall"
            <?php echo ($row['best_season'] === 'Fall') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="Fall">
            Fall
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="Winter" value="Winter"
            <?php echo ($row['best_season'] === 'Winter') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="Winter">
            Winter
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="All Weather" value="All Weather"
            <?php echo ($row['best_season'] === 'All Weather') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="All Weather">
            All Weather
        </label>
    </div>
    <div id="season-help" class="form-text">
        <?php echo $message_season; ?>
    </div>
</div>

                <div class="mb-3">
                    <label for="population" class="form-label">Population in Millions</label>
                    <input id="population" type="number" name="population" aria-describedby="population-help"
                        class="form-control" value="<?php echo $row['population']; ?>" step="0.01">
                    <div id="population-help" class="form-text">
                        <?php echo $message_population; ?>
                    </div>
                </div>



                <div class="mb-3">
                    <label for="avg-time" class="form-label">Average Time Ex 3D/4N</label>
                    <input id="avg-time" type="text" name="avg-time" aria-describedby="avg-time-help"
                        class="form-control" value="<?php echo $row['average_time']; ?>">
                    <div id="avg-time-help" class="form-text">
                        <?php echo $message_avg_time; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="avg-budget" class="form-label">Average Budget in Thousands</label>
                    <input id="avg-budget" type="number" name="avg-budget" aria-describedby="avg-budget-help"
                        class="form-control" value="<?php echo $row['average_budget']; ?>" step="0.01">
                    <div id="avg-budget-help" class="form-text">
                        <?php echo $message_budget; ?>
                    </div>
                </div>


                <div class="mb-3">
    <label for="language" class="form-label">Language(s) Spoken</label>
    <textarea id="language" name="language" aria-describedby="language-help" class="form-control"><?php echo $row['language']; ?></textarea>
    <div id="language-help" class="form-text">
        <?php echo $message_language; ?>
    </div>
</div>

                <div class="mb-3">
                    <label for="altitude" class="form-label">Altitude</label>
                    <input id="altitude" type="number" name="altitude" aria-describedby="altitude-help"
                        class="form-control" value="<?php echo $row['altitude']; ?>" step="0.01">
                    <div id="altitude-help" class="form-text">
                        <?php echo $message_altitude; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="trek" class="form-label">Hike Lenght in Killometers</label>
                    <input id="trek" type="number" name="trek" aria-describedby="trek-help" class="form-control"
                        value="<?php echo $row['trek_length']; ?>" step="0.01">
                    <div id="trek-help" class="form-text">
                        <?php echo $message_trek; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating </label>
                    <input id="rating" type="number" step="0.1" name="rating" aria-describedby="rating-help"
                        class="form-control" value="<?php echo $row['rating']; ?>">
                    <div id="rating-help" class="form-text">
                        <?php echo $message_rating; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="img-file" class="form-label">Image File</label>
                    <input type="file" id="img-file" name="img-file" class="form-control">
                </div>
                <div class="mb-5">
                    <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Update">
                </div>
            </form>

                <div class="my-5">
                    <a href="edit-destination.php">Go Back</a>
                </div>
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