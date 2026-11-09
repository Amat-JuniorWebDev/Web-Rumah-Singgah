<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Lacak Kapal - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        html, body { 
            background-color: #064e3b; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            color: #ffffff;
            margin: 0; padding: 0;
            height: 100vh; overflow: hidden; 
        }
        
        .bg-glow { position: fixed; inset: 0; background: radial-gradient(circle at 50% 50%, #053a2a 0%, transparent 70%); z-index: -1; }

        .app-wrapper {
            display: flex; flex-direction: column;
            height: 100%; width: 100%;
        }

        .navbar-white {
            background: rgba(244, 244, 245, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 2px solid #facc15;
            width: 100%;
        }

        .content-area {
            flex: 1; display: flex; flex-direction: column;
            justify-content: center; padding: 20px;
            max-width: 450px; margin: 0 auto; width: 100%;
        }

        /* Option Cards */
        .option-card { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(25px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 2rem; padding: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            margin-bottom: 1rem;
            display: flex; align-items: center; justify-content: space-between;
            text-decoration: none; transition: all 0.3s ease;
        }

        .option-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
            border-color: #facc15;
        }

        .icon-box {
            width: 45px; height: 45px;
            background: rgba(250, 204, 21, 0.1);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #facc15;
        }

        .btn-back {
            font-size: 8px; font-weight: 800; color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase; letter-spacing: 0.2em;
            text-decoration: none; border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 3px; transition: all 0.3s ease;
            display: inline-block; margin-bottom: 2rem;
            margin-top: 1rem;
        }

        .btn-back:hover { color: #facc15; border-bottom: 1px solid #facc15; }

        /* COPYRIGHT - WHITE & THIN */
        .copyright-text {
            font-size: 9px;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.7);
        }

        .copyright-dev { font-weight: 400; color: #ffffff; }

        /* KEYFRAMES ANIMASI */
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
            <div class="text-center mb-8 animate-reveal delay-1">
                <div class="flex items-center justify-center gap-3 mb-1">
                    <h1 class="text-3xl font-black italic uppercase tracking-tighter text-white">Ship Tracking</h1>
                    
                    <span class="text-3xl">🚢</span>
                </div>
                <p class="text-[8px] text-yellow-400 font-bold tracking-[0.4em] uppercase">Pilih Server Pelacakan</p>
            </div>

            <a href="https://www.marinetraffic.com" target="_blank" class="option-card animate-reveal delay-2">
                <div class="flex items-center gap-4">
                    <div class="icon-box">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A2 2 0 013 15.488V5.512a2 2 0 011.553-1.954L9 2l5.447 2.724A2 2 0 0116 6.676v9.812a2 2 0 01-1.553 1.954L9 20z"/></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-white uppercase tracking-wider">Option 01</div>
                        <div class="text-lg font-black text-white -mt-1">MARINE TRAFFIC</div>
                    </div>
                </div>
                <svg class="w-5 h-5 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </a>

            <a href="https://www.vesselfinder.com" target="_blank" class="option-card animate-reveal delay-3">
                <div class="flex items-center gap-4">
                    <div class="icon-box">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-white uppercase tracking-wider">Option 02</div>
                        <div class="text-lg font-black text-white -mt-1">VESSEL FINDER</div>
                    </div>
                </div>
                <svg class="w-5 h-5 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
            </a>

            <div class="text-center mt-4 animate-reveal delay-4">
                <a href="menu.php" class="btn-back">KEMBALI KE DASHBOARD</a>
            </div>

            <footer class="text-center mt-4 animate-reveal delay-5">
                <p class="copyright-text">
                    © 2026 RAHMAT | <span class="copyright-dev">IT SOFTWARE ENGINEER</span>
                </p>
            </footer>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const timeStr = now.getHours().toString().padStart(2, '0') + "." + 
                            now.getMinutes().toString().padStart(2, '0') + "." + 
                            now.getSeconds().toString().padStart(2, '0');
            const el = document.getElementById('clock');
            if(el) el.textContent = timeStr;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>