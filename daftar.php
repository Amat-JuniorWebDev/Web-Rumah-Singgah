<?php
// 1. Memulai session & buffer
ob_start();
session_start();

// 2. Memanggil koneksi database
if (file_exists('user/config.php')) {
    include 'user/config.php';
} else {
    die("Error: File user/config.php tidak ditemukan!");
}

$status_pesan = "";

// 3. Proses Simpan Data Tamu (DISESUAIKAN DENGAN DATABASE)
if (isset($_POST['daftar_tamu'])) {
    $nama     = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $asal     = mysqli_real_escape_string($conn, $_POST['asal_instansi']);
    $tujuan   = mysqli_real_escape_string($conn, $_POST['tujuan_kunjungan']);
    $whatsapp = mysqli_real_escape_string($conn, $_POST['no_wa']);
    
    // Sesuaikan format tanggal dan jam untuk kolom database 'tanggal' dan 'jam'
    $tgl_skrg = date('Y-m-d');
    $jam_skrg = date('H:i:s');

    // Nama kolom disamakan: nama, telepon, instansi, tujuan, tanggal, jam
    $query = "INSERT INTO tamu (nama, telepon, instansi, tujuan, tanggal, jam) 
              VALUES ('$nama', '$whatsapp', '$asal', '$tujuan', '$tgl_skrg', '$jam_skrg')";

    if (mysqli_query($conn, $query)) {
        $status_pesan = "sukses";
    } else {
        $status_pesan = "gagal";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Daftar Tamu - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        html, body { 
            background-color: #064e3b; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #ffffff;
            margin: 0; padding: 0;
            min-height: 100vh;
        }
        .bg-glow { position: fixed; inset: 0; background: radial-gradient(circle at 50% 50%, #053a2a 0%, transparent 70%); z-index: -1; }
        
        .glass-input {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            transition: all 0.3s ease;
        }
        .glass-input:focus {
            border-color: #facc15;
            background: rgba(255, 255, 255, 0.1);
            outline: none;
        }

        .online-dot { width: 6px; height: 6px; background-color: #10b981; border-radius: 50%; box-shadow: 0 0 8px #10b981; animation: pulse-dot 2s infinite; }
        @keyframes pulse-dot { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }

        @keyframes revealUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-reveal { animation: revealUp 0.6s ease forwards; opacity: 0; }

        .footer-container { text-align: center; margin-top: 3rem; padding-bottom: 2.5rem; }
        .copyright-text { 
            font-size: 9px; 
            font-weight: 400; 
            text-transform: uppercase; 
            letter-spacing: 0.15em; 
            color: rgba(255, 255, 255, 0.5); 
            display: inline-block;
        }
        .engineer-text { font-weight: 600; color: rgba(255, 255, 255, 0.85); }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <nav class="w-full border-b-2 border-yellow-400 bg-white/90 backdrop-blur-xl sticky top-0 z-50">
        <div class="mx-auto px-6 py-3 flex justify-between items-center max-w-7xl">
            <div class="flex items-center gap-2">
                <a href="menu.php" class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-800" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    <span class="text-emerald-900/20">|</span>
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-emerald-900">Rumah Singgah</span>
                </a>
            </div>
            <div class="flex items-center gap-2 bg-emerald-900/10 px-3 py-1 rounded-full border border-emerald-900/5">
                <div class="online-dot"></div>
                <div id="clock" class="text-[10px] font-bold text-emerald-800">00:00:00</div>
            </div>
        </div>
    </nav>

    <div class="p-6">
        <div class="mb-6 animate-reveal" style="animation-delay: 0.1s;">
            <a href="menu.php" class="inline-flex items-center gap-2 text-white/50 hover:text-white transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                <span class="text-[10px] font-bold uppercase tracking-widest">Dashboard</span>
            </a>
        </div>

        <div class="max-w-sm mx-auto w-full">
            <div class="text-center mb-8 animate-reveal" style="animation-delay: 0.2s;">
                <div class="w-14 h-14 bg-yellow-400 rounded-2xl flex items-center justify-center text-emerald-900 mx-auto mb-4 shadow-lg shadow-yellow-400/20">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                </div>
                <h1 class="text-xl font-black uppercase italic leading-none">Pendaftaran Tamu</h1>
                <p class="text-[9px] text-white/30 font-bold uppercase tracking-[0.3em] mt-2">Rumah Singgah System</p>
            </div>

            <form action="" method="POST" class="space-y-4 animate-reveal" style="animation-delay: 0.3s;">
                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-white/30 uppercase ml-2">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" placeholder="Nama anda" required 
                           class="glass-input w-full p-3.5 rounded-xl text-xs font-medium">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-white/30 uppercase ml-2">Asal / Instansi</label>
                    <input type="text" name="asal_instansi" placeholder="Contoh: Adaro" required 
                           class="glass-input w-full p-3.5 rounded-xl text-xs font-medium">
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-white/30 uppercase ml-2">Tujuan Kunjungan</label>
                    <textarea name="tujuan_kunjungan" rows="2" placeholder="Keperluan anda" required 
                              class="glass-input w-full p-3.5 rounded-xl text-xs font-medium resize-none"></textarea>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[9px] font-bold text-white/30 uppercase ml-2">No. WhatsApp</label>
                    <input type="number" name="no_wa" placeholder="08..." required 
                           class="glass-input w-full p-3.5 rounded-xl text-xs font-medium">
                </div>

                <button type="submit" name="daftar_tamu" 
                        class="w-full py-4 bg-yellow-400 text-emerald-950 rounded-xl font-black text-[10px] uppercase tracking-widest shadow-lg active:scale-95 transition-all mt-2">
                    Daftar Sekarang
                </button>
            </form>

            <div class="footer-container animate-reveal" style="animation-delay: 0.5s;">
                <p class="copyright-text">© 2026 RAHMAT | <span class="engineer-text">IT SKAMUDA SYSTEM</span></p>
            </div>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', { hour12: false });
        }
        setInterval(updateTime, 1000); updateTime();
    </script>

    <?php if ($status_pesan == "sukses"): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Data Anda telah tersimpan.',
            background: '#064e3b',
            color: '#fff',
            confirmButtonColor: '#facc15'
        }).then(() => { window.location.href = 'menu.php'; });
    </script>
    <?php elseif ($status_pesan == "gagal"): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat menyimpan data.',
            background: '#064e3b',
            color: '#fff',
            confirmButtonColor: '#ef4444'
        });
    </script>
    <?php endif; ?>
</body>
</html>