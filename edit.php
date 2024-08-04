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
        textarea {
            width: 100%;
            height: 400px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 10px;
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
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #0078D4;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="logo.png" alt="Matthew's Azure Upload" class="logo">
        <h1>Edit File: <?= htmlspecialchars($file) ?></h1>
        <?php if (isset($error)) echo "<p>" . htmlspecialchars($error) . "</p>"; ?>
        <form action="" method="post">
            <textarea name="content"><?= htmlspecialchars($content) ?></textarea>
            <br>
            <input type="submit" value="Save Changes">
        </form>
        <a href="index.php" class="back-link">Back to File List</a>
    </div>
</body>
</html>