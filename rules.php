<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Tata Tertib - Rumah Singgah</title>
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
            max-width: 450px; margin: 0 auto; width: 100%;
        }

        .rules-card { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(25px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 2rem; padding: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            margin-bottom: 1.5rem;
        }

        .rule-item {
            display: flex; gap: 12px; margin-bottom: 12px;
            align-items: center;
        }

        .rule-number {
            background: #facc15; color: #064e3b;
            font-size: 10px; font-weight: 900;
            min-width: 20px; height: 20px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 6px;
        }

        .rule-text { font-size: 13px; font-weight: 500; color: rgba(255,255,255,0.9); }

        .btn-back {
            font-size: 8px; font-weight: 800; color: rgba(255, 255, 255, 0.3);
            text-transform: uppercase; letter-spacing: 0.2em;
            text-decoration: none; border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding-bottom: 3px; transition: all 0.3s ease;
            display: inline-block; margin-bottom: 2rem;
        }

        .btn-back:hover { color: #facc15; border-bottom: 1px solid #facc15; }

        .copyright-text {
            font-size: 9px;
            font-weight: 400;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: rgba(255, 255, 255, 0.7);
        }

        .copyright-dev { font-weight: 400; color: #ffffff; }

        /* --- FITUR ANIMASI BARU --- */
        @keyframes revealUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-reveal {
            animation: revealUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) forwards;
            opacity: 0;
        }

        /* Delay berurutan untuk setiap elemen */
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
        .delay-5 { animation-delay: 0.5s; }
        .delay-6 { animation-delay: 0.6s; }
        .delay-7 { animation-delay: 0.7s; }
        .delay-8 { animation-delay: 0.8s; }
        .delay-9 { animation-delay: 0.9s; }
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
                    <h1 class="text-3xl font-black italic uppercase tracking-tighter text-white">Aturan Rumah</h1>
                    <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <p class="text-[8px] text-yellow-400 font-bold tracking-[0.4em] uppercase">Simple Home Rules</p>
            </div>

            <div class="rules-card animate-reveal delay-2">
                <div class="rule-item animate-reveal delay-3">
                    <div class="rule-number">1</div>
                    <div class="rule-text">Lepas alas kaki di luar rumah.</div>
                </div>
                <div class="rule-item animate-reveal delay-4">
                    <div class="rule-number">2</div>
                    <div class="rule-text">Matikan listrik & air jika tidak dipakai.</div>
                </div>
                <div class="rule-item animate-reveal delay-5">
                    <div class="rule-number">3</div>
                    <div class="rule-text">Cuci peralatan makan setelah digunakan.</div>
                </div>
                <div class="rule-item animate-reveal delay-6">
                    <div class="rule-number">4</div>
                    <div class="rule-text">Dilarang merokok di dalam ruangan.</div>
                </div>
                <div class="rule-item animate-reveal delay-7">
                    <div class="rule-number">5</div>
                    <div class="rule-text">Jaga kebersihan & kerapian bersama.</div>
                </div>
                <div class="rule-item animate-reveal delay-8">
                    <div class="rule-number">6</div>
                    <div class="rule-text">Kunci pintu & jendela sebelum tidur.</div>
                </div>
            </div>

            <div class="text-center animate-reveal delay-9">
                <a href="menu.php" class="btn-back">KEMBALI KE DASHBOARD</a>
            </div>

            <footer class="text-center mt-4 animate-reveal delay-9">
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