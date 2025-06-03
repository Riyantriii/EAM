<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit;
}
require_once '../src/db.php';

$id = intval($_POST['id'] ?? 0);

// Jika update status_perawatan (checkbox)
if (isset($_POST['status'])) {
    $status = intval($_POST['status']);
    $stmt = $pdo->prepare("UPDATE aset SET status_perawatan = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    echo "OK";
    exit;
}

// Jika update data lain (edit inline)
if (
    isset($_POST['aksi']) && $_POST['aksi'] === 'edit' &&
    isset($_POST['nama'], $_POST['jenis'], $_POST['terakhir_dirawat'], $_POST['jadwal_berikutnya'], $_POST['keterangan'])
) {
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $terakhir_dirawat = $_POST['terakhir_dirawat'];
    $jadwal_berikutnya = $_POST['jadwal_berikutnya'];
    $keterangan = $_POST['keterangan'];

    $stmt = $pdo->prepare("UPDATE aset SET nama=?, jenis=?, terakhir_dirawat=?, jadwal_berikutnya=?, keterangan=? WHERE id=?");
    $stmt->execute([$nama, $jenis, $terakhir_dirawat, $jadwal_berikutnya, $keterangan, $id]);
    echo json_encode([
        'nama' => $nama,
        'jenis' => $jenis,
        'terakhir_dirawat' => $terakhir_dirawat,
        'jadwal_berikutnya' => $jadwal_berikutnya,
        'keterangan' => $keterangan
    ]);
    exit;
}

http_response_code(400);
echo "Invalid request";