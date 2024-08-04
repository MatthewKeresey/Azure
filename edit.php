<?php
declare(strict_types=1);

$upload_dir = "uploads/";
$file = $_GET['file'] ?? '';
$filepath = $upload_dir . $file;

if (!file_exists($filepath)) {
    die("File not found");
}

$content = file_get_contents($filepath);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newContent = $_POST['content'];
    if (file_put_contents($filepath, $newContent) !== false) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error saving file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit File - Matthew's Azure Upload</title>
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
        .edit-section {
            background-color: white;
            border-radius: 4px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        textarea {
            width: 100%;
            height: 400px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
        }
        input[type="submit"] {
            background-color: #0078d4;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #005a9e;
        }
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #0078d4;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1><img src="logo.png" alt="Logo" class="logo">Matthew's Azure Upload</h1>
        </div>
    </header>
    <div class="container">
        <div class="edit-section">
            <h2>Edit File: <?= htmlspecialchars($file) ?></h2>
            <?php if (isset($error)) echo "<p>" . htmlspecialchars($error) . "</p>"; ?>
            <form action="" method="post">
                <textarea name="content"><?= htmlspecialchars($content) ?></textarea>
                <br>
                <input type="submit" value="Save Changes">
            </form>
        </div>
        <a href="index.php" class="back-link">Back to File List</a>
    </div>
</body>
</html>