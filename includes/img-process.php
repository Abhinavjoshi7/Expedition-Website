<?php 
if (isset($_SESSION["user"])) {
    if (isset($_SESSION["email"])) {
      $message_appointment = "";
      $email = "";
      $email = $_SESSION["email"];
    }
  }
  else{
    header("Location:login.php");
  }
if(isset($_POST['submit']) && !empty($_FILES["img-file"]["name"])){
    include('includes/functions.php');
    $filename = $_FILES["img-file"]["name"];
    $tempname = $_FILES["img-file"]["tmp_name"];
    $filepath = "Uploads/" . $filename;
    //These are the three directories that we will be writing too 
    $original_folder = "Uploads/";  
    $thumbs_folder ="Thumbs/";
    $display_folder = "Display/";
    //let check to see what type of file the user uploaded
    $filetype = pathinfo($filename, PATHINFO_EXTENSION);
    $types_allowed = array('jpg', 'jpeg','png', 'gif','webp');
    if(in_array($filetype,$types_allowed)){
        if(move_uploaded_file($tempname, $filepath)){
            $this_file = $original_folder . basename($_FILES["img-file"]["name"]);
            createThumbnail($this_file, $thumbs_folder, 256);
            createThumbnail($this_file, $display_folder, 720);
            
            $insert = $conn->query("INSERT INTO destination (name, description, nearest_airport, best_season, population, average_time, average_budget, language, altitude, trek_length, rating, file_name) VALUES ('$title','$description', '$airport', '$season',  '$population', '$avg_time',  '$budget', '$language', '$altitude', '$trek', '$rating', '$filename');");
            if($insert){
                $inserted_id = $conn->insert_id;
                $_SESSION["msg"] = "The file ". $filename . " has been successfully uploaded";
                $_SESSION["msg"] .= ". The destination id is " . $inserted_id;
                $preview = "<img src=\"$filepath\" alt=\"$filename\">";
                header("Location:destination.php");

            }
            else{
                $error_code = $conn->errno;
                $error_message = $conn->error;
                $msg = "File upload failed. Error code: " . $error_code . ". Error message: " . htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') . " Please try again.";
            }
        }
        else{
            $msg = "There was an error uploading the file. Please make sure it is an image and does nor exceed 16MB, then try again";
        }
    }
    else{
        $msg = "File type not allowed";
    }


}
else {
    $msg = "Please fill out all fields and choose an image file to upload";
}
?>