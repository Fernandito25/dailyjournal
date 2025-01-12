
<?php
//memulai session atau melanjutkan session yang sudah ada
session_start();

//menyertakan code dari file koneksi
include "koneksi.php";

//check jika sudah ada user yang login arahkan ke halaman admin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $stmt = $conn->prepare("SELECT username FROM user WHERE username=? AND password=?");
  $stmt->bind_param("ss", $username,$password);
  $stmt->execute();
  $hasil = $stmt->get_result();
  $row = $hasil->fetch_array(MYSQLI_ASSOC);

  if (!empty($row) && $row['username'] == 'admin') {
      $_SESSION['username'] = $row['username'];
      header("location:admin.php");
    } elseif (!empty($row)) {
      $_SESSION['username'] = $row['username'];
      header("location:index.php");
    } else {
      header("location:login.php");
    }

  $stmt->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h2 class="text-center">Login</h2>
                <?php if (isset($error_message)): ?>
            <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Login</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

?>

