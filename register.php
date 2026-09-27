<?php

session_start();
include "config/database.php";

$pesan = "";
$berhasil = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST["nama"];
    $kelas = $_POST["kelas"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    // Cek apakah email sudah terdaftar
    $cek = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $cek->bind_param("s", $email);
    $cek->execute();

    $hasil = $cek->get_result();

    if ($hasil->num_rows > 0) {

        $pesan = "Email sudah terdaftar! Silakan gunakan email lain.";

    } else {

        $sql = "INSERT INTO users (nama, kelas, email, password, role)
                VALUES (?, ?, ?, ?, 'siswa')";

        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Error: " . $conn->error);
        }

        $stmt->bind_param(
            "ssss",
            $nama,
            $kelas,
            $email,
            $password
        );

        if ($stmt->execute()) {

            $pesan = "Pendaftaran berhasil! Silakan login.";
            $berhasil = true;

        } else {

            $pesan = "Pendaftaran gagal: " . $stmt->error;

        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Daftar - FindIt School</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .logo {
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            margin-bottom: 30px;
        }

        h2 {
            text-align: center;
            color: #1f2937;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 9px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .message {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .login {
            text-align: center;
            margin-top: 25px;
            color: #6b7280;
        }

        .login a {
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 500px) {

            .register-card {
                margin: 20px;
                padding: 30px 25px;
            }

        }

    </style>

</head>

<body>

    <div class="register-card">

        <div class="logo">
            🔎 FindIt School
        </div>

        <p class="subtitle">
            Website Barang Hilang dan Ditemukan di Sekolah
        </p>

        <h2>Daftar Akun</h2>


        <?php if ($pesan != ""): ?>

            <div class="message <?= $berhasil ? 'success' : 'error' ?>">
                <?= htmlspecialchars($pesan) ?>
            </div>

        <?php endif; ?>


        <form method="POST">

            <div class="form-group">

                <label>Nama Lengkap</label>

                <input
                    type="text"
                    name="nama"
                    placeholder="Masukkan nama lengkap"
                    required
                >

            </div>


            <div class="form-group">

                <label>Kelas</label>

                <input
                    type="text"
                    name="kelas"
                    placeholder="Contoh: 8A"
                    required
                >

            </div>


            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Masukkan email"
                    required
                >

            </div>


            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <button type="submit">
                Daftar
            </button>

        </form>


        <div class="login">

            Sudah punya akun?

            <a href="login.php">
                Login
            </a>

        </div>

    </div>

</body>

</html>
