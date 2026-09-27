<?php

session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user_id = $_SESSION["user_id"];
    $nama_barang = $_POST["nama_barang"];
    $deskripsi = $_POST["deskripsi"];
    $lokasi_ditemukan = $_POST["lokasi_ditemukan"];
    $tanggal_ditemukan = $_POST["tanggal_ditemukan"];

    $sql = "INSERT INTO barang_ditemukan
            (user_id, nama_barang, deskripsi, lokasi_ditemukan, tanggal_ditemukan)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    $stmt->bind_param(
        "issss",
        $user_id,
        $nama_barang,
        $deskripsi,
        $lokasi_ditemukan,
        $tanggal_ditemukan
    );

    if ($stmt->execute()) {
        $pesan = "Laporan barang ditemukan berhasil disimpan!";
    } else {
        $pesan = "Laporan gagal: " . $stmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Laporkan Barang Ditemukan - FindIt School</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1f2937;
        }

        .navbar {
            background: #16a34a;
            color: white;
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .back {
            color: white;
            text-decoration: none;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
        }

        .form-card h1 {
            color: #16a34a;
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #16a34a;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #16a34a;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #15803d;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .bottom-link {
            display: inline-block;
            margin-top: 20px;
            color: #16a34a;
            text-decoration: none;
        }

        @media (max-width: 600px) {

            .navbar {
                padding: 15px 20px;
            }

            .form-card {
                padding: 25px;
            }

        }

    </style>

</head>

<body>

    <nav class="navbar">

        <div class="logo">
            🔎 FindIt School
        </div>

        <a class="back" href="dashboard.php">
            ← Dashboard
        </a>

    </nav>


    <main class="container">

        <div class="form-card">

            <h1>📦 Laporkan Barang Ditemukan</h1>

            <p>
                Menemukan barang di sekolah?
                Isi informasi berikut agar pemiliknya
                dapat menemukan barang tersebut.
            </p>


            <?php if ($pesan != ""): ?>

                <?php if (strpos($pesan, "berhasil") !== false): ?>

                    <div class="success">
                        <?= htmlspecialchars($pesan) ?>
                    </div>

                <?php else: ?>

                    <div class="error">
                        <?= htmlspecialchars($pesan) ?>
                    </div>

                <?php endif; ?>

            <?php endif; ?>


            <form method="POST">

                <div class="form-group">

                    <label>Nama Barang</label>

                    <input
                        type="text"
                        name="nama_barang"
                        placeholder="Contoh: Kotak pensil biru"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Deskripsi Barang</label>

                    <textarea
                        name="deskripsi"
                        placeholder="Jelaskan ciri-ciri barang..."
                        required
                    ></textarea>

                </div>


                <div class="form-group">

                    <label>Lokasi Ditemukan</label>

                    <input
                        type="text"
                        name="lokasi_ditemukan"
                        placeholder="Contoh: Perpustakaan"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Tanggal Ditemukan</label>

                    <input
                        type="date"
                        name="tanggal_ditemukan"
                        required
                    >

                </div>


                <button type="submit">
                    Kirim Laporan
                </button>

            </form>


            <a class="bottom-link" href="barang_ditemukan.php">
                ← Lihat Barang Ditemukan
            </a>

        </div>

    </main>

</body>

</html>
