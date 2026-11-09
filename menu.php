<?php
ob_start();
session_start();

if (file_exists('user/config.php')) {
    include 'user/config.php';
} else {
    die("Error: File user/config.php tidak ditemukan!");
}

if (!isset($conn) || !$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Dashboard - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        html, body { 
            background-color: #064e3b; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #ffffff;
            margin: 0; padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        .bg-glow { position: fixed; inset: 0; background: radial-gradient(circle at 50% 50%, #053a2a 0%, transparent 70%); z-index: -1; }
        .app-wrapper { display: flex; flex-direction: column; min-height: 100vh; width: 100%; }
        
        .content-area { 
            flex: 1; display: flex; flex-direction: column; 
            padding: 20px 24px 80px 24px; gap: 1.5rem; 
            width: 100%; margin: 0 auto;
        }

        @media (min-width: 1024px) {
            .content-area { max-width: 1000px; }
            .grid-menu { grid-template-columns: repeat(4, minmax(0, 1fr)) !important; }
        }
        @media (max-width: 1023px) {
            .content-area { max-width: 450px; }
            .grid-menu { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; }
        }

        .glass-card { 
            background: rgba(255, 255, 255, 0.04); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1rem; 
            aspect-ratio: 1 / 0.82; display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: all 0.3s ease; text-decoration: none;
        }
        .glass-card:hover { border-color: rgba(250, 204, 21, 0.5); transform: translateY(-5px); background: rgba(255, 255, 255, 0.1); }
        
        .footer-container { text-align: center; margin-top: auto; padding-bottom: 2.5rem; }
        .copyright-text { 
            font-size: 9px; 
            font-weight: 400; 
            text-transform: uppercase; 
            letter-spacing: 0.15em; 
            color: rgba(255, 255, 255, 0.5); 
            display: inline-block;
        }

        .engineer-text { font-weight: 600; color: rgba(255, 255, 255, 0.85); }
        .online-dot { width: 6px; height: 6px; background-color: #10b981; border-radius: 50%; box-shadow: 0 0 8px #10b981; animation: pulse-dot 2s infinite; }
        @keyframes pulse-dot { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        @keyframes revealUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .animate-reveal { animation: revealUp 0.6s ease forwards; opacity: 0; }

        /* --- NOTIFIKASI ULTRA PREMIUM (STYLE BARU) --- */
        .notif-glass-ultra {
            background: rgba(15, 23, 42, 0.85) !important;
            backdrop-filter: blur(25px) saturate(200%) !important;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .beam-container { position: relative; overflow: hidden; }
        .beam-container::before {
            content: "";
            position: absolute;
            top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: conic-gradient(from 0deg, transparent, #fbbf24, #f59e0b, transparent 40%);
            animation: rotate-beam 5s linear infinite;
            z-index: -1;
        }

        @keyframes rotate-beam {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes dynamic-island-in {
            0% { transform: translateY(-40px) scale(0.8); opacity: 0; filter: blur(10px); }
            70% { transform: translateY(10px) scale(1.02); }
            100% { transform: translateY(0) scale(1); opacity: 1; filter: blur(0); }
        }

        .animate-premium-in { animation: dynamic-island-in 0.7s cubic-bezier(0.19, 1, 0.22, 1) forwards; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <div id="notif-container" class="fixed top-6 left-0 right-0 z-[100] px-6 pointer-events-none flex justify-center">
        <div id="notif-bar" class="hidden animate-premium-in beam-container notif-glass-ultra w-full max-w-md rounded-[32px] p-[2px] pointer-events-auto">
            <div class="bg-[#0f172a]/95 rounded-[30px] p-4 flex items-center gap-4">
                <div class="relative shrink-0">
                    <div class="absolute inset-0 bg-yellow-400 blur-xl opacity-30 animate-pulse"></div>
                    <div class="relative w-11 h-11 bg-gradient-to-tr from-yellow-500 to-orange-400 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/40 transform rotate-3">
                        <svg class="w-6 h-6 text-[#064e3b]" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-0.5">
                        <div class="h-1.5 w-1.5 rounded-full bg-yellow-400 shadow-[0_0_8px_#fbbf24] animate-pulse"></div>
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-yellow-400/90">System Notification</p>
                    </div>
                    <p id="notif-text" class="text-sm font-bold text-white/95 leading-tight tracking-tight italic"></p>
                </div>
                <button onclick="closeNotif()" class="w-9 h-9 flex items-center justify-center bg-white/5 hover:bg-white/10 active:scale-90 rounded-full text-white/30 hover:text-white transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="app-wrapper">
        <nav class="w-full border-b-2 border-yellow-400 bg-white/90 backdrop-blur-xl sticky top-0 z-50">
            <div class="mx-auto px-6 py-3 flex justify-between items-center max-w-7xl">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-800" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                    <span class="text-emerald-900/20">|</span>
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-emerald-900">Rumah Singgah</span>
                </div>
                <div class="flex items-center gap-2 bg-emerald-900/10 px-3 py-1 rounded-full border border-emerald-900/5">
                    <div class="online-dot"></div>
                    <div id="clock" class="text-[10px] font-bold text-emerald-800">00:00:00</div>
                </div>
            </div>
        </nav>

        <div class="content-area">
            <div class="header-text text-left mt-2 animate-reveal" style="animation-delay: 0.1s;">
                <h1 class="text-3xl font-black italic uppercase tracking-tighter leading-none mb-1">Selamat Datang! 👋</h1>
                <p class="text-[8px] text-white/20 font-bold tracking-[0.4em] uppercase">Rumah Singgah Management</p>
            </div>

            <a href="izin_keluar.php" class="animate-reveal w-full bg-[#22c55e] py-4 px-6 rounded-2xl flex justify-between items-center shadow-lg active:scale-95 transition-all" style="animation-delay: 0.2s;">
                <div class="text-left">
                    <h2 class="font-black uppercase tracking-widest text-[10px] text-white">Izin Keluar</h2>
                    <p class="text-[8px] text-white/80 italic">Lapor keperluan anda di sini</p>
                </div>
                <div class="bg-white/10 p-2 rounded-lg">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
            </a>

            <div class="grid-menu grid gap-3 animate-reveal" style="animation-delay: 0.3s;">
                <a href="daftar.php" class="glass-card">
                    <div class="w-10 h-10 bg-emerald-600 rounded-xl flex items-center justify-center text-white mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 019 21.25a12.317 12.317 0 01-6-2.015z" /></svg>
                    </div>
                    <span class="text-[8px] font-black uppercase tracking-widest text-white/60 text-center">Daftar Tamu</span>
                </a>

                <a href="wifi.php" class="glass-card">
                    <div class="w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center text-emerald-900 mb-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M8.288 15.038a5.25 5.25 0 017.424 0M5.106 11.856a9.75 9.75 0 0113.788 0M1.924 8.674a14.25 14.25 0 0120.152 0M12 18.75h.007v.008H12v-.008z" /></svg>
                    </div>
                    <span class="text-[8px] font-black uppercase tracking-widest text-white/60 text-center">Akses WiFi</span>
                </a>
                
                <a href="lacak_kapal.php" class="glass-card">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white mb-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20 21c-1.39 0-2.78-.47-4-1.32-2.44 1.71-5.56 1.71-8 0C6.78 20.53 5.39 21 4 21H2v2h2c1.38 0 2.74-.35 4-.99 2.52 1.29 5.48 1.29 8 0 1.26.64 2.62.99 4 .99h2v-2h-2zM3.95 19H4c1.6 0 3.11-.55 4.35-1.56.23-.18.47-.35.73-.49.11-.06.22-.11.33-.16.14-.07.28-.13.42-.19.53-.2 1.1-.3 1.67-.3s1.14.1 1.67.3c.14.06.28.12.42.19.11.05.22.1.33.16.26.14.5.31.73.49C15.89 18.45 17.4 19 19 19h.05l1.2-5.25c.1-.42-.04-.87-.38-1.15l-7.87-6.52V2h-2v4.08L2.13 12.6c-.34.28-.48.73-.38 1.15L3.95 19z"/></svg>
                    </div>
                    <span class="text-[8px] font-black uppercase tracking-widest text-white/60 text-center">Lacak Kapal</span>
                </a>

                <a href="speed.php" class="glass-card">
                    <div class="w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center text-emerald-900 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-[8px] font-black uppercase tracking-widest text-white/60 text-center">Kecepatan</span>
                </a>

                <a href="rules.php" class="glass-card">
                    <div class="w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center text-emerald-900 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <span class="text-[8px] font-black uppercase tracking-widest text-white/60 text-center">Tata Tertib</span>
                </a>

                <a href="maps.php" class="glass-card">
                    <div class="w-10 h-10 bg-red-500 rounded-xl flex items-center justify-center text-white mb-2">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"></path></svg>
                    </div>
                    <span class="text-[8px] font-black uppercase tracking-widest text-white/60 text-center">Maps</span>
                </a>
            </div>

            <div class="footer-container animate-reveal" style="animation-delay: 0.5s;">
                <p class="copyright-text">© 2026 RAHMAT | <span class="engineer-text">IT SOFTWARE ENGINEER</span></p>
            </div>
        </div>
    </div>

    <script>
        function updateTime() {
            const now = new Date();
            document.getElementById('clock').textContent = now.toLocaleTimeString('id-ID', { hour12: false });
        }
        setInterval(updateTime, 1000); updateTime();

        let lastNotifId = localStorage.getItem('last_notif_id') || 0;

        function checkNotification() {
            fetch('get_notif.php')
                .then(response => response.json())
                .then(data => {
                    if (data && data.id > lastNotifId) {
                        showNotif(data.pesan);
                        lastNotifId = data.id;
                        localStorage.setItem('last_notif_id', data.id);
                    }
                })
                .catch(err => console.log("Cek notif offline..."));
        }

        function showNotif(pesan) {
            const bar = document.getElementById('notif-bar');
            document.getElementById('notif-text').innerText = pesan;
            
            bar.classList.remove('hidden');
            bar.classList.add('flex');
            
            const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3');
            audio.volume = 0.15;
            audio.play();

            setTimeout(closeNotif, 12000);
        }

        function closeNotif() {
            const bar = document.getElementById('notif-bar');
            bar.style.transition = 'all 0.6s cubic-bezier(0.19, 1, 0.22, 1)';
            bar.style.transform = 'translateY(-100px) scale(0.9)';
            bar.style.opacity = '0';
            bar.style.filter = 'blur(10px)';
            
            setTimeout(() => {
                bar.classList.add('hidden');
                bar.style.transform = '';
                bar.style.opacity = '1';
                bar.style.filter = '';
            }, 600);
        }

        setInterval(checkNotification, 5000);
        checkNotification();
    </script>
</body>
</html>