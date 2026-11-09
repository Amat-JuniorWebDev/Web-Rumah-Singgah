<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Rumah Singgah - Luxury Fast Transition</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #064e3b; 
            --brand-yellow: #ffff00; 
            --apple-curve: cubic-bezier(0.2, 0, 0.2, 1);
        }

        html, body { 
            background-color: var(--bg-dark); 
            margin: 0; padding: 0;
            height: 100vh; width: 100vw;
            overflow: hidden; 
            display: flex; align-items: center; justify-content: center;
            font-family: 'Cinzel', serif; 
        }

        .brand-container {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* --- LOGO RUMAH --- */
        .logo-box {
            width: 42px; height: 42px;
            color: var(--brand-yellow);
            display: flex; align-items: center; justify-content: center;
            z-index: 20;
            opacity: 0;
            filter: blur(10px);
            animation: logoFocus 1.2s var(--apple-curve) 0.5s forwards,
                       logoShift 0.8s var(--apple-curve) 2.0s forwards;
        }

        @keyframes logoFocus {
            to { opacity: 1; filter: blur(0); transform: scale(1); }
        }

        @keyframes logoShift {
            to { transform: translateX(-8px); }
        }

        /* --- TEKS RUMAH SINGGAH --- */
        .text-reveal {
            width: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            white-space: nowrap;
            opacity: 0;
            animation: revealPremium 0.8s var(--apple-curve) 2.0s forwards;
        }

        @keyframes revealPremium {
            0% { width: 0; opacity: 0; transform: translateX(-5px); }
            100% { width: 220px; opacity: 1; transform: translateX(8px); }
        }

        .title {
            color: var(--brand-yellow);
            font-size: 1.15rem; 
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            line-height: 1;
        }

        .subtitle {
            font-family: 'Inter', sans-serif;
            font-size: 0.5rem; 
            letter-spacing: 0.4em;
            color: rgba(255, 255, 0, 0.6);
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* --- ANIMASI TRANSISI SLIDE DOWN (DIPERCEPAT) --- */
        #exit-curtain {
            position: fixed;
            top: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: #ffffff;
            z-index: 100;
            /* Transisi dibuat lebih cepat (0.5s) */
            transition: top 0.5s cubic-bezier(0.7, 0, 0.3, 1);
        }
        #exit-curtain.active { 
            top: 0; 
        }
    </style>
</head>
<body>

    <div id="exit-curtain"></div>

    <div class="brand-container">
        <div class="logo-box">
            <svg class="w-full h-full" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 00-1.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
            </svg>
        </div>

        <div class="text-reveal">
            <h1 class="title">Rumah Singgah</h1>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const curtain = document.getElementById('exit-curtain');

            // Durasi opening diperpendek dikit agar tidak kelamaan nunggu
            setTimeout(() => {
                curtain.classList.add('active');
                
                // Begitu tirai turun, langsung pindah (Tanpa Delay)
                setTimeout(() => {
                    window.location.replace('menu.php');
                }, 500); // 500ms adalah waktu animasi tirai itu sendiri
            }, 4000); 
        });
    </script>
</body>
</html>