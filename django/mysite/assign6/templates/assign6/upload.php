
<!DOCTYPE html>
<html>
<body>
<?php
$attempted = 0;
$successful = 0;

if (isset($_POST["submit"])) {
  for ($i = 1; $i <= 3; $i++) {
    $f = $_FILES["file" . $i];
    if (! $f["name"]) continue;
    $attempted++;
    if (upload($f, "uploads/")) {
      $successful++;
    }
  }
}

echo "<p>Upload Summary: " . $successful . " successful out of " . $attempted . ".";

function upload($file, $target_dir) {
  $name = $file["name"];
  $target_file = $target_dir . basename($name);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "<p>Sorry, file <b>" . $target_file . "</b> already exists.";
    return false;
  }

  // Allow only image file suffixes
  if ($imageFileType != "jpg" && $imageFileType != "png") {
    echo "<p>Sorry, only JPG and PNG files are allowed, not <b>" . $name . "</b>.";
    return false;
  }

  // Verify that file is an actual image
  if (! getimagesize($file["tmp_name"])) {
    echo "<p>Sorry, file <b>" . $name . "</b> is not a readable image.";
    return false;
  }

  // Check file size
  $max = 500000;
  $bytes = $file["size"];
  if ($bytes > $max) {
    echo "<p>Sorry, file <b>" . $name . "</b> is too large (" .
         number_format($bytes) . " &gt; " . number_format($max) . ").";
    return false;
  }

  // if everything is ok, try to upload file
  if (! move_uploaded_file($file["tmp_name"], $target_file)) {
    echo "<p>Sorry, there was an error uploading <b>" . $target_file . "</b>.";
    return false;
  }

  // Success!
  echo "<p>The file <b>" . basename($name) . "</b> has been uploaded (bytes = " .
       number_format($bytes) . ").";
  return true;
}
?>
</body>
</html>

