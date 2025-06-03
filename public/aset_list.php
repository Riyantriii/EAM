<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require_once '../src/db.php';
$stmt = $pdo->query("SELECT * FROM aset");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Aset</title>
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
        .container {
            max-width: 1100px;
            margin: 36px auto 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(44,62,80,0.10);
            padding: 32px 24px 24px 24px;
        }
        h2 {
            color: #3b5998;
            margin-top: 0;
            margin-bottom: 24px;
            font-weight: 600;
            text-align: center;
        }
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require_once '../src/db.php';
$stmt = $pdo->query("SELECT * FROM aset");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Aset</title>
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
    .container {
        max-width: 1400px; /* diperlebar */
        margin: 36px auto 0 auto;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(44,62,80,0.13);
        padding: 40px 36px 36px 36px;
    }
    h2 {
        color: #3b5998;
        margin-top: 0;
        margin-bottom: 24px;
        font-weight: 800;
        text-align: center;
        letter-spacing: 1px;
    }
    .aset-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(44,62,80,0.07);
    }
    .aset-table th, .aset-table td {
        padding: 14px 12px;
        text-align: left;
        font-size: 1.05em;
    }
    .aset-table th {
        background: #eaf0fb;
        color: #2d3e50;
        font-weight: 700;
        border-bottom: 2px solid #d0d7e6;
    }
    .aset-table tr:not(:last-child) {
        border-bottom: 1px solid #e6eaf3;
    }
    .aset-table tr:hover {
        background: #f5faff;
        transition: background 0.2s;
    }
    .nav-links {
        margin-bottom: 24px;
        text-align: right;
    }
    .nav-links a {
        display: inline-block;
        margin-left: 12px;
        padding: 10px 24px;
        background: #3b5998;
        color: #fff;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1em;
        transition: background 0.2s, box-shadow 0.2s;
        box-shadow: 0 2px 8px rgba(44,62,80,0.07);
    }
    .nav-links a:hover {
        background: #1abc9c;
        color: #fff;
    }
    .aksi-btn {
        display: inline-block;
        margin: 0 4px;
        padding: 6px 16px;
        border-radius: 6px;
        border: none;
        background: #3b5998;
        color: #fff;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s;
        font-size: 0.97em;
    }
    .aksi-btn.edit { background: #1abc9c; }
    .aksi-btn.edit:hover { background: #159c80; }
    .aksi-btn.hapus { background: #e74c3c; }
    .aksi-btn.hapus:hover { background: #c0392b; }
    @media (max-width: 1200px) {
        .container { max-width: 98vw; padding: 12px 2px; }
        .aset-table th, .aset-table td { padding: 8px 4px; }
    }
    @media (max-width: 700px) {
        .container { max-width: 99vw; }
        .navbar { flex-direction: column; align-items: flex-start; gap: 8px; }
        .aset-table th, .aset-table td { font-size: 0.95em; }
    }
    </style>
</head>
<body>
<div class="container">
    <h2>DAFTAR ASET BENGKEL</h2>
    <div class="nav-links">
        <a href="dashboard.php">Kembali ke Dashboard</a>
        <a href="aset_tambah.php">Tambah Aset</a>
    </div>

    <?php if (isset($_GET['import'])): ?>
        <?php if ($_GET['import'] === 'success'): ?>
            <div style="background:#d4edda;color:#155724;padding:12px 18px;border-radius:6px;margin-bottom:18px;">
                Import aset dari CSV berhasil!
            </div>
        <?php else: ?>
            <div style="background:#f8d7da;color:#721c24;padding:12px 18px;border-radius:6px;margin-bottom:18px;">
                Import aset gagal. Pastikan format file benar.
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php if (isset($_GET['edit']) && $_GET['edit'] === 'success'): ?>
    <div style="background:#d4edda;color:#155724;padding:12px 18px;border-radius:6px;margin-bottom:18px;">
        Data aset berhasil diubah!
    </div>
<?php endif; ?>
<?php if (isset($_GET['hapus']) && $_GET['hapus'] === 'success'): ?>
    <div style="background:#d4edda;color:#155724;padding:12px 18px;border-radius:6px;margin-bottom:18px;">
        Data aset berhasil dihapus!
    </div>
<?php endif; ?>    
<table class="aset-table">
        <tr>
        <th>ID</th>
        <th>Jenis Mesin</th>
        <th>Jumlah Unit</th>
        <th>Kondisi Baik</th>
        <th>Kondisi Rusak</th>
        <th>Produsen</th>
        <th>Harga</th>
        <th>Tanggal Beli</th>
        <th>Garansi</th>
        <th>Lokasi</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $stmt->fetch()) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['jenis_mesin']) ?></td>
        <td><?= htmlspecialchars($row['jumlah_unit']) ?></td>
        <td><?= htmlspecialchars($row['kondisi_baik']) ?></td>
        <td><?= htmlspecialchars($row['kondisi_rusak']) ?></td>
        <td><?= htmlspecialchars($row['produsen']) ?></td>
        <td><?= htmlspecialchars($row['harga']) ?></td>
        <td><?= htmlspecialchars($row['tanggal_beli']) ?></td>
        <td><?= htmlspecialchars($row['garansi']) ?></td>
        <td><?= htmlspecialchars($row['lokasi']) ?></td>
        <td><?= htmlspecialchars($row['status']) ?></td>
        <td>
            <a href="aset_edit.php?id=<?= $row['id'] ?>" class="aksi-btn edit">Edit</a>
            <a href="aset_hapus.php?id=<?= $row['id'] ?>" class="aksi-btn hapus" onclick="return confirm('Yakin hapus aset ini?')">Hapus</a>
        </td>        
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>