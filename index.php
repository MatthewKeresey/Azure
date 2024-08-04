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
    <title>Matthew's Azure Upload</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #0078D4;
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 200px;
        }
        .message {
            background-color: #e6f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 3px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .file-list {
            list-style-type: none;
            padding: 0;
        }
        .file-list li {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 3px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .file-list li:hover {
            background-color: #f0f0f0;
        }
        .file-actions a {
            text-decoration: none;
            color: #0078D4;
            margin-left: 10px;
        }
        .file-actions a:hover {
            text-decoration: underline;
        }
        form {
            margin-top: 20px;
        }
        input[type="file"] {
            display: block;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #0078D4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #005a9e;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo.png" alt="Matthew's Azure Upload" class="logo">
        <h1>Matthew's Azure Upload</h1>
        
        <?php if (isset($message)) echo "<div class='message'>" . htmlspecialchars($message) . "</div>"; ?>

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
                 "<span>", htmlspecialchars($file), "</span>",
                 "<div class='file-actions'>",
                 "<a href='", htmlspecialchars($upload_dir . $file), "' download>Download</a>",
                 "<a href='?delete=", htmlspecialchars($file), "'>Delete</a>",
                 "<a href='edit.php?file=", htmlspecialchars($file), "'>Edit</a>",
                 "</div>",
                 "</li>";
        }
        ?>
        </ul>
    </div>
</body>
</html>