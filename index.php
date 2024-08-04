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
            margin: 0;
            padding: 0;
            background-color: #f3f2f1;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background-color: #0078d4;
            color: white;
            padding: 10px 0;
        }
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        h1 {
            margin: 0;
            font-size: 24px;
        }
        .logo {
            height: 30px;
            margin-right: 10px;
        }
        .message {
            background-color: #e6f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 3px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .upload-section {
            background-color: white;
            border-radius: 4px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .file-list {
            list-style-type: none;
            padding: 0;
            background-color: white;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        .file-list li {
            padding: 15px 20px;
            border-bottom: 1px solid #f3f2f1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .file-list li:last-child {
            border-bottom: none;
        }
        .file-list li:hover {
            background-color: #f9f9f9;
        }
        .file-actions a {
            text-decoration: none;
            color: #0078d4;
            margin-left: 15px;
        }
        .file-actions a:hover {
            text-decoration: underline;
        }
        form {
            display: flex;
            align-items: center;
        }
        input[type="file"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #0078d4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
        }
        input[type="submit"]:hover {
            background-color: #005a9e;
        }
        .nav-link {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }
        .nav-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1><img src="logo.png" alt="Logo" class="logo">Matthew's Azure Upload</h1>
            <nav>
                <a href="index.php" class="nav-link">File Upload</a>
                <a href="security_guidelines.php" class="nav-link">Security Guidelines</a>
            </nav>
        </div>
    </header>
    <div class="container">
        <?php if (isset($message)) echo "<div class='message'>" . htmlspecialchars($message) . "</div>"; ?>

        <div class="upload-section">
            <h2>Upload File</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" value="Upload" name="submit">
            </form>
        </div>

        <h2>Files</h2>
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