<?php include('db.php'); ?>

<?php
// Insert
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    $conn->query($sql);
    header('Location: index.php');
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header('Location: index.php');
}

// Fetch for Update
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $row = $result->fetch_assoc();
}

// Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
    <h2 class="text-center">CRUD App</h2>

    <!-- Form -->
    <form action="index.php" method="POST" class="mb-4">
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" name="name" class="form-control" value="<?= isset($row) ? $row['name'] : '' ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="<?= isset($row) ? $row['email'] : '' ?>" required>
        </div>
        <input type="hidden" name="id" value="<?= isset($row) ? $row['id'] : '' ?>">
        <button type="submit" name="<?= isset($row) ? 'update' : 'save' ?>" class="btn btn-primary">
            <?= isset($row) ? 'Update' : 'Save' ?>
        </button>
    </form>

    <!-- Users Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM users");
        while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td>
                    <a href="index.php?edit=<?= $row['id'] ?>" class="btn btn-info btn-sm">Edit</a>
                    <a href="index.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Javascript for alert/validation -->
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            let name = document.querySelector('input[name="name"]').value;
            let email = document.querySelector('input[name="email"]').value;
            if (!name || !email) {
                e.preventDefault();
                alert("Please fill in all fields.");
            }
        });
    </script>
</body>
</html>
