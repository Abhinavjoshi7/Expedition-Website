<?php
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home/ajoshi7/public_html/PHPMailer-master/src/Exception.php';
require '/home/ajoshi7/public_html/PHPMailer-master/src/PHPMailer.php';
require '/home/ajoshi7/public_html/PHPMailer-master/src/SMTP.php';
session_start();
require_once('/home/ajoshi7/data/connect.php');
$conn = db_connect();
$search = "";
if (isset($_POST['submit'])) {
    $search = isset($_POST['search']) ? trim($_POST['search']) : "";
    if (isset($_POST['clear'])) {
        $search = "";
    }
}

$first_name = (isset($_POST['submit'])) ? trim($_POST['first-name']) : "";
$last_name = (isset($_POST['submit'])) ? trim($_POST['last-name']) : "";
$email = (isset($_POST['submit'])) ? trim($_POST['email']) : "";
$phone = (isset($_POST['submit'])) ? trim($_POST['phone']) : "";
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : "";
$message_first_name = "";
$message_last_name = "";
$message_email = "";
$message_phone = "";
$message_reason = "";
$form_good = null;
if (isset($_POST['submit'])) {
    $form_good = TRUE;
    if ($first_name == "") {
        $message_first_name = "<p>Please enter your first name.</p>";
        $form_good = FALSE;
    } else {
        $first_name = filter_var($first_name, FILTER_SANITIZE_STRING);
        if (strlen($first_name) < 2) {
            $message_first_name = "<p>Please enter at least 2 characters for your first name.</p>";
            $form_good = FALSE;
        } elseif (strlen($first_name) > 40) {
            $message_first_name = "<p>Your first name cannot be longer than 40 characters.</p>";
            $form_good = FALSE;
        }
    }
    if ($last_name == "") {
        $message_last_name = "<p>Please enter your last name.</p>";
        $form_good = FALSE;
    } else {
        $last_name = filter_var($last_name, FILTER_SANITIZE_STRING);
        if (strlen($last_name) < 2) {
            $message_last_name = "<p>Please enter at least 2 characters for your first name.</p>";
            $form_good = FALSE;
        } elseif (strlen($last_name) > 40) {
            $message_last_name = "<p>Your first name cannot be longer than 40 characters.</p>";
            $form_good = FALSE;
        }
    }
    if (empty($email)) {
        $message_email = "<p>Please enter your email address.</p>";
        $form_good = FALSE;
    } else {
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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
    if ($phone == "") {
        $message_phone = "<p>Please enter your phone number.</p>";
        $form_good = FALSE;
    } else {
        $phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
    }
    if ($phone == FALSE) {
        $message_phone = "<p>Please enter your phone number without letters or special characters.</p>";
        $form_good = FALSE;
    } else {
        // Let's strip out any potential extra characters the users punched in.
        $phone = str_replace('-', '', $phone);
        $phone = str_replace('+', '', $phone);
        $phone = str_replace('.', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
    }

    if (!is_numeric($phone)) {
        $message_phone = "<p>Please enter your phone number without letters or special characters.</p>";
        $form_good = FALSE;
    } else {

        if (strlen($phone) != 10) {
            $message_phone = "<p>Please enter a ten-digit Canadian phone number without the country code.</p>";
            $form_good = FALSE;
        }
    }
    if (empty($reason)) {
        $message_reason = "<p>Reason to join is required</p>";
        $form_good = false;
    } else {
        $reason = filter_var($reason, FILTER_SANITIZE_STRING);
    }
}
if($form_good){
    $body = "<h2>Hello $first_name $last_name,</h2>";
    $body .= "<p>Thank you for your interest in joining Uttarakhand Expeditions as an admin. We have received your application and it is currently under review. Please find a copy of the submitted details below:</p>";
    $body .= "<p>Name: $first_name $last_name</p>";
    $body .= "<p>Email: $email</p>";
    $body .= "<p>Contact No: $phone</p>";
    $body .= "<p>Reason to join: $reason</p>";
    $body .= "<p>We will get back to you shortly after reviewing your application. In the meantime, if you have any questions or concerns, please feel free to contact us.</p>";
    $body .= "<p>Best regards,</p>";
    $body .= "<p>The Uttarakhand Expeditions Team</p>";
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
        $mail->isSMTP(); //Send using SMTP
        $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
        $mail->SMTPAuth = true; //Enable SMTP authentication
        $mail->Username = 'write2abhij@gmail.com'; //SMTP username
        $mail->Password = 'mdrvzybnefufrdxo'; //SMTP password
        $mail->SMTPSecure = 'tls'; //Enable implicit TLS encryption
        $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('write2abhij@gmail.com', 'Uttarakhand Expeditions : Admin Application');
        $mail->addAddress($email, $first_name); //Add a recipient
        $mail->addReplyTo($email, $first_name);
        $mail->addBCC('write2abhij@gmail.com');

        //Content
        $mail->isHTML(true); //Set email format to HTML
        $mail->Subject = 'Thank you for applying ' . $first_name . ' ' . $last_name;
        $mail->Body = $body;
        $mail->send();
        $_SESSION["msg"] = "Thank you for submitting application, we will review it and reach out to you shortly";
        header("Location:index.php");
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./includes/styles/home.css">
    <link rel="stylesheet" href="./includes/styles/footer.css">
    <title>Admin Application</title>
</head>

<body>
    <?php
    include("./includes/header.php");
    require_once('/home/ajoshi7/data/connect.php');
    $conn = db_connect();
    ?>

    <section class="jumbotron">
        <h1>Uttarakhand Expeditions</h1>

    </section>

    <main class="container">
        <section class="row justify-content-center py-5 my-5">
            <div class="col-12 col-lg-10 col-lg-8">
                <h2>Join Our Team</h2>
                <p class="lead">We are looking for passionate individuals who share our love for travel and exploration. If you think you have what it takes to join our team, please fill out the form below, and we'll get in touch with you soon.</p>
                <p class="lead">We encourage you to only submit your response once, candiates who submit mulitple applications will not be selected. We don't store your information, your application will be shared with us through email, and you will get a copy of your applicaton with details.</p>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="my-3" method="POST">
                <div class="mb-3">
                        <label for="first-name" class="form-label">First Name</label>
                        <input id="first-name" type="text" name="first-name" aria-describedby="first-name-help"
                            class="form-control" value="<?php echo $first_name; ?>">
                        <div id="first-name-help" class="form-text">
                            <?php echo $message_first_name; ?>
                        </div>
                    </div>
                    <!-- Last Name  -->
                    <div class="mb-3">
                        <label for="last-name" class="form-label">Last Name</label>
                        <input id="last-name" type="text" name="last-name" aria-describedby="last-name-help"
                            class="form-control" value="<?php echo $last_name; ?>">
                        <div id="last-name-help" class="form-text">
                            <?php echo $message_last_name; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" name="email" type="text" class="form-control" aria-describedby="email-help"
                            value="<?php echo $email; ?>">
                        <div class="form-text" id="email-help">
                            <?php echo $message_email; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input id="phone" name="phone" type="tel" class="form-control" aria-describedby="phone-help"
                            value="<?php echo $phone; ?>">
                        <div class="form-text" id="phone-help">
                            <?php echo $message_phone; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Why do you want to join us?</label>
                        <textarea class="form-control" id="reason" name="reason" rows="4" aria-describedby="reason-help"><?php echo $reason; ?></textarea>
                        <div id="reason-help" class="form-text">
        <?php echo $message_reason; ?>
    </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit Application">
                    </div>
                </form>
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