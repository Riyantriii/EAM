<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require_once '../src/db.php';

// Ambil log aktivitas terbaru dari database
$stmtLog = $pdo->query("SELECT * FROM log_aktivitas ORDER BY tanggal DESC LIMIT 10");
$activities = $stmtLog->fetchAll();

// Ambil jumlah aset dari database
$stmt = $pdo->query("SELECT COUNT(*) FROM aset");
$total_aset = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
body {
            background: #f4f7fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: #3b5998;
            color: #fff;
            padding: 16px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar .logo {
            font-size: 1.3em;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .navbar .user {
            font-size: 1em;
        }
        .dashboard-container {
            max-width: 1100px;
            margin: 32px auto;
            padding: 0 16px;
        }
        .cards {
            display: flex;
            gap: 24px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }
        .card {
            flex: 1 1 220px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(44,62,80,0.07);
            padding: 24px 20px;
            min-width: 200px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            position: relative;
        }
        .card .icon {
            font-size: 2em;
            margin-bottom: 10px;
            opacity: 0.3;
        }
        .card.teal { border-left: 6px solid #1abc9c; }
        .card.red { border-left: 6px solid #e74c3c; }
        .card.orange { border-left: 6px solid #f39c12; }
        .card.purple { border-left: 6px solid #6c5ce7; }
        .card .value {
            font-size: 2em;
            font-weight: bold;
            color: #222;
        }
        .card .label {
            color: #888;
            font-size: 1em;
            margin-bottom: 8px;
        }
        .card .more {
            margin-top: auto;
            font-size: 0.95em;
            color: #3b5998;
            text-decoration: none;
            font-weight: 500;
        }
        .section-title {
            font-size: 1.2em;
            color: #3b5998;
            margin-bottom: 12px;
            font-weight: 600;
        }
        .activity-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(44,62,80,0.07);
        }
        .activity-table th, .activity-table td {
            padding: 12px 10px;
            text-align: left;
        }
        .activity-table th {
            background: #f4f7fa;
            color: #3b5998;
            font-weight: 600;
        }
        .activity-table tr:not(:last-child) {
            border-bottom: 1px solid #eee;
        }
        .nav-links {
            margin-top: 24px;
            text-align: right;
        }
        .nav-links a {
            display: inline-block;
            margin-left: 12px;
            padding: 8px 18px;
            background: #3b5998;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background 0.2s;
        }
        .nav-links a:hover {
            background: #1abc9c;
        }
        @media (max-width: 900px) {
            .cards { flex-direction: column; gap: 16px; }
        }
        @media (max-width: 600px) {
            .dashboard-container { padding: 0 4px; }
            .navbar { flex-direction: column; align-items: flex-start; gap: 8px; }
        }
    </style>
</head>
<body>
<div class="navbar">
        <div class="logo">EAM UNY</div>
        <div class="user">👤 <?php echo htmlspecialchars($_SESSION['user']['username']); ?></div>
    </div>
    <div class="dashboard-container">
        <div class="section-title">Dashboard</div>
        <div class="cards">
            <div class="card teal">
                <div class="icon">📦</div>
                <div class="value">
                    <?php echo $total_aset; ?>
                </div>
                <div class="label">Total Aset</div>
                <a href="aset_list.php" class="more">More Info &rarr;</a>
            </div>
<div class="card purple">
    <div class="icon">
        <!-- SVG ICON -->
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
        </svg>
    </div>
    <div class="label">Maintenance</div>
    <a href="maintenance.php" class="more">Lihat Info Perawatan &rarr;</a>
</div>
        </div>
<div class="section-title">Aktivitas Terbaru</div>
        <table class="activity-table">
            <tr>
                <th>Tanggal</th>
                <th>Admin</th>
                <th>Aksi</th>
                <th>Item</th>
            </tr>
            <?php if (count($activities) > 0): ?>
                <?php foreach ($activities as $act): ?>
                <tr>
                    <td><?php echo htmlspecialchars($act['tanggal']); ?></td>
                    <td><?php echo htmlspecialchars($act['admin']); ?></td>
                    <td><?php echo htmlspecialchars($act['aksi']); ?></td>
                    <td><?php echo htmlspecialchars($act['item']); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada aktivitas.</td>
                </tr>
            <?php endif; ?>
        </table>
        <div class="nav-links">
            <a href="aset_list.php">Lihat Data Aset</a>
            <a href="aset_tambah.php">Tambah Aset Baru</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>