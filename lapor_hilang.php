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
    $lokasi_hilang = $_POST["lokasi_hilang"];
    $tanggal_hilang = $_POST["tanggal_hilang"];
    $foto = "";

if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {

    $folder = "uploads/";

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    $nama_foto = time() . "_" . basename($_FILES["foto"]["name"]);
    $target = $folder . $nama_foto;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target)) {
        $foto = $nama_foto;
    }
}


    $sql = "INSERT INTO barang_hilang
        (user_id, nama_barang, deskripsi, lokasi_hilang, tanggal_hilang, foto)
        VALUES (?, ?, ?, ?, ?, ?)";


    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error: " . $conn->error);
    }

$stmt->bind_param(
    "isssss",
    $user_id,
    $nama_barang,
    $deskripsi,
    $lokasi_hilang,
    $tanggal_hilang,
    $foto
);


    if ($stmt->execute()) {
        $pesan = "Laporan barang hilang berhasil disimpan!";
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

    <title>Laporkan Barang Hilang - FindIt School</title>

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
            color: #2563eb;
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
            border-color: #2563eb;
        }

        button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
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
            color: #2563eb;
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

            <h1>🔍 Laporkan Barang Hilang</h1>

            <p>
                Isi informasi barang yang kamu kehilangan
                agar dapat membantu proses pencarian.
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


            <form method="POST" enctype="multipart/form-data">


                <div class="form-group">

                    <label>Nama Barang</label>

                    <input
                        type="text"
                        name="nama_barang"
                        placeholder="Contoh: Dompet hitam"
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

                    <label>Lokasi Hilang</label>

                    <input
                        type="text"
                        name="lokasi_hilang"
                        placeholder="Contoh: Kantin sekolah"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>Tanggal Hilang</label>

                    <input
                        type="date"
                        name="tanggal_hilang"
                        required
                    >

                </div>
                <div class="form-group">

    <label>📸 Foto Barang</label>

    <input
        type="file"
        name="foto"
        accept="image/*"
    >

    <small>
        Pilih foto barang yang hilang (opsional).
    </small>

</div>



                <button type="submit">
                    Kirim Laporan
                </button>

            </form>


            <a class="bottom-link" href="barang_hilang.php">
                ← Lihat Barang Hilang
            </a>

        </div>

    </main>

</body>

</html>
