<?php
require 'db.php'; 

if (!isset($_GET['id'])) {
    die('Book ID not provided.'); 
}

$id = (int) $_GET['id']; 

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = :id"); 
$stmt->execute([':id' => $id]); 
$book = $stmt->fetch(); 

if (!$book) {
    die('Book not found.'); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $genre = trim($_POST['genre']);
    $published_year = trim($_POST['published_year']);

    if (empty($title) || empty($author)) {
        $error = "Title and Author are required."; 
    }

    else {
        $update = $pdo->prepare(
            "UPDATE books
             SET title = :title, 
                 author = :author, 
                 genre = :genre, 
                 published_year = :published_year
             WHERE id = :id"
        );

        $update->execute([
            ':title' => $title,
            ':author' => $author,
            ':genre' => $genre,
            ':published_year' => $published_year ?: null,
            ':id' => $id
        ]);

        header("Location: index.php"); 
        exit; 
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
    <style>
        body { font-family: Arial, sans-serif; }
        form { width: 400px; margin: 40px auto; }
        input { width: 100%; padding: 8px; margin: 8px 0; }
        button { padding: 10px 15px; }
        .error { color: red; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Edit Book</h2>

<form method="POST">
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <label>Title *</label>
    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required>

    <label>Author *</label>
    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required>

    <label>Genre</label>
    <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>">

    <label>Published Year</label>
    <input type="number" name="published_year"
           value="<?= htmlspecialchars($book['published_year']) ?>"
           min="1000" max="9999">

    <button type="submit">Update Book</button>
    <br><br>
    <a href="index.php">← Cancel</a>
</form>

</body>
</html>