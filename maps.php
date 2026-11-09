<?php
session_start();
// Koordinat Lokasi (Masjid Raya Sabilal Muhtadin)
$lat = "-3.3189504";
$lng = "114.5912445";
$location_name = "RUMAH SINGGAH";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Location - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800;900&display=swap" rel="stylesheet">
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
            max-width: 500px; margin: 0 auto; width: 100%;
        }

        /* MAP CARD DENGAN HOVER ANIMATION */
        .map-card { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(25px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 2rem; padding: 1rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            margin-bottom: 1.5rem;
            height: 380px;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .map-card:hover {
            transform: scale(1.02);
            border-color: #facc15;
        }

        iframe {
            width: 100%;
            height: 100%;
            border-radius: 1.5rem;
            border: 0;
        }

        .btn-back {
            font-size: 8px; font-weight: 800; color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase; letter-spacing: 0.2em;
            text-decoration: none; border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 3px; transition: all 0.3s ease;
            display: inline-block; margin-bottom: 2rem;
        }

        .btn-back:hover { color: #facc15; border-bottom: 1px solid #facc15; }

        /* COPYRIGHT MINIMALIS */
        .copyright-text {
            font-size: 9px;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.7);
        }

        .copyright-dev { font-weight: 400; color: #ffffff; }

        /* KEYFRAMES ANIMASI REVEAL */
        @keyframes revealUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-reveal {
            animation: revealUp 0.8s cubic-bezier(0.23, 1, 0.32, 1) forwards;
            opacity: 0;
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.3s; }
        .delay-3 { animation-delay: 0.5s; }
        .delay-4 { animation-delay: 0.7s; }
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
            <div class="text-center mb-6 animate-reveal delay-1">
                <div class="flex items-center justify-center gap-3 mb-1">
                    <h1 class="text-3xl font-black italic uppercase tracking-tighter text-white">Live Location</h1>
                    <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <p class="text-[8px] text-yellow-400 font-bold tracking-[0.4em] uppercase">Satelite View Mode</p>
            </div>

            <div class="map-card animate-reveal delay-2">
                <iframe 
                    src="https://maps.google.com/maps?q=<?php echo $lat; ?>,<?php echo $lng; ?>&t=k&z=17&ie=UTF8&iwloc=&output=embed" 
                    frameborder="0" 
                    allowfullscreen>
                </iframe>
            </div>

            <div class="text-center animate-reveal delay-3">
                <a href="menu.php" class="btn-back">KEMBALI KE DASHBOARD</a>
            </div>

            <footer class="text-center mt-4 animate-reveal delay-4">
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