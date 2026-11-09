<?php
session_start();
// Detail Konfigurasi
$wifi_name = "NADRID";
$wifi_password = "secret245oke"; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Wi-Fi Access - Rumah Singgah</title>
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

        .wifi-card { 
            background: rgba(255, 255, 255, 0.05); 
            backdrop-filter: blur(25px); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            border-radius: 2.5rem; padding: 2.5rem 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            margin-bottom: 1.5rem;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .wifi-card:hover {
            transform: translateY(-5px);
            border-color: rgba(250, 204, 21, 0.4);
        }

        .label-text {
            font-size: 8px; font-weight: 800; color: #facc15;
            text-transform: uppercase; letter-spacing: 0.15em;
            margin-bottom: 8px; display: block;
        }

        .username-display {
            font-size: 1.15rem;
            font-weight: 900;
            color: #ffffff;
            letter-spacing: -0.01em;
            margin-bottom: 20px;
        }

        .value-box {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1rem; padding: 12px;
            display: flex; align-items: center; justify-content: space-between;
        }

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

        .copyright-dev {
            font-weight: 400;
            color: #ffffff;
        }

        #toast {
            position: fixed; top: 50%; left: 50%;
            transform: translate(-50%, -50%) scale(0.9);
            background: #facc15; color: #064e3b;
            padding: 14px 28px; border-radius: 1rem;
            font-size: 10px; font-weight: 900; z-index: 1000;
            opacity: 0; visibility: hidden;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            pointer-events: none;
        }
        #toast.show { opacity: 1; visibility: visible; transform: translate(-50%, -50%) scale(1); }

        /* --- FITUR ANIMASI REVEAL --- */
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
    </style>
</head>
<body>
    <div id="toast">✅ PASSWORD DISALIN</div>
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
                    <h1 class="text-3xl font-black italic uppercase tracking-tighter text-white">Akses Wi-Fi</h1>
                    <svg class="w-7 h-7 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                        <rect x="2" y="18" width="3" height="4" rx="1"/><rect x="7" y="14" width="3" height="8" rx="1"/><rect x="12" y="10" width="3" height="12" rx="1"/><rect x="17" y="6" width="3" height="16" rx="1"/><rect x="22" y="2" width="3" height="20" rx="1"/>
                    </svg>
                </div>
                <p class="text-[8px] text-yellow-400 font-bold tracking-[0.4em] uppercase">Private & Secure Network</p>
            </div>

            <div class="wifi-card animate-reveal delay-2">
                <div class="mb-2">
                    <span class="label-text">Nama Wi-Fi</span>
                    <div class="username-display"><?php echo $wifi_name; ?></div>
                </div>

                <div>
                    <span class="label-text">Password</span>
                    <div class="value-box">
                        <span id="passText" class="font-bold text-sm text-white flex-1 text-center pl-14 tracking-widest">••••••••</span>
                        <div class="flex gap-4 z-10">
                            <button type="button" onclick="togglePassword()" class="text-white/30 hover:text-yellow-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            <button type="button" onclick="copyAction('<?php echo $wifi_password; ?>')" class="text-white/30 hover:text-yellow-400 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
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

        const realPass = "<?php echo $wifi_password; ?>";
        let isVisible = false;
        function togglePassword() {
            const passElement = document.getElementById('passText');
            isVisible = !isVisible;
            passElement.innerText = isVisible ? realPass : "••••••••";
            passElement.style.letterSpacing = isVisible ? "normal" : "0.3em";
        }

        function copyAction(text) {
            const tempInput = document.createElement("input");
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            
            const toast = document.getElementById('toast');
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2000);
        }
    </script>
</body>
</html>