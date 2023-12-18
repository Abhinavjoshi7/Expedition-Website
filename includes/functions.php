<?php

// This function can be called multiple times to create multiple versions of the same image, just at different sizes.

/*
    PARAMETERS

    $file - path tothe image file we want to change.
    $folder - where we want to write our output.
    $new_width - the width (in pixels) we want the output to be.
*/
function createThumbnail($file, $folder, $new_width) {
    // This grabs the dimensions of the image we're working with.
    list($width, $height) = getimagesize($file);
 
    // Here, we're figuring out what the new height and width will be.
    $img_ratio = $width / $height;
    $new_height = $new_width / $img_ratio;

    $thumb = imagecreatetruecolor($new_width, $new_height);
    
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    switch($extension) {
        case 'jpg':
        case 'jpeg':
            $source = imagecreatefromjpeg($file);
            break;
        case 'png':
            $source = imagecreatefrompng($file);
            break;
        case 'gif':
            $source = imagecreatefromgif($file);
            break;
        case 'webp':
            $source = imagecreatefromwebp($file);
            break;
        default:
            return false;
    }

    // Resize the given image.
    imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

    // Define where the created image will go.
    $new_filename = $folder . basename($_FILES['img-file']['name']);

    // Every time we call this function, it will spit out a webp.
    imagewebp($thumb, $new_filename, 75);
    
    // Let's free up our memory.
    imagedestroy($thumb);
    imagedestroy($source);
}

?>