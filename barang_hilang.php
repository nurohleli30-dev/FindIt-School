<?php

session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$keyword = "";

if (isset($_GET["keyword"])) {
    $keyword = trim($_GET["keyword"]);
}

if ($keyword != "") {

    $sql = "SELECT * FROM barang_hilang
            WHERE nama_barang LIKE ?
            OR deskripsi LIKE ?
            OR lokasi_hilang LIKE ?
            ORDER BY created_at DESC";

    $stmt = $conn->prepare($sql);

    $cari = "%" . $keyword . "%";

    $stmt->bind_param(
        "sss",
        $cari,
        $cari,
        $cari
    );

    $stmt->execute();

    $result = $stmt->get_result();

} else {

    $sql = "SELECT * FROM barang_hilang
            ORDER BY created_at DESC";

    $result = $conn->query($sql);
}


?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Barang Hilang - FindIt School</title>

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
            background: #2563eb;
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
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            background: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .header h1 {
            margin-top: 0;
            color: #2563eb;
        }

        .button {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .barang {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .barang h2 {
            color: #2563eb;
            margin-top: 0;
        }

        .info {
            margin: 8px 0;
        }

        .status {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .kosong {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }

        @media (max-width: 600px) {

            .navbar {
                padding: 15px 20px;
            }

            .container {
                margin-top: 25px;
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

        <section class="header">

            <h1>🔍 Barang Hilang</h1>

            <p>
                Daftar barang yang sedang dicari
                oleh siswa FindIt School.
            </p>

            <a class="button" href="lapor_hilang.php">
                + Laporkan Barang Hilang
            </a>
            <form method="GET" style="margin-top: 20px;">

    <input
        type="text"
        name="keyword"
        value="<?= htmlspecialchars($keyword) ?>"
        placeholder="🔎 Cari nama barang, lokasi, atau deskripsi..."
        style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px;"
    >

    <button
        type="submit"
        style="margin-top: 10px; padding: 11px 18px; background: #2563eb; color: white; border: none; border-radius: 8px; cursor: pointer;"
    >
        Cari Barang
    </button>

</form>


        </section>


        <?php if ($result->num_rows > 0): ?>

            <?php while ($barang = $result->fetch_assoc()): ?>

                <article class="barang">

                    <h2>
                        <?= htmlspecialchars($barang["nama_barang"]) ?>
                    </h2>

                    <p class="info">
                        <strong>Deskripsi:</strong><br>
                        <?= htmlspecialchars($barang["deskripsi"]) ?>
                    </p>

                    <p class="info">
                        <strong>📍 Lokasi hilang:</strong>
                        <?= htmlspecialchars($barang["lokasi_hilang"]) ?>
                    </p>

                    <p class="info">
                        <strong>📅 Tanggal hilang:</strong>
                        <?= htmlspecialchars($barang["tanggal_hilang"]) ?>
                    </p>

                    <p>
                        <span class="status">
                            <?= htmlspecialchars($barang["status"]) ?>
                        </span>
                    </p>

                </article>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="kosong">

                <h2>Belum ada barang hilang</h2>

                <p>
                    Saat ini belum ada laporan barang hilang.
                </p>

            </div>

        <?php endif; ?>

    </main>

</body>

</html>
