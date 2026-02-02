<?php
require 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $genre = trim($_POST['genre']);
    $published_year = trim($_POST['published_year']);

    // Basic validation
    if (empty($title) || empty($author)) {
        $error = "Title and Author are required.";
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO books (title, author, genre, published_year)
             VALUES (:title, :author, :genre, :published_year)"
        );

        $stmt->execute([
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':published_year' => $published_year ?: null
        ]);

        // Redirect to index.php after successful insert
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form { width: 400px; margin: 40px auto; }
        input { width: 100%; padding: 8px; margin: 8px 0; }
        button { padding: 10px 15px; }
        .error { color: red; }
        a { text-decoration: none; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Add New Book</h2>

<form method="POST">
    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <label>Title *</label>
    <input type="text" name="title" required>

    <label>Author *</label>
    <input type="text" name="author" required>

    <label>Genre</label>
    <input type="text" name="genre">

    <label>Published Year</label>
    <input type="number" name="published_year" min="1000" max="9999">

    <button type="submit">Save Book</button>
    <br><br>
    <a href="index.php">← Back to Library</a>
</form>

</body>
</html>
