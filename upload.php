<?php
// FileShare
// Upload.php
//
//Start PHP session
session_start();
//
// Include mysqli connection
include("db.php");
//
// Define variables
$rnddir = NULL;
$newFileName = NULL;
$fileSize = NULL;
$fileType = NULL;
// Starting error message reporting
$message = '';
// File upload POST function
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload')
{
  if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK)
  {
    // Convert file details into variables
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
	 // Random generator for folder generation
	$rnddir = rand(1000000, 10000000000000000);
    // sanitize file-name
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
	$maxsize = "10000000";
    // check if file has one of the following extensions
    $allowedfileExtensions = array('jpg', 'jpeg' , 'gif', 'png', 'zip', 'txt', 'rar', 'zip');
	  // File size check
if(($_FILES['uploadedFile']['size'] >= $maxsize) || ($_FILES['uploadedFile']['size'] == 0))
{
header("location: error.php");
}
	else
	echo("File size is good</br>");
	
    if (in_array($fileExtension, $allowedfileExtensions))
    {
	// Create rnddir folder variables
		$root = $_SERVER["DOCUMENT_ROOT"];
		$dir = $root . "/$rnddir/";
// if folder does not exist create
if( !file_exists($dir) ) {
    mkdir($dir, 0755, true);
}else{
	header("location: error.php");
}
      // directory in which the uploaded file will be moved
      $uploadFileDir = "./$rnddir/";
      $dest_path = $uploadFileDir . $newFileName;

      if(move_uploaded_file($fileTmpPath, $dest_path)) 
      {
        $message ='File is successfully uploaded.';
      }
      else 
      {
        $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
      }
	  }
      else
      {
      $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
      }
      }
      else
      {
      $message = 'There is some error in the file upload. Please check the following error.<br>';
      $message .= 'Error:' . $_FILES['uploadedFile']['error'];
      }
}
// If statement to select error message posting result back to index
$_SESSION['message'] = $message;
//
// Create blank index to protect directory
$file = fopen("/var/www/html/$rnddir/index.html", "w") or die("can't open file");
fclose($file);
//
// Post Permlink back in index via session
$link = "Your direct link to the uploaded file <a href='/$rnddir/$newFileName'>'/$rnddir/$newFileName'</a>";
$_SESSION['link'] = $link;
// Redirect back to index
//
// Form Processing to MySQL
//
$sql = "INSERT INTO uploads (file, folder, size, type)
VALUES ('$newFileName', '$rnddir', '$fileSize', '$fileType')";

if ($conn->query($sql) === TRUE) {
  echo "Upload Sucessful";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
// Redirect back to index
header("Location: index.php");
