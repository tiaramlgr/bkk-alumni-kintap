<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - BKK SMKN Kintap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-slate-50 font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-slate-50 to-emerald-50"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-emerald-200 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 pointer-events-none"></div>

        <div class="relative z-10 max-w-lg w-full mx-4 bg-white rounded-[2.5rem] shadow-2xl shadow-emerald-900/5 p-10 md:p-14 text-center border border-slate-100">
            
            <div class="mx-auto w-24 h-24 bg-emerald-100 text-emerald-500 rounded-full flex items-center justify-center mb-8 shadow-inner">
                <i class="fas fa-check text-5xl"></i>
            </div>

            <h1 class="text-3xl font-extrabold text-slate-800 mb-4 tracking-tight">Registrasi Berhasil!</h1>
            
            <p class="text-slate-600 text-lg mb-2">
                Terima kasih telah mendaftar di sistem BKK SMK Negeri Kintap.
            </p>
            <p class="text-slate-500 text-base mb-10 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                Akun Anda saat ini berstatus <span class="font-bold text-orange-500">Pending</span>. Mohon menunggu proses verifikasi oleh Admin BKK maksimal 1x24 jam kerja.
            </p>

            <a href="{{ url('/login') }}" class="inline-flex items-center justify-center w-full bg-blue-600 hover:bg-blue-700 active:scale-[0.98] text-white font-bold px-8 py-4 rounded-2xl transition-all shadow-lg shadow-blue-600/30 gap-3">
                <i class="fas fa-sign-in-alt"></i> Kembali ke Halaman Login
            </a>
            
        </div>
    </div>
</body>
</html>