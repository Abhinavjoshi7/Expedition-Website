<?php

session_start();
if (isset($_SESSION["user"])) {
    header("Location: index.php");
}
$email = (isset($_POST['submit'])) ? trim($_POST['email']) : "";
$password = (isset($_POST['submit'])) ? trim($_POST['password']) : "";
// Message Variables
$message_email = "";
$message_password = "";
$message_pass = "";
$form_good = null;
if (isset($_POST['submit'])) {
    require_once('/home/ajoshi7/data/connect.php');
    $conn = db_connect();
    $form_good = TRUE;

    // EMAIL VALIDATION
    if ($email == "") {
        $message_email = "<p>Please enter your email address.</p>";
        $form_good = FALSE;
    } else {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }
    if ($email == FALSE) {
        $message_email = "<p>Please enter a valid email address.</p>";
        $form_good = FALSE;
    } else {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    if ($email == FALSE) {
        $message_email = "<p>Please enter a valid email address, including an @ and a top-level domain.</p>";
        $form_good = FALSE;
    } else {

        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";

        if (preg_match($pattern, $email) == false) {
            $message_email = "<p>Please enter a valid email address, including an @ and a top-level domain.</p>";
            $form_good = FALSE;
        }
    }
    


}

if ($form_good == TRUE) {
    $sql_verify = "SELECT * FROM catalog_admin WHERE email = '$email'";
    $result = mysqli_query($conn, $sql_verify);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($user) {
        if (password_verify($password, $user["password"])) {
            $_SESSION["user"] = "yes";
            $_SESSION["email"] = $user["email"];
            header("Location:index.php");
        } else {
            $message_password = "<p>Your password does not match </p>";
            $form_good = FALSE;
        }
    } else {
        $message_email = "<p>Email Does not exists</p>";
        $form_good = FALSE;
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
<link rel="stylesheet" href="./includes/styles/login.css">
    <title>Uttarakhand Expeditions : Login</title>
  </head>

<body>

<?php
    include("./includes/header.php")
    ?>

<main class="container d-flex flex-wrap justify-content-center align-items-center min-vh-100 p-3">
    <section class="row w-100">
        <div class="col-12 col-md-6 col-lg-5 mx-auto bg-white rounded p-5 border login-form">
            <h1 class="fw-dark">Login</h1>
            <p>Please Login/Register</p>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="my-3" method="POST">

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" name="email" type="text" class="form-control" aria-describedby="email-help"
                        value="<?php echo $email; ?>">
                    <div class="form-text" id="email-help">
                        <?php echo $message_email; ?>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" name="password" type="password" class="form-control"
                        aria-describedby="password-help">
                    <div class="form-text" id="password-help">
                        <?php echo $message_password; ?>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="row submit-button-row">
                    <div class="col-12 col-sm-6">
                        <input type="submit" name="submit" class="btn btn-primary w-100 mb-2" value="Login">
                    </div>
                
                </div>
            </form>

            <?php if ($form_good == true): ?>
                <div class="alert alert-primary my-4" role="alert">
                    <?php echo $message_pass; ?>
                </div>
            <?php endif ?>
        </div>
    </section>
</main>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

</body>

</html>