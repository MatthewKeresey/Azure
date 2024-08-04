<?php
$upload_dir = "uploads/";
$file = isset($_GET['file']) ? $_GET['file'] : '';
$filepath = $upload_dir . $file;

if (!file_exists($filepath)) {
    die("File not found");
}

$content = file_get_contents($filepath);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newContent = $_POST['content'];
    file_put_contents($filepath, $newContent);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit File</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        textarea {
            width: 100%;
            height: 400px;
        }
    </style>
</head>
<body>
    <h1>Edit File: <?php echo htmlspecialchars($file); ?></h1>
    <form action="" method="post">
        <textarea name="content"><?php echo htmlspecialchars($content); ?></textarea>
        <br>
        <input type="submit" value="Save Changes">
    </form>
    <a href="index.php">Back to File List</a>
</body>
</html>