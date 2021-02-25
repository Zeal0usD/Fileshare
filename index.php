<?php
session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <title>File Share</title>
</head>
<body>
  <?php
	// Reporting back error messages
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }
  ?>
	<div align="center"><h1>FileShare</h1></div>
	<div align="center"> 
  <form method="POST" action="upload.php" enctype="multipart/form-data">
    <div>
      <span>Upload a File:</span>
      <input type="file" name="uploadedFile" />
    </div>

    <input type="submit" name="uploadBtn" value="Upload" />
  </form>
		<?PHP 
		// Reporting back location of upload
		if (isset($_SESSION['link']) && $_SESSION['link'])
    {
      printf('<b>%s</b>', $_SESSION['link']);
      unset($_SESSION['link']);
    }
				if (isset($_SESSION['error']) && $_SESSION['error'])
    {
      printf('<b>%s</b>', $_SESSION['error']);
      unset($_SESSION['error']);
    }
		?>
	</div>
	<div align="center">
	<li>
		<lo>- 10mb limit</lo></br>
		<lo>- Files will be deleted when disk is full eventually</lo></br>
		<lo>- If there is something on here we don't like we will delete it! </lo></br>
<lo>Allowed extensions: jpg, jpeg, gif, png, zip, txt, rar, zip</lo></br>
	</li>
		</div>
<div align="center">V0.1</div>
</body>
</html>
