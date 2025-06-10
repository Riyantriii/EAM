<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require_once '../src/db.php';

try {
    // Ambil data perawatan mesin dari tabel 'perawatan' JOIN 'aset'
    $stmt = $pdo->prepare("
        SELECT p.id, p.nama_item, p.terakhir_dirawat, p.jadwal_berikutnya, 
               p.keterangan, p.status_perawatan, p.kode_aset, p.merk, p.model
        FROM perawatan p
        ORDER BY p.jadwal_berikutnya ASC
    ");
    $stmt->execute();
    $perawatan = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Hitung statistik perawatan
    $total_perawatan = $stmt->rowCount();

    // Hitung jumlah perawatan selesai
    $stmt_selesai = $pdo->prepare("SELECT COUNT(*) FROM perawatan WHERE status_perawatan = 1");
    $stmt_selesai->execute();
    $perawatan_selesai = $stmt_selesai->fetchColumn();

    // Hitung jumlah perawatan pending
    $perawatan_pending = $total_perawatan - $perawatan_selesai;

    // Hitung jumlah perawatan mendatang
    $stmt_mendatang = $pdo->prepare("
        SELECT COUNT(*) FROM perawatan 
        WHERE jadwal_berikutnya > CURRENT_DATE 
        AND status_perawatan = 0
    ");
    $stmt_mendatang->execute();
    $perawatan_mendatang = $stmt_mendatang->fetchColumn();

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $perawatan = [];
    $total_perawatan = 0;
    $perawatan_selesai = 0;
    $perawatan_pending = 0;
    $perawatan_mendatang = 0;
    $error_message = "Terjadi kesalahan saat mengambil data perawatan.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perawatan Mesin - EAM UNY</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* ... (semua style lama tetap, tidak berubah) ... */
        <?php /* Style lama tetap di sini, tidak diubah untuk menjaga tampilan */ ?>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body { 
            background: linear-gradient(135deg,rgb(22, 37, 102) 0%,rgb(54, 38, 70) 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            color: #333;
        }
        .navbar { 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar .logo { 
            font-size: 1.5em;
            font-weight: 700;
            color: #667eea;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .navbar .user { 
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 500;
        }
        .container { 
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        .page-header {
            text-align: center;
            margin-bottom: 2rem;
            color: white;
        }
        .page-header h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        .stat-icon.total { background: linear-gradient(135deg, #667eea, #764ba2); }
        .stat-icon.completed { background: linear-gradient(135deg, #56ab2f, #a8e6cf); }
        .stat-icon.pending { background: linear-gradient(135deg, #f093fb, #f5576c); }
        .stat-icon.upcoming { background: linear-gradient(135deg, #4facfe, #00f2fe); }
        .stat-content h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.25rem;
        }
        .stat-content p {
            color: #666;
            font-weight: 500;
        }
        .main-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: between;
            gap: 1rem;
        }
        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            flex: 1;
        }
        .search-box {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 25px;
            padding: 0.5rem 1rem;
            color: white;
            width: 250px;
        }
        .search-box::placeholder {
            color: rgba(255,255,255,0.7);
        }
        .alert {
            margin: 1.5rem 2rem;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .table-container {
            padding: 0;
            overflow-x: auto;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            min-width: 900px;
        }
        th {
            background: #f8f9ff;
            color: #4a5568;
            font-weight: 600;
            padding: 1rem;
            text-align: left;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        tbody tr {
            transition: background-color 0.2s ease;
        }
        tbody tr:hover { 
            background: #f7fafc;
        }
        .machine-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        .machine-name {
            font-weight: 600;
            color: #2d3748;
        }
        .machine-code {
            font-size: 0.875rem;
            color: #718096;
        }
        .machine-details {
            font-size: 0.75rem;
            color: #a0aec0;
        }
        .date-display {
            font-weight: 500;
            color: #4a5568;
        }
        .date-overdue {
            color: #e53e3e;
            font-weight: 600;
        }
        .date-upcoming {
            color: #3182ce;
            font-weight: 600;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-align: center;
            min-width: 80px;
            display: inline-block;
            cursor: pointer;
        }
        .status-completed {
            background: linear-gradient(135deg, #48bb78, #68d391);
            color: white;
        }
        .status-pending {
            background: linear-gradient(135deg, #ed8936, #f6ad55);
            color: white;
        }
        .checkbox-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .custom-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e0;
            border-radius: 4px;
            position: relative;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .custom-checkbox:checked {
            background: linear-gradient(135deg, #48bb78, #68d391);
            border-color: #48bb78;
        }
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.875rem;
        }
        .btn-edit {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
        }
        .btn-save {
            background: linear-gradient(135deg, #56ab2f, #a8e6cf);
            color: white;
        }
        .btn-cancel {
            background: linear-gradient(135deg, #bbb, #999);
            color: white;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .edit-input {
            width: 100%;
            padding: 0.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: border-color 0.2s ease;
        }
        .edit-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .loading {
            display: none;
            color: #667eea;
            font-style: italic;
            font-size: 0.875rem;
        }
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #718096;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
        .footer-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            background: #f8f9ff;
            border-top: 1px solid #e2e8f0;
        }
        .refresh-info {
            color: #718096;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        /* Popup Perawatan Card */
        .overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.4);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }
        .overlay.active {
            display: flex;
        }
        .card-perawatan {
            background: #fff;
            border-radius: 18px;
            max-width: 700px; /* Increased from 500px */
            width: 90%;
            box-shadow: 0 6px 32px rgba(0,0,0,0.18);
            padding: 2.5rem; /* Increased padding */
            position: relative;
            animation: fadeInScale 0.3s;
        }

        .perawatan-table {
            width: 100%;
            margin: 1.5rem 0;
            border-collapse: collapse;
        }

        .perawatan-table td {
            padding: 12px;
            border: 1px solid #e2e8f0;
        }

        .perawatan-table td:first-child {
            width: 200px;
            background: #f8fafc;
            font-weight: 600;
            color: #4a5568;
        }

        .perawatan-table input, 
        .perawatan-table textarea {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 0.95rem;
            margin: 0;
        }

        .perawatan-table textarea {
            min-height: 80px; /* Increased height */
            resize: vertical;
        }
        .perawatan-table label {
            font-weight: 500;
            color: #444;
        }
        .perawatan-action-btns {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .btn-print {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
        }
        .btn-back {
            background: #e2e8f0;
            color: #333;
        }
        @media print {
        @page {
            size: A4;
            margin: 2cm;
        }
        
        body * {
            visibility: hidden;
        }
        
        .card-perawatan,
        .card-perawatan * {
            visibility: visible;
        }
        
        .card-perawatan {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            box-shadow: none;
        }

        .perawatan-action-btns {
            display: none;
        }
    }
        @media (max-width: 768px) {
            .navbar { padding: 1rem; }
            .navbar .logo { font-size: 1.2rem; }
            .container { margin: 1rem auto; padding: 0 0.5rem; }
            .page-header h1 { font-size: 2rem; }
            .stats-grid { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); }
            .card-header { flex-direction: column; gap: 1rem; }
            .search-box { width: 100%; }
            .action-buttons { flex-direction: column; }
            .footer-actions { flex-direction: column; gap: 1rem; }
            .card-perawatan { max-width: 99vw; padding: 1rem; }
        }
        .notification {
            position: fixed;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: bottom 0.3s ease;
            z-index: 3000;
        }
        .notification.success {
            background: linear-gradient(135deg, #56ab2f, #a8e6cf);
            color: white;
        }
        .notification.error {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
        }
        .notification.show {
            bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <i class="fas fa-tools"></i>
            EAM UNY
        </div>
        <div class="user">
            <i class="fas fa-user"></i>
            <?php echo htmlspecialchars($_SESSION['user']['username'] ?? 'Unknown'); ?>
        </div>
    </div>

    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-cogs"></i> Perawatan Mesin</h1>
            <p>Kelola jadwal dan status perawatan aset mesin</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-list"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo $total_perawatan; ?></h3>
                    <p>Total Perawatan</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon completed">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo $perawatan_selesai; ?></h3>
                    <p>Selesai</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo $perawatan_pending; ?></h3>
                    <p>Pending</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon upcoming">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-content">
                    <h3><?php echo $perawatan_mendatang; ?></h3>
                    <p>Mendatang</p>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="main-card">
            <div class="card-header">
                <h2><i class="fas fa-table"></i> Data Perawatan Mesin</h2>
                <input type="text" class="search-box" placeholder="Cari mesin..." id="searchInput">
            </div>
            
            <?php if (isset($error_message)): ?>
            <div class="alert">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo htmlspecialchars($error_message); ?>
            </div>
            <?php endif; ?>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-cog"></i> Jenis Mesin</th>
                            <th><i class="fas fa-history"></i> Terakhir Dirawat</th>
                            <th><i class="fas fa-calendar"></i> Jadwal Berikutnya</th>
                            <th><i class="fas fa-sticky-note"></i> Keterangan</th>
                            <th><i class="fas fa-flag"></i> Status</th>
                            <th><i class="fas fa-check"></i> Selesai</th>
                            <th><i class="fas fa-tools"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($perawatan) > 0): ?>
                            <?php foreach ($perawatan as $row): 
                                $isOverdue = $row['jadwal_berikutnya'] && strtotime($row['jadwal_berikutnya']) < time() && !$row['status_perawatan'];
                                $isUpcoming = $row['jadwal_berikutnya'] && strtotime($row['jadwal_berikutnya']) > time() && strtotime($row['jadwal_berikutnya']) <= strtotime('+7 days');
                            ?>
                            <tr id="row-<?= $row['id'] ?>">
                                <td>
                                    <div class="view">
                                        <div class="machine-info">
                                            <div class="machine-name"><?= htmlspecialchars($row['nama_item'] ?? 'Tidak Diketahui') ?></div>
                                            <div class="machine-code"><?= htmlspecialchars($row['kode_aset'] ?? '-') ?></div>
                                            <div class="machine-details"><?= htmlspecialchars(($row['merk'] ?? '') . ' ' . ($row['model'] ?? '')) ?></div>
                                        </div>
                                    </div>
                                    <input class="edit edit-input" type="text" 
                                           value="<?= htmlspecialchars($row['nama_item'] ?? '') ?>" 
                                           style="display:none;" readonly>
                                </td>
                                <td>
                                    <span class="view date-display"><?= $row['terakhir_dirawat'] ? date('d/m/Y', strtotime($row['terakhir_dirawat'])) : '-' ?></span>
                                    <input class="edit edit-input" type="date" 
                                           value="<?= htmlspecialchars($row['terakhir_dirawat'] ?? '') ?>" 
                                           style="display:none;">
                                </td>
                                <td>
                                    <span class="view <?= $isOverdue ? 'date-overdue' : ($isUpcoming ? 'date-upcoming' : 'date-display') ?>">
                                        <?= $row['jadwal_berikutnya'] ? date('d/m/Y', strtotime($row['jadwal_berikutnya'])) : '-' ?>
                                        <?php if ($isOverdue): ?>
                                            <i class="fas fa-exclamation-triangle" title="Terlambat"></i>
                                        <?php elseif ($isUpcoming): ?>
                                            <i class="fas fa-bell" title="Segera"></i>
                                        <?php endif; ?>
                                    </span>
                                    <input class="edit edit-input" type="date" 
                                           value="<?= htmlspecialchars($row['jadwal_berikutnya'] ?? '') ?>" 
                                           style="display:none;">
                                </td>
                                <td>
                                    <span class="view"><?= htmlspecialchars($row['keterangan'] ?? '-') ?></span>
                                    <input class="edit edit-input" type="text" 
                                           value="<?= htmlspecialchars($row['keterangan'] ?? '') ?>" 
                                           style="display:none;">
                                </td>
                                <td>
                                    <?php if ($row['status_perawatan']): ?>
                                    <span 
                                        class="status-badge status-completed clickable-status"
                                        style="cursor:pointer"
                                        data-id="<?= $row['id'] ?>"
                                        data-nama="<?= htmlspecialchars($row['nama_item']) ?>"
                                        data-kode="<?= htmlspecialchars($row['kode_aset']) ?>"
                                        data-merk="<?= htmlspecialchars($row['merk']) ?>"
                                        data-model="<?= htmlspecialchars($row['model']) ?>"
                                        data-terakhir="<?= htmlspecialchars($row['terakhir_dirawat']) ?>"
                                        >
                                        Selesai
                                    </span>
                                    <?php else: ?>
                                    <span class="status-badge status-pending">
                                        Pending
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="checkbox-container">
                                        <input type="checkbox" class="custom-checkbox"
                                            onchange="updateChecklist(<?= $row['id'] ?>, this.checked)"
                                            <?= $row['status_perawatan'] ? 'checked' : '' ?>>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-edit" onclick="editRow(<?= $row['id'] ?>)">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button type="button" class="btn btn-save" style="display:none;" onclick="saveRow(<?= $row['id'] ?>)">
                                            <i class="fas fa-save"></i> Simpan
                                        </button>
                                        <button type="button" class="btn btn-cancel" style="display:none;" onclick="cancelEdit(<?= $row['id'] ?>)">
                                            <i class="fas fa-times"></i> Batal
                                        </button>
                                        <div class="loading" id="loading-<?= $row['id'] ?>">
                                            <i class="fas fa-spinner fa-spin"></i> Menyimpan...
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <h3>Belum Ada Data Perawatan</h3>
                                    <p>Belum ada jadwal perawatan yang terdaftar dalam sistem.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="footer-actions">
                <div class="refresh-info">
                    <i class="fas fa-sync-alt"></i>
                    Data akan diperbarui otomatis setiap 5 menit
                </div>
                <a href="dashboard.php" class="btn btn-edit">
                    <i class="fas fa-home"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Popup Kartu Perawatan -->
    <div class="overlay" id="overlayPerawatan">
        <div class="card-perawatan" id="kartuPerawatan">
            <button class="close-btn" onclick="closeKartuPerawatan()">&times;</button>
            <h2>Kartu Perawatan Mesin</h2>
            <form id="formPerawatan">
                <table class="perawatan-table">
                    <tr>
                        <td><label>Nama Item</label></td>
                        <td><span id="perawatan-nama"></span></td>
                    </tr>
                    <tr>
                        <td><label>Spesifikasi</label></td>
                        <td><span id="perawatan-spesifikasi"></span></td>
                    </tr>
                    <tr>
                        <td><label>No Inventarisasi (ID)</label></td>
                        <td><span id="perawatan-id"></span></td>
                    </tr>
                    <tr>
                        <td><label>Terakhir Dirawat</label></td>
                        <td><span id="perawatan-terakhir"></span></td>
                    </tr>
                    <tr>
                        <td><label>Jenis Perawatan</label></td>
                        <td><input type="text" name="jenis_perawatan" id="jenis_perawatan" placeholder="Isi jenis perawatan" required></td>
                    </tr>
                    <tr>
                        <td><label>Kegiatan yang Dilakukan</label></td>
                        <td><textarea name="kegiatan" id="kegiatan" placeholder="Isi kegiatan perawatan" required></textarea></td>
                    </tr>
                    <tr>
                        <td><label>Komponen yang Digunakan</label></td>
                        <td><textarea name="komponen" id="komponen" placeholder="Isi komponen yang digunakan" required></textarea></td>
                    </tr>
                </table>
                <div class="perawatan-action-btns">
                    <button type="button" class="btn btn-print" onclick="printKartuPerawatan()"><i class="fas fa-print"></i> Cetak</button>
                    <button type="button" class="btn btn-back" onclick="closeKartuPerawatan()"><i class="fas fa-arrow-left"></i> Kembali</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    function showLoading(id, show) {
        const loading = document.getElementById('loading-' + id);
        const buttons = document.getElementById('row-' + id).querySelectorAll('button');
        if (show) {
            loading.style.display = 'flex';
            buttons.forEach(btn => btn.disabled = true);
        } else {
            loading.style.display = 'none';
            buttons.forEach(btn => btn.disabled = false);
        }
    }

    function updateChecklist(id, checked) {
        showLoading(id, true);
        const currentDate = new Date().toISOString().split('T')[0];
        fetch('maintenance_update.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
            body: `aksi=update_status&id=${encodeURIComponent(id)}&status=${checked ? 1 : 0}&terakhir_dirawat=${currentDate}`
        })
        .then(response => response.json())
        .then(data => {
            showLoading(id, false);
            if (data.success) {
                const row = document.getElementById('row-' + id);
                const statusBadge = row.querySelector('.status-badge');
                const terakhirDirawat = row.querySelector('.date-display');
                if (checked) {
                    statusBadge.textContent = 'Selesai';
                    statusBadge.className = 'status-badge status-completed clickable-status';
                    terakhirDirawat.textContent = formatDate(currentDate);
                } else {
                    statusBadge.textContent = 'Pending';
                    statusBadge.className = 'status-badge status-pending';
                }
                showNotification('Status perawatan berhasil diperbarui', 'success');
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            showLoading(id, false);
            showNotification('Gagal mengupdate status: ' + error.message, 'error');
            const checkbox = document.getElementById('row-' + id).querySelector('input[type="checkbox"]');
            checkbox.checked = !checked;
        });
    }

    function saveRow(id) {
        const row = document.getElementById('row-' + id);
        const inputs = row.querySelectorAll('.edit');
        const data = {
            id: id,
            terakhir_dirawat: inputs[1].value,
            jadwal_berikutnya: inputs[2].value,
            keterangan: inputs[3].value.trim()
        };
        showLoading(id, true);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "maintenance_update.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            showLoading(id, false);
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText || '{}');
                    if (response.success) {
                        const viewElements = row.querySelectorAll('.view');
                        viewElements[1].textContent = data.terakhir_dirawat ? new Date(data.terakhir_dirawat).toLocaleDateString('id-ID') : '-';
                        viewElements[2].innerHTML = data.jadwal_berikutnya ? new Date(data.jadwal_berikutnya).toLocaleDateString('id-ID') : '-';
                        viewElements[3].textContent = data.keterangan || '-';
                        cancelEdit(id);
                        showNotification('Data berhasil disimpan', 'success');
                    } else {
                        throw new Error(response.message || 'Terjadi kesalahan');
                    }
                } catch (e) {
                    showNotification('Gagal menyimpan data: ' + e.message, 'error');
                }
            } else {
                showNotification('Terjadi kesalahan server', 'error');
            }
        };
        xhr.onerror = function() {
            showLoading(id, false);
            showNotification('Terjadi kesalahan jaringan', 'error');
        };
        const params = "aksi=edit&id=" + encodeURIComponent(data.id)
            + "&terakhir_dirawat=" + encodeURIComponent(data.terakhir_dirawat)
            + "&jadwal_berikutnya=" + encodeURIComponent(data.jadwal_berikutnya)
            + "&keterangan=" + encodeURIComponent(data.keterangan);
        xhr.send(params);
    }

    // Helper function untuk format tanggal
    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID');
    }

    function editRow(id) {
        const row = document.getElementById('row-' + id);
        const viewElements = row.querySelectorAll('.view');
        const editElements = row.querySelectorAll('.edit');
        viewElements.forEach(e => e.style.display = 'none');
        editElements.forEach(e => e.style.display = 'block');
        row.querySelector('button[onclick^="editRow"]').style.display = 'none';
        row.querySelector('button[onclick^="saveRow"]').style.display = 'inline-flex';
        row.querySelector('button[onclick^="cancelEdit"]').style.display = 'inline-flex';
    }

    function cancelEdit(id) {
        const row = document.getElementById('row-' + id);
        const viewElements = row.querySelectorAll('.view');
        const editElements = row.querySelectorAll('.edit');
        viewElements.forEach(e => e.style.display = 'block');
        editElements.forEach(e => e.style.display = 'none');
        row.querySelector('button[onclick^="editRow"]').style.display = 'inline-flex';
        row.querySelector('button[onclick^="saveRow"]').style.display = 'none';
        row.querySelector('button[onclick^="cancelEdit"]').style.display = 'none';
    }

    // Notification system
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            ${message}
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.classList.add('show'), 100);
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Auto refresh every 5 minutes
    setInterval(() => {
        location.reload();
    }, 300000);

    // === KARTU PERAWATAN ===

    // Listen to click on "Selesai" badge
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.clickable-status').forEach(function(elem) {
            elem.addEventListener('click', function() {
                openKartuPerawatan(this);
            });
        });
    });

    function openKartuPerawatan(elem) {
        // Ambil data dari atribut
        document.getElementById('perawatan-nama').textContent = elem.getAttribute('data-nama');
        document.getElementById('perawatan-id').textContent = elem.getAttribute('data-kode');
        document.getElementById('perawatan-spesifikasi').textContent = (elem.getAttribute('data-merk') || '') + ' ' + (elem.getAttribute('data-model') || '');
        document.getElementById('perawatan-terakhir').textContent = elem.getAttribute('data-terakhir') ? formatDate(elem.getAttribute('data-terakhir')) : '-';

        // Reset input form
        document.getElementById('jenis_perawatan').value = '';
        document.getElementById('kegiatan').value = '';
        document.getElementById('komponen').value = '';

        document.getElementById('overlayPerawatan').classList.add('active');
    }
    function closeKartuPerawatan() {
        document.getElementById('overlayPerawatan').classList.remove('active');
    }

    // Print function for kartu perawatan
    function printKartuPerawatan() {
    // Ambil data dari form
    const nama = document.getElementById('perawatan-nama').textContent;
    const spesifikasi = document.getElementById('perawatan-spesifikasi').textContent;
    const id = document.getElementById('perawatan-id').textContent;
    const terakhir = document.getElementById('perawatan-terakhir').textContent;
    const jenis = document.getElementById('jenis_perawatan').value;
    const kegiatan = document.getElementById('kegiatan').value;
    const komponen = document.getElementById('komponen').value;

    // Template print dengan style yang lebih baik
    const html = `
    <!DOCTYPE html>
    <html>
    <head>
        <title>Kartu Perawatan Mesin</title>
        <style>
            @page { 
                size: A4;
                margin: 1.5cm;
            }
            body { 
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 2px solid #333;
                padding-bottom: 10px;
            }
            .header h2 {
                color: #1a202c;
                margin: 0;
                font-size: 24px;
                text-transform: uppercase;
            }
            .logo {
                text-align: center;
                margin-bottom: 20px;
            }
            .logo img {
                height: 60px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            td {
                padding: 12px 15px;
                border: 1px solid #cbd5e0;
            }
            td:first-child {
                width: 35%;
                background: #f8fafc;
                font-weight: bold;
                color: #2d3748;
            }
            .content-cell {
                min-height: 80px;
                white-space: pre-wrap;
            }
            .footer {
                margin-top: 50px;
                display: flex;
                justify-content: flex-end;
            }
            .signature {
                text-align: center;
                width: 200px;
            }
            .signature-line {
                margin-top: 80px;
                border-top: 1px solid #000;
                width: 100%;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <img src="assets/logo-uny.png" alt="Logo UNY">
            </div>
            <div class="header">
                <h2>KARTU PERAWATAN MESIN</h2>
            </div>
            <table>
                <tr><td>Nama Item</td><td>${nama}</td></tr>
                <tr><td>Spesifikasi</td><td>${spesifikasi}</td></tr>
                <tr><td>No Inventarisasi (ID)</td><td>${id}</td></tr>
                <tr><td>Terakhir Dirawat</td><td>${terakhir}</td></tr>
                <tr><td>Jenis Perawatan</td><td>${jenis}</td></tr>
                <tr><td>Kegiatan yang Dilakukan</td><td class="content-cell">${kegiatan}</td></tr>
                <tr><td>Komponen yang Digunakan</td><td class="content-cell">${komponen}</td></tr>
            </table>
            <div class="footer">
                <div class="signature">
                    <p>Yogyakarta, ${new Date().toLocaleDateString('id-ID')}</p>
                    <p>Petugas Maintenance</p>
                    <div class="signature-line"></div>
                    <p>(${document.querySelector('.user').textContent.trim()})</p>
                </div>
            </div>
        </div>
    </body>
    </html>
    `;
    
    // Buka window baru untuk print
    const win = window.open('', '_blank', 'width=800,height=800');
    win.document.write(html);
    win.document.close();
    
    // Tunggu sampai gambar dan style dimuat
    win.onload = function() {
        // Delay print untuk memastikan style sudah diaplikasikan
        setTimeout(() => {
            win.print();
            // Tutup window setelah print dialog ditutup
            win.onfocus = function() { 
                setTimeout(function() { win.close(); }, 500);
            };
        }, 1000);
    };
}
    </script>
</body>
</html>