<?php
session_start();
if (isset($_SESSION["user"])) {
    if (isset($_SESSION["email"])) {
        $message_appointment = "";
        $email = "";
        $email = $_SESSION["email"];
    }
} else {
    header("Location:login.php");
}
$msg = !isset($msg) ? "" : $msg;
require_once('/home/ajoshi7/data/connect.php');
$conn = db_connect();
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

$form_good = null;
//message variables 
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
}
if ($form_good) {
    include('includes/img-process.php');
    if(!empty($inserted_id)){
        $title =  "";
$description =  "";
$airport =  "";
$season =  "";
$avg_time =  "";
$population =  0.0;
$budget =  0.0;
$language = "";
$altitude =  0.0;
$trek =  0.0;
$rating = 0.0;

    }
} 
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Destination</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./includes/styles/footer.css">
</head>

<body>
    <?php
    include("./includes/header.php");

    ?>
    <main>
        <div class="container">
            <h1 class="mt-3 mb-4">Add a destination by filling the form below</h1>
            <?php if ($msg != ""): ?>
                <div class="alert alert-secondary my-3" role="alert">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="my-3 mb-" method="POST"
                enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Name</label>
                    <input id="title" type="text" name="title" aria-describedby="title-help" class="form-control"
                        value="<?php echo $title; ?>">
                    <div id="title-help" class="form-text">
                        <?php echo $message_title; ?>
                    </div>
                </div>
                <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" aria-describedby="description-help" class="form-control"><?php echo $description; ?></textarea>
    <div id="description-help" class="form-text">
        <?php echo $message_description; ?>
    </div>
</div>


                <div class="mb-3">
                    <label for="airport" class="form-label">Nearest Airport</label>
                    <input id="airport" type="text" name="airport" aria-describedby="airport-help" class="form-control"
                        value="<?php echo $airport; ?>">
                    <div id="airport-help" class="form-text">
                        <?php echo $message_airport; ?>
                    </div>
                </div>


                <div class="mb-3">
            <label for="season" class="form-label">Best Season</label>
                <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="Spring" value="Spring"
            <?php echo ($season === 'Spring') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="Spring">
            Spring
        </label>
            </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="Summer" value="Summer"
            <?php echo ($season === 'Summer') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="Summer">
            Summer
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="Fall" value="Fall"
            <?php echo ($season === 'Fall') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="Fall">
            Fall
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="Winter" value="Winter"
            <?php echo ($season === 'Winter') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="Winter">
            Winter
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="season" id="All-Weather" value="All Weather"
            <?php echo ($season === 'All Weather') ? 'checked' : ''; ?>>
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
                        class="form-control" value="<?php echo $population; ?>" step="0.01">
                    <div id="population-help" class="form-text">
                        <?php echo $message_population; ?>
                    </div>
                </div>



                <div class="mb-3">
                    <label for="avg-time" class="form-label">Average Time Ex 3D/4N</label>
                    <input id="avg-time" type="text" name="avg-time" aria-describedby="avg-time-help"
                        class="form-control" value="<?php echo $avg_time; ?>">
                    <div id="avg-time-help" class="form-text">
                        <?php echo $message_avg_time; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="avg-budget" class="form-label">Average Budget in Thousands</label>
                    <input id="avg-budget" type="number" name="avg-budget" aria-describedby="avg-budget-help"
                        class="form-control" value="<?php echo $budget; ?>" step="0.01">
                    <div id="avg-budget-help" class="form-text">
                        <?php echo $message_budget; ?>
                    </div>
                </div>


                <div class="mb-3">
    <label for="language" class="form-label">Language(s) Spoken</label>
    <textarea id="language" name="language" aria-describedby="language-help" class="form-control"><?php echo $language; ?></textarea>
    <div id="language-help" class="form-text">
        <?php echo $message_language; ?>
    </div>
</div>

                <div class="mb-3">
                    <label for="altitude" class="form-label">Altitude</label>
                    <input id="altitude" type="number" name="altitude" aria-describedby="altitude-help"
                        class="form-control" value="<?php echo $altitude; ?>" step="0.01">
                    <div id="altitude-help" class="form-text">
                        <?php echo $message_altitude; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="trek" class="form-label">Hike Lenght in Killometers</label>
                    <input id="trek" type="number" name="trek" aria-describedby="trek-help" class="form-control"
                        value="<?php echo $trek; ?>" step="0.01">
                    <div id="trek-help" class="form-text">
                        <?php echo $message_trek; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating </label>
                    <input id="rating" type="number" step="0.1" name="rating" aria-describedby="rating-help"
                        class="form-control" value="<?php echo $rating; ?>">
                    <div id="rating-help" class="form-text">
                        <?php echo $message_rating; ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="img-file" class="form-label">Image File</label>
                    <input type="file" id="img-file" name="img-file" class="form-control" required>
                </div>
                <div class="mb-5">
                    <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Add">
                </div>
            </form>
        </div>
    </main>


    <?php
    include("./includes/footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>
