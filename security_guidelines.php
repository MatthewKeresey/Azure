<?php
declare(strict_types=1);

$db = new SQLite3('security_guidelines.db');

// Create table if not exists
$db->exec('CREATE TABLE IF NOT EXISTS guidelines (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    framework TEXT,
    guideline TEXT
)');

// Sample data insertion (you would typically do this once, not on every page load)
$sample_data = [
    ['ITIL', 'Implement a robust incident management process'],
    ['CIS', 'Inventory and Control of Hardware Assets'],
    ['OWASP', 'Implement strong authentication and session management'],
    ['MITRE', 'Implement network segmentation and isolation']
];

$insert = $db->prepare('INSERT INTO guidelines (framework, guideline) VALUES (:framework, :guideline)');
foreach ($sample_data as $data) {
    $insert->bindValue(':framework', $data[0], SQLITE3_TEXT);
    $insert->bindValue(':guideline', $data[1], SQLITE3_TEXT);
    $insert->execute();
}

// Fetch guidelines
$results = $db->query('SELECT * FROM guidelines');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cybersecurity Guidelines - Matthew's Azure Upload</title>
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
        .guidelines-section {
            background-color: white;
            border-radius: 4px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f3f2f1;
            font-weight: bold;
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
        <div class="guidelines-section">
            <h2>Cybersecurity Guidelines</h2>
            <table>
                <tr>
                    <th>Framework</th>
                    <th>Guideline</th>
                </tr>
                <?php
                while ($row = $results->fetchArray()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['framework']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['guideline']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
</body>
</html>