<?php
// 1. Kunci output dan mulai session
ob_start();
session_start();

// Jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard_admin.php");
    exit();
}

// 2. Aktifkan laporan error agar mudah debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 3. Panggil koneksi database
$config_path = 'user/config.php';

if (file_exists($config_path)) {
    include $config_path;
} else {
    die("<div style='color:red; font-family:sans-serif; padding:20px; border:1px solid red;'>
            <b>Error:</b> Folder atau file <code>user/config.php</code> tidak ditemukan!
         </div>");
}

$error = "";

// 4. Proses Login (Support Password Hash & User Table)
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password_input = $_POST['password'];

    // Cari di tabel user (sesuai dengan kelola_user.php)
    $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Cek password menggunakan password_verify
        if (password_verify($password_input, $data['password'])) {
            // Set session agar bisa akses halaman admin
            $_SESSION['id_user']  = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role']     = $data['role'];
            
            header("Location: dashboard_admin.php");
            exit();
        } else {
            $error = "Password yang Anda masukkan salah!";
        }
    } else {
        $error = "Username tidak terdaftar dalam sistem!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Rumah Singgah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            background-color: #064e3b; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            margin: 0; padding: 0;
            display: flex; align-items: center; justify-content: center; min-height: 100vh;
        }
        .login-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 850px; 
            max-width: 95%;
            background: #fbfbfb;
            border-radius: 2.5rem;
            overflow: hidden;
            box-shadow: 0 40px 60px rgba(0,0,0,0.2);
        }
        .grid-right {
            background: #054030;
            color: white;
            padding: 80px;
            position: relative;
            display: flex;
            flex-direction: column;
        }
        .input-group { position: relative; }
        .input-group svg { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #9ca3af; width: 18px; height: 18px; }
        .input-group input { padding-left: 50px; }
    </style>
</head>
<body class="p-6">

    <div class="login-grid shadow-2xl">
        <div class="grid-left p-10 lg:p-12 flex flex-col justify-between bg-[#fbfbfb]">
            
            <div class="flex items-center gap-2">
                <div class="w-[32px] h-[32px] rounded-lg bg-emerald-900 flex items-center justify-center text-white shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <p class="text-[18px] font-bold tracking-tight text-emerald-950 leading-none">Rumah Singgah</p>
            </div>

            <div class="max-w-xs mx-auto w-full mt-10 mb-10">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-black text-emerald-950 mb-2">Admin Login</h2>
                    <p class="text-xs text-gray-500 font-medium">Please enter your credentials.</p>
                </div>

                <?php if ($error): ?>
                    <div class="bg-red-500/10 border border-red-500 text-red-500 p-3 rounded-xl mb-6 text-[10px] text-center font-bold uppercase tracking-widest">
                        <?= $error ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" class="space-y-5">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2 block">Username</label>
                        <div class="input-group">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <input type="text" name="username" required placeholder="Username" autocomplete="off" class="w-full h-14 bg-white border border-gray-100 rounded-2xl text-xs font-medium text-emerald-950 outline-none focus:border-emerald-400 transition-all shadow-inner">
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-500 uppercase tracking-widest ml-2 block">Password</label>
                        <div class="input-group">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <input type="password" name="password" required placeholder="••••••••" class="w-full h-14 bg-white border border-gray-100 rounded-2xl text-xs font-medium text-emerald-950 outline-none focus:border-emerald-400 transition-all shadow-inner">
                        </div>
                    </div>

                    <button type="submit" name="login" class="w-full h-14 bg-emerald-900 text-white rounded-2xl font-black text-xs uppercase shadow-lg active:scale-95 transition-all mt-4 hover:bg-emerald-950 tracking-widest">
                        Sign In
                    </button>
                </form>
            </div>

            <p class="text-center text-[8px] text-gray-400 uppercase tracking-[0.4em] font-medium pt-5 opacity-80">
                © 2026 RAHMAT | IT SKAMUDA
            </p>
        </div>

        <div class="grid-right flex flex-col justify-start">
            <div class="relative pt-6 pb-6 mb-8">
                <svg class="w-10 h-10 text-orange-400 rotate-180 absolute -top-4 -left-8 opacity-70" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path>
                </svg>
                <p class="text-[15px] font-semibold text-white leading-relaxed italic pr-6 relative z-10">
                    Sistem manajemen terintegrasi Rumah Singgah. Memudahkan pencatatan izin tamu dan monitoring data real-time untuk efisiensi admin.
                </p>
                <svg class="w-10 h-10 text-orange-400 absolute -bottom-6 right-4 opacity-70" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"></path>
                </svg>
            </div>
            
            <div class="flex items-center gap-3 mt-4 relative z-20">
                <div class="w-10 h-10 rounded-full bg-yellow-400 flex items-center justify-center text-emerald-950 font-black text-sm border-2 border-white/20 shadow-md">R</div>
                <div class="flex flex-col">
                    <p class="text-sm font-bold text-white leading-none mb-1">Rahmat Admin</p>
                    <p class="text-[11px] text-white/60 font-medium">Banjarmasin, ID</p>
                </div>
            </div>

            <div class="absolute bottom-5 right-5 w-[220px] opacity-30 pointer-events-none">
                <svg viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 90H90" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    <path d="M20 90V45L50 20L80 45V90" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M35 90V70H45V90" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="28" cy="55" r="4" stroke="white" stroke-width="1.5"/>
                </svg>
            </div>
        </div>
    </div>

</body>
</html>