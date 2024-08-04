<?php
declare(strict_types=1);

session_start();
$upload_dir = "uploads/";

// Handle file upload
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["fileToUpload"])) {
    $target_file = $upload_dir . basename($_FILES["fileToUpload"]["name"]);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "File uploaded successfully.";
    } else {
        $message = "Sorry, there was an error uploading your file.";
    }
}

// Handle file deletion
if (isset($_GET['delete'])) {
    $file = $upload_dir . $_GET['delete'];
    if (file_exists($file) && unlink($file)) {
        $message = "File deleted successfully.";
    } else {
        $message = "Error deleting file.";
    }
}

// Handle file edit (this is a simple text edit functionality)
if (isset($_POST['edit'])) {
    $file = $upload_dir . $_POST['filename'];
    $content = $_POST['content'];
    if (file_put_contents($file, $content) !== false) {
        $message = "File edited successfully.";
    } else {
        $message = "Error editing file.";
    }
}

function getFileList(string $dir): array {
    $files = scandir($dir) ?: [];
    return array_filter($files, fn($file) => $file !== '.' && $file !== '..');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple File Server</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .file-list {
            list-style-type: none;
            padding: 0;
        }
        .file-list li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Simple File Server</h1>
    
    <?php if (isset($message)) echo "<p>" . htmlspecialchars($message) . "</p>"; ?>

    <h2>Upload File</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload File" name="submit">
    </form>

    <h2>File List</h2>
    <ul class="file-list">
    <?php
    $files = getFileList($upload_dir);
    foreach ($files as $file) {
        echo "<li>",
             htmlspecialchars($file), 
             " <a href='", htmlspecialchars($upload_dir . $file), "' download>Download</a>",
             " <a href='?delete=", htmlspecialchars($file), "'>Delete</a>",
             " <a href='edit.php?file=", htmlspecialchars($file), "'>Edit</a>",
             "</li>";
    }
    ?>
    </ul>
</body>
</html>