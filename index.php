<?php
require 'db.php'; // Include the database connection

// Fetch all books
$stmt = $pdo->query("SELECT * FROM books ORDER BY id DESC");
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Library</title>
    <style>
        table { border-collapse: collapse; width: 70%; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: blue; }
        a:hover { text-decoration: underline; }
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; }
        .add-book { margin: 20px auto; display: block; width: 70%; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book Library</h1>
        <a href="add.php" class="add-book">+ Add New Book</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Published Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($books): ?>
                    <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?= htmlspecialchars($book['id']) ?></td>
                        <td><?= htmlspecialchars($book['title']) ?></td>
                        <td><?= htmlspecialchars($book['author']) ?></td>
                        <td><?= htmlspecialchars($book['genre']) ?></td>
                        <td><?= htmlspecialchars($book['published_year']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $book['id'] ?>">Edit</a> | 
                            <a href="delete.php?id=<?= $book['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;">No books found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
