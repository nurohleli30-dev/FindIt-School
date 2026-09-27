<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$nama = $_SESSION["nama"];

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard - FindIt School</title>

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

        .logout {
            color: white;
            text-decoration: none;
            background: #dc2626;
            padding: 9px 15px;
            border-radius: 8px;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            background: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .welcome h1 {
            margin-top: 0;
            color: #2563eb;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-decoration: none;
            color: #1f2937;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .icon {
            font-size: 40px;
        }

        .card h2 {
            margin-bottom: 8px;
            color: #2563eb;
        }

        .card p {
            color: #6b7280;
        }

        @media (max-width: 600px) {

            .navbar {
                padding: 15px 20px;
            }

            .container {
                margin-top: 25px;
            }

            .menu {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>

<body>

    <nav class="navbar">

        <div class="logo">
            🔎 FindIt School
        </div>

        <a class="logout" href="logout.php">
            Logout
        </a>

    </nav>


    <main class="container">

        <section class="welcome">

            <h1>
                Halo, <?= htmlspecialchars($nama) ?>! 👋
            </h1>

            <p>
                Selamat datang di FindIt School.
                Temukan kembali barang yang hilang
                atau laporkan barang yang kamu temukan.
            </p>

        </section>


        <section class="menu">

            <a class="card" href="barang_hilang.php">

                <div class="icon">🔍</div>

                <h2>Barang Hilang</h2>

                <p>
                    Lihat daftar barang yang sedang dicari
                    oleh siswa.
                </p>

            </a>


            <a class="card" href="barang_ditemukan.php">

                <div class="icon">📦</div>

                <h2>Barang Ditemukan</h2>

                <p>
                    Lihat barang yang telah ditemukan
                    di lingkungan sekolah.
                </p>

            </a>


            <a class="card" href="lapor_hilang.php">

                <div class="icon">➕</div>

                <h2>Laporkan Barang Hilang</h2>

                <p>
                    Kehilangan barang?
                    Buat laporan di sini.
                </p>

            </a>


            <a class="card" href="lapor_ditemukan.php">

                <div class="icon">📢</div>

                <h2>Laporkan Barang Ditemukan</h2>

                <p>
                    Menemukan barang?
                    Laporkan agar pemiliknya dapat ditemukan.
                </p>

            </a>

        </section>

    </main>

</body>

</html>
