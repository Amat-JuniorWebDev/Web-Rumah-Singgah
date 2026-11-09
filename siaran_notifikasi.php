<?php
session_start();
include 'user/config.php';

// --- LOGIKA KIRIM NOTIFIKASI ---
$notif_sent = false;
if (isset($_POST['kirim_notif'])) {
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan_notif']);
    $query_insert = "INSERT INTO notifikasi (pesan, waktu, status) VALUES ('$pesan', NOW(), 'baru')";
    if (mysqli_query($conn, $query_insert)) {
        $notif_sent = true;
    }
}

// --- LOGIKA HAPUS NOTIFIKASI ---
if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($conn, $_GET['hapus']);
    mysqli_query($conn, "DELETE FROM notifikasi WHERE id='$id'");
    echo "<script>window.location.href='siaran_notifikasi.php';</script>";
    exit();
}

// Ambil riwayat
$query_notif = mysqli_query($conn, "SELECT * FROM notifikasi ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siaran Notifikasi - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F9FBFC; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        .sidebar { 
            width: 270px; background: #FFFFFF; border-right: 1px solid #F1F5F9;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .nav-item {
            display: flex; align-items: center; gap: 14px; padding: 14px 20px;
            border-radius: 20px; color: #64748b; font-weight: 600; font-size: 14px;
            transition: all 0.3s; margin-bottom: 6px; text-decoration: none;
        }
        .nav-item:hover { background: #F8FAFC; color: #064E3B; transform: translateX(4px); }
        .nav-item.active { background: #064E3B; color: #FFFFFF; box-shadow: 0 12px 20px -5px rgba(6, 78, 59, 0.25); }

        .content-card { background: #FFFFFF; border-radius: 50px; border: 1px solid #F1F5F9; min-height: 200px; }
        .input-style { background: #F8FAFC; border: 1.5px solid #F1F5F9; border-radius: 20px; transition: all 0.3s; }
        .input-style:focus { border-color: #064E3B; outline: none; background: white; }
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
                <a href="dashboard_admin.php" class="nav-item">
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
                <a href="siaran_notifikasi.php" class="nav-item active">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
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

    <main class="flex-1 ml-[270px] p-10">
        <header class="flex justify-between items-center mb-10">
            <div class="flex items-center gap-5">
                <a href="dashboard_admin.php" class="w-12 h-12 flex items-center justify-center bg-white border border-slate-100 rounded-2xl shadow-sm hover:bg-slate-50 transition-all">
                    <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Siaran Notifikasi</h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Rumah Singgah Management</p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-white p-2.5 pr-8 rounded-[24px] shadow-sm border border-slate-50">
                <div class="w-11 h-11 bg-[#064E3B] rounded-2xl flex items-center justify-center text-white font-black text-lg">A</div>
                <div class="text-sm">
                    <p class="font-black text-[#1A302A] leading-none text-[13px]">Admin Utama</p>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-wider mt-1.5 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Terhubung
                    </p>
                </div>
            </div>
        </header>

        <div class="content-card p-12 shadow-sm mb-10">
            <div class="max-w-2xl mx-auto mb-16">
                <h3 class="text-center text-lg font-black text-slate-800 mb-8 uppercase tracking-widest">Kirim Pengumuman Baru</h3>
                <form action="" method="POST" class="space-y-6">
                    <textarea name="pesan_notif" rows="4" class="w-full input-style p-6 text-sm font-semibold text-slate-600" placeholder="Tulis pesan untuk semua user..." required></textarea>
                    <button type="submit" name="kirim_notif" class="w-full py-4 bg-[#064E3B] text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-900/20 hover:bg-[#053d2e] transition-all">
                        Siarkan Sekarang
                    </button>
                </form>
            </div>

            <div class="border-t border-slate-50 pt-10">
                <div class="grid grid-cols-4 px-6 mb-6">
                    <div class="text-[11px] font-black text-slate-300 uppercase tracking-[0.2em]">Waktu</div>
                    <div class="col-span-2 text-[11px] font-black text-slate-300 uppercase tracking-[0.2em]">Isi Pengumuman</div>
                    <div class="text-[11px] font-black text-slate-300 uppercase tracking-[0.2em] text-center">Kelola</div>
                </div>

                <div class="space-y-4">
                    <?php if(mysqli_num_rows($query_notif) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($query_notif)): ?>
                        <div class="flex items-center justify-between bg-slate-50/50 p-6 rounded-[30px] border border-slate-50 group hover:bg-slate-50 transition-all duration-300">
                            <div class="w-1/4">
                                <p class="text-sm font-black text-slate-800"><?= date('d M Y', strtotime($row['waktu'])) ?></p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter"><?= date('H:i', strtotime($row['waktu'])) ?> WITA</p>
                            </div>
                            <div class="w-2/4">
                                <p class="text-sm font-semibold text-slate-600">"<?= $row['pesan'] ?>"</p>
                            </div>
                            <div class="w-1/4 flex justify-center">
                                <button onclick="hapusNotif(<?= $row['id'] ?>)" class="w-11 h-11 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-10 opacity-30 text-[11px] font-black uppercase tracking-widest">Belum Ada Riwayat</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        function hapusNotif(id) {
            Swal.fire({
                title: '<span style="font-family:Plus Jakarta Sans; font-weight:800">Hapus?</span>',
                text: "Pengumuman ini akan hilang permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064E3B',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?hapus=' + id;
                }
            })
        }

        <?php if($notif_sent): ?>
        Swal.fire({
            icon: 'success',
            title: '<span style="font-family:Plus Jakarta Sans; font-weight:800">BERHASIL!</span>',
            text: 'Notifikasi telah dikirim ke menu user.',
            confirmButtonColor: '#064E3B',
            borderRadius: '25px'
        });
        <?php endif; ?>
    </script>
</body>
</html>