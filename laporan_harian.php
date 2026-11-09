<?php
// 1. Koneksi Database
include 'user/config.php';

// 2. Logika Export ke Excel
if (isset($_POST['export'])) {
    $tgl_awal  = $_POST['tgl_awal'];
    $tgl_akhir = $_POST['tgl_akhir'];

    // Nama file yang akan dihasilkan
    $filename = "Laporan_Rumah_Singgah_" . $tgl_awal . "_ke_" . $tgl_akhir . ".xls";

    // Header untuk memaksa download file Excel
    header("Content-Type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Ambil data berdasarkan rentang tanggal
    // Sesuaikan nama tabel 'buku_tamu' dan kolom 'tanggal' dengan DB kamu
    $query = mysqli_query($conn, "SELECT * FROM buku_tamu WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tanggal ASC");

    echo "<h3>LAPORAN HARIAN RUMAH SINGGAH</h3>";
    echo "<p>Periode: $tgl_awal s/d $tgl_akhir</p>";
    echo "<table border='1'>
            <thead>
                <tr style='background-color: #064E3B; color: white;'>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Tamu</th>
                    <th>Instansi/Alamat</th>
                    <th>Keperluan</th>
                    <th>No. Telepon</th>
                </tr>
            </thead>
            <tbody>";
    
    $no = 1;
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>
                <td>$no</td>
                <td>{$row['tanggal']}</td>
                <td>{$row['nama_tamu']}</td>
                <td>{$row['alamat']}</td>
                <td>{$row['keperluan']}</td>
                <td>{$row['telepon']}</td>
              </tr>";
        $no++;
    }
    echo "</tbody></table>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Excel - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F9FBFC; font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar { width: 270px; background: #FFFFFF; border-right: 1px solid #F1F5F9; position: fixed; height: 100vh; padding: 24px; }
        .nav-item { display: flex; align-items: center; gap: 14px; padding: 14px 20px; border-radius: 20px; color: #64748b; font-weight: 600; font-size: 14px; text-decoration: none; transition: 0.3s; margin-bottom: 6px; }
        .nav-item:hover { background: #F8FAFC; color: #064E3B; }
        .nav-item.active { background: #064E3B; color: #FFFFFF; box-shadow: 0 12px 20px -5px rgba(6, 78, 59, 0.25); }
        .card { background: #FFFFFF; border-radius: 35px; border: 1px solid #F1F5F9; padding: 40px; }
    </style>
</head>
<body class="flex">

    <aside class="sidebar flex flex-col">
        <div class="flex items-center gap-3 mb-10 px-2">
            <div class="w-11 h-11 bg-[#064E3B] rounded-[16px] flex items-center justify-center text-white shadow-lg shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <span class="text-xl font-black text-[#1A302A] tracking-tighter">Rumah Singgah</span>
        </div>

        <nav class="flex-1">
            <p class="text-[10px] font-extrabold text-slate-300 uppercase tracking-widest mb-4 px-4">Menu Utama</p>
            <a href="dashboard_admin.php" class="nav-item">Dashboard</a>
            <a href="buku_tamu.php" class="nav-item">Buku Tamu</a>
            <a href="laporan_harian.php" class="nav-item active">Laporan Excel</a>
            <a href="kelola_user.php" class="nav-item">Manajemen User</a>
        </nav>
    </aside>

    <main class="flex-1 ml-[270px] p-10">
        <header class="mb-10">
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Export Laporan Excel</h2>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Download rekapan data tamu harian</p>
        </header>

        <div class="card shadow-sm max-w-2xl">
            <form action="" method="POST" class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Dari Tanggal</label>
                        <input type="date" name="tgl_awal" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl text-sm font-bold text-slate-600 outline-none focus:border-[#064E3B]" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Sampai Tanggal</label>
                        <input type="date" name="tgl_akhir" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl text-sm font-bold text-slate-600 outline-none focus:border-[#064E3B]" required>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" name="export" class="w-full py-4 bg-[#064E3B] text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-900/20 hover:scale-[1.02] transition-all flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download Laporan (.xls)
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-10 p-6 bg-amber-50 border border-amber-100 rounded-2xl max-w-2xl">
            <div class="flex gap-4">
                <svg class="w-6 h-6 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-xs text-amber-700 font-bold leading-relaxed uppercase tracking-wider">
                    Pastikan rentang tanggal sudah benar sebelum mengunduh. Data yang ditarik diambil langsung dari tabel buku tamu.
                </p>
            </div>
        </div>
    </main>

</body>
</html>