<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
require_once '../src/db.php';

// Ambil data perawatan mesin dari tabel 'aset'
$stmt = $pdo->query("SELECT * FROM perawatan ORDER BY jadwal_berikutnya ASC");
$perawatan = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Info Perawatan Mesin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { background: #f4f7fa; font-family: 'Segoe UI', Arial, sans-serif; margin: 0; padding: 0; }
        .navbar { background: #3b5998; color: #fff; padding: 30px 50px; display: flex; align-items: center; justify-content: space-between; }
        .navbar .logo { font-size: 1.3em; font-weight: bold; letter-spacing: 1px; }
        .navbar .user { font-size: 1em; }
        .container { max-width: 900px; margin: 36px auto 0 auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(44,62,80,0.10); padding: 32px 24px 24px 24px; }
        h2 { color: #3b5998; margin-top: 0; margin-bottom: 24px; font-weight: 600; text-align: center; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(44,62,80,0.07); }
        th, td { padding: 12px 10px; text-align: left; }
        th { background: #f4f7fa; color: #3b5998; font-weight: 600; }
        tr:not(:last-child) { border-bottom: 1px solid #eee; }
        tr:hover { background: #f0f8ff; }
        .nav-links { margin-top: 24px; text-align: right; }
        .nav-links a { display: inline-block; margin-left: 12px; padding: 8px 18px; background: #3b5998; color: #fff; border-radius: 6px; text-decoration: none; font-weight: 500; transition: background 0.2s; }
        .nav-links a:hover { background: #1abc9c; }
        .center { text-align: center; }
        button { margin: 0 2px; padding: 5px 12px; border-radius: 5px; border: none; background: #3b5998; color: #fff; font-weight: 500; cursor: pointer; }
        button:hover { background: #1abc9c; }
    </style>
    <script>
    function updateChecklist(id, checked) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "maintenance_update.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send("id=" + id + "&status=" + (checked ? 1 : 0));
    }

    function editRow(id) {
        var row = document.getElementById('row-' + id);
        row.querySelectorAll('.view').forEach(e => e.style.display = 'none');
        row.querySelectorAll('.edit').forEach(e => e.style.display = '');
        row.querySelector('button[onclick^="editRow"]').style.display = 'none';
        row.querySelector('button[onclick^="saveRow"]').style.display = '';
        row.querySelector('button[onclick^="cancelEdit"]').style.display = '';
    }
    function cancelEdit(id) {
        var row = document.getElementById('row-' + id);
        row.querySelectorAll('.view').forEach(e => e.style.display = '');
        row.querySelectorAll('.edit').forEach(e => e.style.display = 'none');
        row.querySelector('button[onclick^="editRow"]').style.display = '';
        row.querySelector('button[onclick^="saveRow"]').style.display = 'none';
        row.querySelector('button[onclick^="cancelEdit"]').style.display = 'none';
    }
    function saveRow(id) {
        var row = document.getElementById('row-' + id);
        var inputs = row.querySelectorAll('.edit');
        var data = {
            id: id,
            nama: inputs[0].value,
            jenis: inputs[1].value,
            terakhir_dirawat: inputs[2].value,
            jadwal_berikutnya: inputs[3].value,
            keterangan: inputs[4].value
        };
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "maintenance_update.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status == 200) {
                row.querySelectorAll('.view')[0].textContent = data.nama;
                row.querySelectorAll('.view')[1].textContent = data.jenis;
                row.querySelectorAll('.view')[2].textContent = data.terakhir_dirawat;
                row.querySelectorAll('.view')[3].textContent = data.jadwal_berikutnya;
                row.querySelectorAll('.view')[4].textContent = data.keterangan;
                cancelEdit(id);
            } else {
                alert('Gagal menyimpan perubahan!');
            }
        };
        xhr.send("aksi=edit&id=" + encodeURIComponent(data.id)
            + "&nama=" + encodeURIComponent(data.nama)
            + "&jenis=" + encodeURIComponent(data.jenis)
            + "&terakhir_dirawat=" + encodeURIComponent(data.terakhir_dirawat)
            + "&jadwal_berikutnya=" + encodeURIComponent(data.jadwal_berikutnya)
            + "&keterangan=" + encodeURIComponent(data.keterangan));
    }
    </script>
</head>
<body>
    <div class="navbar">
        <div class="logo">EAM UNY</div>
        <div class="user">👤 <?php echo htmlspecialchars($_SESSION['user']['username']); ?></div>
    </div>
    <div class="container">
        <h2>Informasi Perawatan Mesin</h2>
        <table>
            <tr>
                <th>Nama Mesin</th>
                <th>Jenis</th>
                <th>Terakhir Dirawat</th>
                <th>Jadwal Perawatan</th>
                <th>Keterangan</th>
                <th class="center">Perawatan Selesai</th>
                <th class="center">Aksi</th>
            </tr>
            <?php foreach ($perawatan as $row): ?>
            <tr id="row-<?= $row['id'] ?>">
                <td>
                    <span class="view"><?= htmlspecialchars($row['nama']) ?></span>
                    <input class="edit" type="text" value="<?= htmlspecialchars($row['nama']) ?>" style="display:none;width:90%;">
                </td>
                <td>
                    <span class="view"><?= htmlspecialchars($row['jenis']) ?></span>
                    <input class="edit" type="text" value="<?= htmlspecialchars($row['jenis']) ?>" style="display:none;width:90%;">
                </td>
                <td>
                    <span class="view"><?= htmlspecialchars($row['terakhir_dirawat']) ?></span>
                    <input class="edit" type="date" value="<?= htmlspecialchars($row['terakhir_dirawat']) ?>" style="display:none;width:90%;">
                </td>
                <td>
                    <span class="view"><?= htmlspecialchars($row['jadwal_berikutnya']) ?></span>
                    <input class="edit" type="date" value="<?= htmlspecialchars($row['jadwal_berikutnya']) ?>" style="display:none;width:90%;">
                </td>
                <td>
                    <span class="view"><?= htmlspecialchars($row['keterangan']) ?></span>
                    <input class="edit" type="text" value="<?= htmlspecialchars($row['keterangan']) ?>" style="display:none;width:90%;">
                </td>
                <td class="center">
                    <input type="checkbox"
                        onchange="updateChecklist(<?= $row['id'] ?>, this.checked)"
                        <?= $row['status_perawatan'] ? 'checked' : '' ?>>
                </td>
                <td class="center">
                    <button type="button" onclick="editRow(<?= $row['id'] ?>)">Edit</button>
                    <button type="button" style="display:none;" onclick="saveRow(<?= $row['id'] ?>)">Save</button>
                    <button type="button" style="display:none;" onclick="cancelEdit(<?= $row['id'] ?>)">Cancel</button>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (count($perawatan) == 0): ?>
            <tr>
                <td colspan="7" style="text-align:center;">Belum ada data perawatan.</td>
            </tr>
            <?php endif; ?>
        </table>
        <div class="nav-links">
            <a href="dashboard.php">Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>