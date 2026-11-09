<?php
session_start();

// Konfigurasi Admin 1
$nama_admin1 = "Pemilik Rumah";
$nomor_admin1 = "6281254529710"; // GANTI NOMOR DISINI
$pesan_admin1 = "Assalamualaikum Mama Nadia, saya ingin bertanya...";
$url_wa1 = "https://api.whatsapp.com/send?phone=" . $nomor_admin1 . "&text=" . urlencode($pesan_admin1);

// Konfigurasi Admin 2
$nama_admin2 = "IT Developer";
$nomor_admin2 = "6282152316910"; // GANTI NOMOR DISINI
$pesan_admin2 = "Halo Rahmat, saya butuh bantuan teknis...";
$url_wa2 = "https://api.whatsapp.com/send?phone=" . $nomor_admin2 . "&text=" . urlencode($pesan_admin2);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Hubungi Kami - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        html, body { 
            background-color: #064e3b; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #ffffff;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden; 
        }
        
        .bg-glow { position: fixed; inset: 0; background: radial-gradient(circle at 50% 50%, #053a2a 0%, transparent 70%); z-index: -1; }

        .app-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
            margin: 0 auto;
        }

        /* NAVBAR PUTIH GARIS KUNING */
        .navbar-white {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 2px solid #facc15;
        }

        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center; 
            padding: 20px 24px;
            gap: 1rem;
            max-width: 450px; 
            margin: 0 auto;
            width: 100%;
        }

        .contact-card { 
            background: rgba(255, 255, 255, 0.04); 
            backdrop-filter: blur(20px); 
            border: 1px solid rgba(250, 204, 21, 0.4); 
            border-radius: 1.5rem; 
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            text-decoration: none;
            position: relative;
        }

        .contact-card:hover { 
            border-color: #facc15; 
            transform: scale(1.05) translateY(-5px); 
            background: rgba(255, 255, 255, 0.08); 
            z-index: 10;
            box-shadow: 0 10px 30px rgba(250, 204, 21, 0.1);
        }

        .icon-box {
            width: 45px;
            height: 45px;
            background: #facc15;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        @keyframes revealUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-reveal {
            animation: revealUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards;
            opacity: 0;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }

        .copyright-text {
            font-size: 9px;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.6);
        }

        .copyright-dev {
            font-weight: 400;
            color: #ffffff;
        }

        @media (min-width: 1024px) {
            .content-area { max-width: 800px !important; }
            .grid-contact { grid-template-columns: repeat(2, 1fr) !important; display: grid; gap: 20px; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <div class="app-wrapper">
        <nav class="w-full navbar-white sticky top-0 z-50">
            <div class="mx-auto px-6 py-3 flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-800" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 00-1.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    <span class="text-emerald-900/20">|</span>
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-emerald-900">Rumah Singgah</span>
                </div>
                <div class="bg-emerald-900/10 px-3 py-1 rounded-full border border-emerald-900/5 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></div>
                    <div id="clock" class="text-[10px] font-black text-emerald-800 uppercase tracking-widest">00.00.00</div>
                </div>
            </div>
        </nav>

        <div class="content-area">
            <div class="text-center mb-4 animate-reveal delay-1">
                <h1 class="text-3xl font-black italic uppercase tracking-tighter leading-none mb-2">
                    Pilih Admin 📱
                </h1>
                <p class="text-[9px] text-yellow-400 font-bold tracking-[0.4em] uppercase">
                    Hubungi Layanan Bantuan
                </p>
            </div>

            <div class="grid-contact flex flex-col gap-4">
                <a href="<?php echo $url_wa1; ?>" target="_blank" class="contact-card animate-reveal delay-2">
                    <div class="icon-box">
                        <svg class="w-6 h-6 text-emerald-900" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08s5.97 1.09 6 3.08c-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                    </div>
                    <div class="flex-1 text-left">
                        <h3 class="text-sm font-black uppercase tracking-tight"><?php echo $nama_admin1; ?></h3>
                        <p class="text-[9px] text-white/40 uppercase font-bold tracking-widest">Layanan Umum</p>
                    </div>
                    <svg class="w-4 h-4 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>

                <a href="<?php echo $url_wa2; ?>" target="_blank" class="contact-card animate-reveal delay-3">
                    <div class="icon-box bg-blue-500">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1h-1v11h1V1zM11 16h1v-2h-1v2zM19.74 5.24l-.71.71c1.5 1.5 2.47 3.63 2.47 6.05 0 4.97-4.03 9-9 9s-9-4.03-9-9c0-2.42.97-4.55 2.47-6.05l-.71-.71C3.31 6.83 2 9.27 2 12c0 5.52 4.48 10 10 10s10-4.48 10-10c0-2.73-1.31-5.17-3.26-6.76z"/></svg>
                    </div>
                    <div class="flex-1 text-left">
                        <h3 class="text-sm font-black uppercase tracking-tight"><?php echo $nama_admin2; ?></h3>
                        <p class="text-[9px] text-white/40 uppercase font-bold tracking-widest">Bantuan Teknis</p>
                    </div>
                    <svg class="w-4 h-4 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <div class="text-center mt-6 animate-reveal delay-4">
                <a href="menu.php" class="text-[9px] font-black uppercase tracking-[0.2em] text-white/30 hover:text-yellow-400 transition-all underline underline-offset-4 decoration-white/5">
                    Kembali ke Dashboard
                </a>
            </div>

            <footer class="text-center mt-8 animate-reveal delay-5">
                <p class="copyright-text">
                    © 2026 RAHMAT | <span class="copyright-dev">IT SOFTWARE ENGINEER</span>
                </p>
            </footer>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { hour12: false }).replace(/:/g, '.');
            document.getElementById('clock').textContent = timeString;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>