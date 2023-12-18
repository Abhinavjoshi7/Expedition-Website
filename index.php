<?php
session_start();
$search = "";
if (isset($_POST['submit'])) {
    $search = isset($_POST['search']) ? trim($_POST['search']) : "";
    if (isset($_POST['clear'])) {
        $search = "";
    }
    
}
$msg = "";
    if(isset($_SESSION['msg'])){
        $msg = $_SESSION["msg"];
        unset($_SESSION["msg"]);
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
    <title>Uttarakhand Expeditions</title>
</head>

<body>
    <?php
    include("./includes/header.php");
    require_once('/home/ajoshi7/data/connect.php');
    $conn = db_connect();

    ?>

    <section class="jumbotron">
        <h1>Uttarakhand Expeditions</h1>
        <p>Welcome to my website showcasing all the amazing travel destinations in Uttarakhand! I am an international
            student, and I was born and raised in the province of Uttarakhand. My goal is to inspire and inform
            travelers
            so that they can make the most out of their visit to this beautiful region of India.</p>
<?php 
if(!empty($msg)){ ?>
    <p class="alert alert-info" style="font-size: 20px;">
      <?php echo $msg; ?>
    </p> 
<?php }
?>
    </section>

    <main class="container">
        <section class="info">
            <h2>About the Project</h2>
            <p>Uttarakhand Expeditions provides essential information for each location, making trip-planning easy and
                efficient. Our comprehensive guide covers everything from nearby airports, the best time to visit,
                captivating images, and enticing descriptions.</p>
            <p>Our website caters to nature lovers, adventurers, and culture travelers alike. High-quality images and
                detailed information come together to help you plan your dream Uttarakhand trip.</p>
            <p>With search functionality, you can find destinations by title or airport to suit your needs. Filter by
                rating, budget, or season to ensure a tailored experience. Admins can edit, add, or delete content,
                while users can browse through the rich imagery and information available.</p>
                
            <p>Embark on the index page for an introductory glance, and if curiosity stirs, let <a href="destination.php">"view details"</a>  enhance.
                Embrace the beauty of Uttarakhand, and let your journey commence, for with Uttarakhand Expeditions, your
                adventure shall make sense.</p>
                <p>Want to be an admin, apply here <a href="join-us.php">Apply</a></p>
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