<?php
session_start();
include 'user/config.php';

// --- LOGIKA TAMBAH USER (AMAN DARI SQL INJECTION) ---
$user_added = false;
if (isset($_POST['tambah_user'])) {
    $username = $_POST['username'];
    // Menggunakan password_hash agar password tidak tersimpan dalam teks biasa
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $role = $_POST['role'];

    // Menggunakan Prepared Statement
    $stmt = $conn->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    
    if ($stmt->execute()) {
        $user_added = true;
    }
    $stmt->close();
}

// --- LOGIKA HAPUS USER (AMAN DARI SQL INJECTION) ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    
    $stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>window.location.href='kelola_user.php';</script>";
    }
    $stmt->close();
    exit();
}

// Ambil data user untuk tabel
$query_user = mysqli_query($conn, "SELECT * FROM user ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Rumah Singgah</title>
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

        .card-table { background: #FFFFFF; border-radius: 40px; padding: 40px; border: 1px solid #F1F5F9; }
        .input-style { background: #F8FAFC; border: 1.5px solid #F1F5F9; border-radius: 15px; transition: all 0.3s; }
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
                <a href="siaran_notifikasi.php" class="nav-item">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="nav-text">Siarkan Notifikasi</span>
                </a>
            </nav>

            <p class="text-[10px] font-extrabold text-slate-300 uppercase tracking-[0.25em] mb-4 px-4 category-label">Administrasi</p>
            <nav>
                <a href="kelola_user.php" class="nav-item active">
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
            <span class="nav-text font-black uppercase text-xs tracking-widest text-red-500">Log Out</span>
        </a>
    </aside>

    <main class="flex-1 ml-[270px] p-10">
        <header class="flex justify-between items-center mb-10">
            <div class="flex items-center gap-5">
                <div class="w-12 h-12 flex items-center justify-center bg-white border border-slate-100 rounded-2xl shadow-sm">
                    <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">Manajemen User</h2>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Rumah Singgah Management</p>
                </div>
            </div>
            
            <button onclick="openModal()" class="flex items-center gap-2 px-6 py-3 bg-[#064E3B] text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-900/20 hover:scale-105 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
                Tambah User
            </button>
        </header>

        <div class="card-table shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[11px] font-black text-slate-300 uppercase tracking-[0.2em] border-b border-slate-50">
                            <th class="pb-8 pl-4">Username</th>
                            <th class="pb-8">Hak Akses / Role</th>
                            <th class="pb-8 text-center">Status</th>
                            <th class="pb-8 text-right pr-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(mysqli_num_rows($query_user) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($query_user)): ?>
                            <tr class="group hover:bg-slate-50 transition-all duration-300">
                                <td class="py-7 pl-4">
                                    <p class="text-[16px] font-black text-slate-800 tracking-tight"><?= htmlspecialchars($row['username']) ?></p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-widest">ID-USER-0<?= $row['id'] ?></p>
                                </td>
                                <td class="py-7">
                                    <span class="px-4 py-1.5 <?= $row['role'] == 'admin' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-blue-50 text-blue-700 border-blue-100' ?> rounded-full text-[10px] font-black uppercase tracking-widest border">
                                        <?= htmlspecialchars($row['role']) ?>
                                    </span>
                                </td>
                                <td class="py-7 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                        <span class="text-[11px] font-bold text-slate-500 uppercase tracking-tighter">Aktif</span>
                                    </div>
                                </td>
                                <td class="py-7 pr-6 text-right">
                                    <button onclick="hapusUser(<?= $row['id'] ?>)" class="w-11 h-11 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-all ml-auto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-20 text-center opacity-30 text-[11px] font-black uppercase tracking-widest">Tidak ada data user</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="modalUser" class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/20 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-md rounded-[40px] shadow-2xl p-10 animate-in fade-in zoom-in duration-300">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xl font-black text-slate-800 tracking-tight">User Baru</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <form action="" method="POST" class="space-y-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Username</label>
                    <input type="text" name="username" class="w-full input-style p-4 text-sm font-bold text-slate-600" placeholder="Masukkan username..." required>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Password</label>
                    <input type="password" name="password" class="w-full input-style p-4 text-sm font-bold text-slate-600" placeholder="••••••••" required>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Role Akses</label>
                    <select name="role" class="w-full input-style p-4 text-sm font-bold text-slate-600 appearance-none cursor-pointer">
                        <option value="admin">Admin Utama</option>
                        <option value="petugas">Petugas Lapangan</option>
                    </select>
                </div>
                <button type="submit" name="tambah_user" class="w-full py-4 bg-[#064E3B] text-white rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-900/20 hover:bg-[#053d2e] transition-all pt-5">
                    Simpan Akun
                </button>
            </form>
        </div>
    </div>

    <script>
        function openModal() { document.getElementById('modalUser').classList.remove('hidden'); }
        function closeModal() { document.getElementById('modalUser').classList.add('hidden'); }

        // Menutup modal jika klik di luar modal
        window.onclick = function(event) {
            let modal = document.getElementById('modalUser');
            if (event.target == modal) closeModal();
        }

        function hapusUser(id) {
            Swal.fire({
                title: '<span style="font-family:Plus Jakarta Sans; font-weight:800">Hapus Akun?</span>',
                text: "User ini tidak akan bisa login lagi ke sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064E3B',
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '25px'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '?hapus=' + id;
                }
            })
        }

        <?php if($user_added): ?>
        Swal.fire({
            icon: 'success',
            title: '<span style="font-family:Plus Jakarta Sans; font-weight:800">BERHASIL!</span>',
            text: 'User baru telah berhasil ditambahkan.',
            confirmButtonColor: '#064E3B',
            borderRadius: '25px'
        });
        <?php endif; ?>
    </script>
</body>
</html>