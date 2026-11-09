<?php
session_start();
include 'user/config.php';

// --- LOGIKA BACKEND ---
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $act = $_GET['action'];

    if ($act == 'acc') {
        mysqli_query($conn, "UPDATE izin_keluar SET status='Disetujui' WHERE id='$id'");
    } elseif ($act == 'tolak') {
        mysqli_query($conn, "UPDATE izin_keluar SET status='Ditolak' WHERE id='$id'");
    } elseif ($act == 'hapus') {
        mysqli_query($conn, "DELETE FROM izin_keluar WHERE id='$id'");
    }
    header("Location: data_izin.php?status=success");
    exit;
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Izin - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { background-color: #F9FBFC; font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        
        /* SIDEBAR SISTEM COLLAPSE CERDAS */
        .sidebar { 
            width: 270px; background: #FFFFFF; border-right: 1px solid #F1F5F9;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar.collapsed { width: 100px; padding: 24px 15px; }
        
        /* Sembunyikan teks saat collapsed, tapi biarkan ikon tetap ada */
        .sidebar.collapsed .nav-text, 
        .sidebar.collapsed .logo-text, 
        .sidebar.collapsed .category-label { 
            display: none; 
        }

        /* Pusatkan ikon saat sidebar mengecil */
        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 14px 0;
            gap: 0;
        }

        .sidebar.collapsed .logo-area {
            justify-content: center;
            padding: 0;
        }
        
        .content-area { transition: all 0.4s ease; margin-left: 270px; }
        .content-area.expanded { margin-left: 100px; }

        .nav-item {
            display: flex; align-items: center; gap: 14px; padding: 14px 20px;
            border-radius: 20px; color: #64748b; font-weight: 600; font-size: 14px;
            transition: all 0.3s; margin-bottom: 6px; text-decoration: none;
        }
        .nav-item:hover { background: #F8FAFC; color: #064E3B; transform: translateX(4px); }
        .nav-item.active { background: #064E3B; color: #FFFFFF; box-shadow: 0 12px 20px -5px rgba(6, 78, 59, 0.25); }

        .card-table { background: #FFFFFF; border-radius: 40px; padding: 40px; border: 1px solid #F1F5F9; }
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
                <a href="data_izin.php" class="nav-item active">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="nav-text">Izin Kunjungan</span>
                </a>
            </nav>

            <p class="text-[10px] font-extrabold text-slate-300 uppercase tracking-[0.25em] mb-4 px-4 category-label">Komunikasi</p>
            <nav class="mb-8">
                <a href="siaran_notifikasi.php" class="nav-item w-full text-left group">
                    <svg class="w-6 h-6 shrink-0 group-hover:text-emerald-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="nav-text group-hover:text-emerald-600 transition-colors">Siarkan Notifikasi</span>
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
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Data Izin Kunjungan</h2>
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

        <div class="card-table shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[11px] font-black text-slate-300 uppercase tracking-[0.2em] border-b border-slate-50">
                            <th class="pb-8 pl-4">Nama Lengkap</th>
                            <th class="pb-8">Keperluan</th>
                            <th class="pb-8 text-center">Status</th>
                            <th class="pb-8 text-right pr-6">Kelola</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM izin_keluar ORDER BY id DESC");
                        while($row = mysqli_fetch_assoc($query)):
                        ?>
                        <tr class="group hover:bg-slate-50 transition-all duration-300">
                            <td class="py-7 pl-4 font-black text-slate-800 tracking-tight text-lg"><?= $row['nama_lengkap'] ?></td>
                            <td class="py-7 text-slate-500 font-medium italic">"<?= $row['keperluan'] ?>"</td>
                            <td class="py-7 text-center">
                                <span class="px-5 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest 
                                <?= ($row['status'] == 'Disetujui' ? 'bg-emerald-50 text-emerald-600' : ($row['status'] == 'Ditolak' ? 'bg-red-50 text-red-600' : 'bg-orange-50 text-orange-500')) ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td class="py-7 pr-4">
                                <div class="flex justify-end gap-3">
                                    <?php if($row['status'] == 'Pending'): ?>
                                    <a href="?action=acc&id=<?= $row['id'] ?>" class="w-11 h-11 bg-[#064E3B] text-white rounded-2xl flex items-center justify-center hover:scale-110 shadow-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg></a>
                                    <a href="?action=tolak&id=<?= $row['id'] ?>" class="w-11 h-11 bg-red-500 text-white rounded-2xl flex items-center justify-center hover:scale-110 shadow-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg></a>
                                    <?php endif; ?>
                                    <button onclick="confirmHapus(<?= $row['id'] ?>)" class="w-11 h-11 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-all"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('content').classList.toggle('expanded');
        }
        function confirmHapus(id) {
            Swal.fire({
                title: '<span style="font-family:Plus Jakarta Sans; font-weight:800">Hapus Data?</span>',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064E3B',
                confirmButtonText: 'Ya, Hapus!',
                borderRadius: '30px'
            }).then((result) => { if (result.isConfirmed) { window.location.href = "?action=hapus&id=" + id; } })
        }
    </script>
</body>
</html>