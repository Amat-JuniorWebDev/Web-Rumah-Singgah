<?php
ob_start();
session_start();

// 1. Koneksi ke Config
if (file_exists('user/config.php')) {
    include 'user/config.php';
} else {
    die("Error: File user/config.php tidak ditemukan!");
}

if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}

// Nomor WhatsApp Admin (Ganti dengan nomor kamu)
$no_wa_admin = "6281234567890"; 

// 2. Proses Input Izin Web
if (isset($_POST['kirim_izin'])) {
    $nama_tamu = mysqli_real_escape_string($conn, $_POST['nama_tamu']); 
    $alasan = mysqli_real_escape_string($conn, $_POST['alasan']);
    $jam    = mysqli_real_escape_string($conn, $_POST['jam_kembali']);
    $keperluan_lengkap = "Alasan: " . $alasan . " | Kembali Jam: " . $jam;
    
    $query_izin = "INSERT INTO izin_keluar (username, nama_lengkap, keperluan, status) 
                   VALUES ('guest', '$nama_tamu', '$keperluan_lengkap', 'Pending')";
    
    if (mysqli_query($conn, $query_izin)) {
        header("Location: izin_keluar.php?view=waiting");
        exit;
    }
}

$view = isset($_GET['view']) ? $_GET['view'] : 'main';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Sistem Izin - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #064e3b; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #ffffff; 
            margin: 0;
            overflow-x: hidden;
        }
        .header-line { border-bottom: 2px solid #facc15; }
        .glass-box { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 2rem; 
        }
        .input-custom {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem;
            color: white;
            outline: none;
            transition: all 0.3s;
        }
        .input-custom:focus { border-color: #facc15; background: rgba(0, 0, 0, 0.3); }
        .btn-action { transition: all 0.2s; }
        .btn-action:active { transform: scale(0.96); }
        
        .btn-back-dashboard {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 9px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.3);
            transition: all 0.3s;
            margin-top: 2rem;
        }
        .btn-back-dashboard:hover { color: #facc15; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade { animation: fadeIn 0.5s ease forwards; }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <nav class="bg-white/95 backdrop-blur-md header-line sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="menu.php" class="p-1 hover:bg-emerald-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4 text-emerald-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </a>
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-900">Rumah Singgah</span>
            </div>
            <div class="text-[10px] font-bold text-slate-400 flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                <span id="clock">00:00:00</span>
            </div>
        </div>
    </nav>

    <div class="flex-1 flex flex-col items-center justify-center p-6 max-w-lg mx-auto w-full">
        
        <?php if ($view == 'main'): ?>
            <div class="w-full space-y-4 animate-fade flex flex-col items-center">
                <div class="text-center mb-10">
                    <h1 class="text-3xl font-black italic uppercase tracking-tighter">Izin Keluar <span class="text-yellow-400 underline">Tamu</span></h1>
                    <p class="text-[8px] font-bold text-white/30 uppercase tracking-[0.4em] mt-2 leading-none">Management System</p>
                </div>

                <a href="?view=form" class="btn-action glass-box w-full p-6 flex items-center gap-5 border-l-4 border-l-yellow-400">
                    <div class="bg-yellow-400/20 p-3 rounded-2xl text-yellow-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-[11px] font-black uppercase tracking-widest">Input System</h2>
                        <p class="text-[9px] text-white/40 italic">Izin melalui formulir website</p>
                    </div>
                </a>

                <a href="https://wa.me/<?= $no_wa_admin ?>?text=Halo%20Admin,%20saya%20ingin%20mengajukan%20izin%20keluar." class="btn-action glass-box w-full p-6 flex items-center gap-5 border-l-4 border-l-emerald-400">
                    <div class="bg-emerald-400/20 p-3 rounded-2xl text-emerald-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-4.821 4.754a8.117 8.117 0 0 1-3.876-.984l-.279-.165-2.87.752.766-2.796-.183-.29a8.102 8.102 0 0 1-1.248-4.386c0-4.49 3.652-8.14 8.141-8.14a8.13 8.13 0 0 1 5.756 2.388 8.13 8.13 0 0 1 2.383 5.753c0 4.491-3.651 8.141-8.14 8.141m5.753-13.891A11.393 11.393 0 0 0 12.651 2c-6.29 0-11.411 5.121-11.411 11.411 0 2.012.524 3.977 1.522 5.713L1.002 23l3.974-1.042a11.37 11.37 0 0 0 5.671 1.517h.005c6.289 0 11.41-5.121 11.41-11.411a11.36 11.36 0 0 0-3.341-8.062"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-[11px] font-black uppercase tracking-widest text-emerald-400">Direct WhatsApp</h2>
                        <p class="text-[9px] text-white/40 italic">Hubungi admin secara langsung</p>
                    </div>
                </a>

                <a href="?view=waiting" class="btn-action glass-box w-full p-6 flex items-center gap-5 border-l-4 border-l-blue-400">
                    <div class="bg-blue-400/20 p-3 rounded-2xl text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-[11px] font-black uppercase tracking-widest text-blue-400">Live Status</h2>
                        <p class="text-[9px] text-white/40 italic">Cek antrean data real-time</p>
                    </div>
                </a>

                <a href="menu.php" class="btn-back-dashboard">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
            </div>

        <?php elseif ($view == 'form'): ?>
            <div class="w-full flex flex-col items-center animate-fade">
                <div class="glass-box w-full p-8 text-center">
                    <p class="text-[9px] font-black text-yellow-400 uppercase tracking-widest mb-2">Form Pengajuan</p>
                    <h3 class="text-2xl font-black uppercase italic mb-8">ENTRY DATA</h3>
                    
                    <form action="" method="POST" class="space-y-4">
                        <input type="text" name="nama_tamu" placeholder="NAMA LENGKAP" required class="w-full input-custom p-4 text-[10px] font-bold text-center uppercase tracking-widest">
                        <select name="alasan" required class="w-full input-custom p-4 text-[10px] font-bold text-center uppercase tracking-widest appearance-none">
                            <option value="" disabled selected>PILIH KEPERLUAN</option>
                            <option value="Beli Makan">Beli Makan</option>
                            <option value="Keperluan Keluarga">Keperluan Keluarga</option>
                            <option value="Kegiatan Sekolah">Kegiatan Sekolah</option>
                        </select>
                        <input type="time" name="jam_kembali" required class="w-full input-custom p-4 text-[10px] font-bold text-center">
                        
                        <div class="pt-4">
                            <button type="submit" name="kirim_izin" class="w-full py-4 bg-yellow-400 text-emerald-900 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-lg shadow-yellow-400/20">Submit Permit</button>
                        </div>
                    </form>
                </div>

                <a href="izin_keluar.php" class="btn-back-dashboard">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Menu
                </a>
            </div>

        <?php elseif ($view == 'waiting'): ?>
            <div class="w-full animate-fade flex flex-col items-center">
                <h3 class="text-xl font-black text-center uppercase italic mb-8">Status <span class="text-blue-400 underline italic">Database</span></h3>
                <div class="w-full space-y-3">
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM izin_keluar ORDER BY id DESC LIMIT 5");
                    while($row = mysqli_fetch_assoc($query)):
                        $is_acc = ($row['status'] == 'Disetujui');
                        $color = $is_acc ? 'border-emerald-500 bg-emerald-500/10' : 'border-yellow-500/50 bg-white/5';
                    ?>
                    <div class="glass-box p-5 border-l-4 <?= $color ?> flex justify-between items-center">
                        <div>
                            <h4 class="text-[11px] font-black uppercase tracking-tight"><?= $row['nama_lengkap'] ?></h4>
                            <p class="text-[8px] text-white/30 italic uppercase mt-1 tracking-widest"><?= $row['keperluan'] ?></p>
                        </div>
                        <span class="text-[8px] font-black px-3 py-1.5 rounded-lg uppercase <?= $is_acc ? 'bg-emerald-500' : 'bg-yellow-400 text-emerald-900' ?>">
                            <?= $row['status'] ?>
                        </span>
                    </div>
                    <?php endwhile; ?>
                </div>
                
                <a href="izin_keluar.php" class="btn-back-dashboard">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Menu
                </a>
            </div>
        <?php endif; ?>

    </div>

    <footer class="p-10 text-center">
        <p class="text-[9px] font-black tracking-[0.2em] text-white/20 uppercase">
            © 2026 RAHMAT | <span class="text-white/40">IT SOFTWARE ENGINEER</span>
        </p>
    </footer>

    <script>
        function updateTime() { 
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', { hour12: false }); 
        }
        setInterval(updateTime, 1000); updateTime();

        <?php if($view == 'waiting'): ?>
        setTimeout(() => { location.reload(); }, 10000);
        <?php endif; ?>
    </script>
</body>
</html>