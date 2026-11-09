<?php
session_start();
include 'user/config.php';

// --- PROSES KIRIM NOTIFIKASI ---
$notif_sent = false;
if (isset($_POST['kirim_notif'])) {
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan_notif']);
    $query_notif = "INSERT INTO notifikasi (pesan, waktu, status) VALUES ('$pesan', NOW(), 'baru')";
    if (mysqli_query($conn, $query_notif)) { $notif_sent = true; }
}

// --- AMBIL DATA STATISTIK ASLI ---
$total_tamu = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM tamu"));
$izin_diproses = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM izin_keluar WHERE status='Disetujui'"));
$butuh_konfirmasi = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM izin_keluar WHERE status='Pending'"));

// --- LOGIKA GRAFIK REAL-TIME (5 Hari Terakhir) ---
$grafik_query = mysqli_query($conn, "
    SELECT DATE(tanggal) as tgl, COUNT(*) as jumlah 
    FROM tamu 
    GROUP BY DATE(tanggal) 
    ORDER BY DATE(tanggal) DESC 
    LIMIT 5
");

$data_db = [];
$max_val = 0;
while($row = mysqli_fetch_assoc($grafik_query)) {
    $data_db[] = $row;
    if($row['jumlah'] > $max_val) $max_val = $row['jumlah'];
}
$data_db = array_reverse($data_db);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F9FBFC; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        .sidebar { 
            width: 270px; background: #FFFFFF; border-right: 1px solid #F1F5F9;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar.collapsed { width: 100px; padding: 24px 15px; }
        .sidebar.collapsed .nav-text, .sidebar.collapsed .logo-text, .sidebar.collapsed .category-label { display: none; }
        .sidebar.collapsed .nav-item { justify-content: center; padding: 14px 0; gap: 0; }
        .sidebar.collapsed .logo-area { justify-content: center; padding: 0; }
        
        .content-area { transition: all 0.4s ease; margin-left: 270px; }
        .content-area.expanded { margin-left: 100px; }

        .nav-item {
            display: flex; align-items: center; gap: 14px; padding: 14px 20px;
            border-radius: 20px; color: #64748b; font-weight: 600; font-size: 14px;
            transition: all 0.3s; margin-bottom: 6px; text-decoration: none;
        }
        .nav-item:hover { background: #F8FAFC; color: #064E3B; transform: translateX(4px); }
        .nav-item.active { background: #064E3B; color: #FFFFFF; box-shadow: 0 12px 20px -5px rgba(6, 78, 59, 0.25); }

        .stat-card { background: #FFFFFF; border-radius: 35px; padding: 30px; border: 1px solid #F1F5F9; transition: transform 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
        
        #modalNotif { display: none; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(12px); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="flex">

    <aside id="sidebar" class="sidebar fixed top-0 left-0 bottom-0 z-50 flex flex-col p-6 shadow-sm">
        <div class="flex items-center gap-3 mb-10 px-2 logo-area">
            <div class="w-11 h-11 bg-[#064E3B] rounded-[16px] flex items-center justify-center text-white shadow-lg shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <span class="text-xl font-black text-[#1A302A] tracking-tighter logo-text">Rumah Singgah</span>
        </div>

        <div class="flex-1 overflow-y-auto no-scrollbar">
            <p class="text-[10px] font-extrabold text-slate-300 uppercase tracking-[0.25em] mb-4 px-4 category-label">Layanan Tamu</p>
            <nav class="mb-8">
                <a href="dashboard_admin.php" class="nav-item active">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="buku_tamu.php" class="nav-item">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    <span class="nav-text">Buku Tamu</span>
                </a>
                <a href="data_izin.php" class="nav-item">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="nav-text">Izin Kunjungan</span>
                </a>
            </nav>

            <p class="text-[10px] font-extrabold text-slate-300 uppercase tracking-[0.25em] mb-4 px-4 category-label">Komunikasi</p>
            <nav class="mb-8">
                <a href="siaran_notifikasi.php" class="nav-item w-full text-left">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="nav-text">Siarkan Notifikasi</span>
                </a>
            </nav>

            <p class="text-[10px] font-extrabold text-slate-300 uppercase tracking-[0.25em] mb-4 px-4 category-label">Administrasi</p>
            <nav>
                <a href="kelola_user.php" class="nav-item">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="nav-text">Manajemen User</span>
                </a>
                <a href="laporan_harian.php" class="nav-item">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    <span class="nav-text">Laporan Excel</span>
                </a>
            </nav>
        </div>

        <a href="logout.php" class="mt-auto nav-item text-red-500 hover:bg-red-50 hover:text-red-600 transition-all">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span class="nav-text font-black uppercase text-xs tracking-widest">Log Out</span>
        </a>
    </aside>

    <main id="content" class="content-area flex-1 p-10">
        <header class="flex justify-between items-center mb-10">
            <div class="flex items-center gap-5">
                <button onclick="toggleSidebar()" class="w-12 h-12 flex items-center justify-center bg-white border border-slate-100 rounded-2xl hover:bg-slate-50 shadow-sm transition-all">
                    <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Dashboard Admin</h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Rumah Singgah Management</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white p-2.5 pr-8 rounded-[24px] shadow-sm border border-slate-50">
                <div class="w-11 h-11 bg-[#064E3B] rounded-2xl flex items-center justify-center text-white font-black text-lg">A</div>
                <div class="text-sm">
                    <p class="font-black text-[#1A302A] leading-none">Admin Utama</p>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-wider mt-1.5 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Terhubung
                    </p>
                </div>
            </div>
        </header>

        <div class="grid grid-cols-4 gap-6 mb-10">
            <div class="stat-card border-b-4 border-b-[#064E3B] shadow-sm">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Total Tamu</p>
                <h4 class="text-6xl font-black text-slate-800 mt-2 tracking-tighter"><?= $total_tamu ?></h4>
                <p class="text-[10px] text-slate-400 font-bold mt-4 italic">Updated Realtime</p>
            </div>
            <div class="stat-card shadow-sm">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Izin Disetujui</p>
                <h4 class="text-6xl font-black text-emerald-600 mt-2 tracking-tighter"><?= $izin_diproses ?></h4>
                <div class="flex items-center gap-2 mt-4 text-emerald-500 font-bold text-[9px] uppercase tracking-widest">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Verifikasi Sukses
                </div>
            </div>
            <div class="stat-card shadow-sm">
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Konfirmasi</p>
                <h4 class="text-6xl font-black text-orange-500 mt-2 tracking-tighter"><?= $butuh_konfirmasi ?></h4>
                <p class="text-[10px] text-orange-400 font-bold mt-4 uppercase animate-bounce">Perlu Tindakan</p>
            </div>
            <div class="stat-card bg-[#064E3B] border-none shadow-2xl shadow-emerald-900/20 text-white">
                <p class="text-[10px] font-black text-white/40 uppercase tracking-widest">Sistem Status</p>
                <h4 class="text-5xl font-black mt-4 italic">Online</h4>
                <p class="text-[10px] text-emerald-300 font-bold mt-6 uppercase tracking-[0.2em]">Kapasitas Aman</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div class="col-span-2 bg-white rounded-[40px] p-10 border border-slate-50 shadow-sm">
                <div class="flex justify-between items-center mb-12">
                    <h4 class="text-xl font-black text-slate-800 tracking-tight">Statistik Kunjungan (Realtime)</h4>
                    <div class="flex gap-2">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Tinggi Kunjungan</span>
                    </div>
                </div>
                <div class="flex items-end justify-between gap-6 h-56 px-4">
                    <?php 
                    if (empty($data_db)) {
                        echo "<p class='text-slate-300 text-xs italic w-full text-center'>Belum ada data kunjungan</p>";
                    } else {
                        foreach($data_db as $data): 
                            $height = ($max_val > 0) ? ($data['jumlah'] / $max_val) * 100 : 10;
                            $is_today = (date('Y-m-d') == $data['tgl']);
                            $color = $is_today ? 'bg-[#064E3B]' : 'bg-emerald-50';
                            $label = date('d M', strtotime($data['tgl']));
                    ?>
                    <div class="flex flex-col items-center gap-5 flex-1 group relative">
                        <div class="absolute -top-10 bg-slate-800 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity font-bold">
                            <?= $data['jumlah'] ?> Tamu
                        </div>
                        <div class="w-full <?= $color ?> rounded-[20px] transition-all duration-500 group-hover:scale-[1.03] group-hover:bg-emerald-100" 
                             style="height: <?= max($height, 15) ?>%">
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest text-center"><?= $is_today ? 'Hari Ini' : $label ?></span>
                    </div>
                    <?php endforeach; } ?>
                </div>
            </div>

            <div class="bg-[#064E3B] rounded-[40px] p-10 relative overflow-hidden shadow-2xl shadow-emerald-900/30 flex flex-col justify-between text-white">
                <div class="w-16 h-16 bg-white/10 rounded-[24px] flex items-center justify-center text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-emerald-300/40 uppercase tracking-[0.3em] mb-3">Info Server</p>
                    <h4 class="text-3xl font-black text-white leading-tight">Rumah Singgah<br>Online</h4>
                    <div class="mt-8 flex items-center gap-3">
                        <div class="px-4 py-1.5 bg-emerald-500/20 rounded-full text-[10px] font-black text-emerald-400 uppercase tracking-widest border border-emerald-500/30">Stable Connection</div>
                    </div>
                </div>
                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full"></div>
            </div>
        </div>

        <footer class="mt-16 text-center">
            <p class="text-[11px] font-black text-slate-300 uppercase tracking-[0.4em]">© 2026 RAHMAT | <span class="text-[#064E3B]/20 font-black italic">RUMAH SINGGAH SYSTEM</span></p>
        </footer>
    </main>

    <div id="modalNotif" class="fixed inset-0 z-[100] flex items-center justify-center p-6">
        <div class="bg-white w-full max-w-md rounded-[45px] p-12 shadow-2xl">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">Kirim Pengumuman</h3>
                <button onclick="closeModal()" class="w-10 h-10 flex items-center justify-center bg-slate-50 text-slate-400 rounded-full hover:bg-red-50 hover:text-red-500 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form action="" method="POST">
                <p class="text-slate-400 text-sm mb-6 font-medium leading-relaxed">Isi pesan di bawah untuk memberikan informasi kepada seluruh user di halaman utama.</p>
                <textarea name="pesan_notif" rows="4" class="w-full bg-slate-50 border-2 border-transparent rounded-[24px] p-6 text-sm font-semibold focus:border-[#064E3B] focus:bg-white outline-none mb-8 transition-all placeholder-slate-300" placeholder="Contoh: Maaf, pendaftaran tamu ditutup sementara..." required></textarea>
                <button type="submit" name="kirim_notif" class="w-full py-5 bg-[#064E3B] text-white rounded-[22px] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-emerald-900/30 hover:scale-[1.02] active:scale-95 transition-all">
                    Siarkan Notifikasi
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('content').classList.toggle('expanded');
        }
        function openModal() { document.getElementById('modalNotif').style.display = 'flex'; }
        function closeModal() { document.getElementById('modalNotif').style.display = 'none'; }

        <?php if($notif_sent): ?>
        Swal.fire({ 
            icon: 'success', 
            title: '<span style="font-family:Plus Jakarta Sans; font-weight:800">Berhasil!</span>', 
            text: 'Pengumuman telah disiarkan ke seluruh user.', 
            confirmButtonColor: '#064E3B',
            borderRadius: '25px'
        });
        <?php endif; ?>
    </script>
</body>
</html>