<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Sholatify Sekolah | Absensi Sholat Digital untuk Siswa & Guru</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Iconify Icon -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <!-- Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        /* Animasi background bergerak */
        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .animated-bg {
            background: linear-gradient(120deg, #f9f6f0 0%, #e9f3e6 50%, #fdf8ed 100%);
            background-size: 200% 200%;
            animation: gradientShift 18s ease infinite;
        }

        /* Floating shapes animasi */
        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(2deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .float-delay-1 {
            animation-delay: 1s;
        }

        .float-delay-2 {
            animation-delay: 2.5s;
        }

        /* Card hover efek scale & bayangan */
        .prayer-card {
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .prayer-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 35px -12px rgba(0, 0, 0, 0.15);
        }

        /* Ripple effect untuk tombol */
        .ripple-btn {
            position: relative;
            overflow: hidden;
        }

        .ripple-btn:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
        }

        .ripple-btn:hover:after {
            width: 200%;
            height: 200%;
        }

        /* Glassmorphism navbar */
        .glass-navbar {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(72, 187, 120, 0.2);
        }

        /* Countdown badge pulse */
        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 0 0 rgba(46, 125, 50, 0.4);
            }

            70% {
                box-shadow: 0 0 0 12px rgba(46, 125, 50, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(46, 125, 50, 0);
            }
        }

        .pulse-countdown {
            animation: pulseGlow 2s infinite;
        }

        /* Scroll reveal effect */
        .reveal {
            opacity: 0;
            transform: translateY(25px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Modal animasi */
        .modal-backdrop {
            transition: opacity 0.3s ease;
        }

        .modal-container {
            transition: all 0.3s ease;
            transform: scale(0.95);
            opacity: 0;
        }

        .modal-container.active {
            transform: scale(1);
            opacity: 1;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #eef2e6;
        }

        ::-webkit-scrollbar-thumb {
            background: #3b9b6d;
            border-radius: 20px;
        }
    </style>
</head>

<body class="animated-bg overflow-x-hidden">

    <!-- Navbar dengan Tombol Login & Register -->
    <nav class="glass-navbar fixed top-0 left-0 w-full z-50 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-5 sm:px-8 py-3 flex justify-between items-center">
            <div class="flex items-center gap-2 group">
                <iconify-icon icon="tabler:mosque"
                    class="text-3xl text-emerald-700 group-hover:rotate-6 transition-transform duration-300"
                    width="34" height="34"></iconify-icon>
                <span
                    class="font-extrabold text-2xl tracking-tight bg-gradient-to-r from-emerald-800 to-teal-600 bg-clip-text text-transparent">Sholatify<span
                        class="text-emerald-600">Sekolah</span></span>
            </div>
            <div class="flex items-center gap-3 sm:gap-5">
                <button id="loginBtn"
                    class="group px-5 py-2 text-sm font-semibold rounded-full border border-emerald-600 text-emerald-700 hover:bg-emerald-50 transition-all duration-300 flex items-center gap-1 hover:shadow-md transform hover:scale-105">
                    <iconify-icon icon="mdi:login" width="18" height="18"
                        class="group-hover:translate-x-0.5 transition"></iconify-icon>
                    <span>Masuk</span>
                </button>
                <button id="registerBtn"
                    class="group px-5 py-2 text-sm font-semibold rounded-full bg-gradient-to-r from-emerald-700 to-teal-600 text-white shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-1 transform hover:scale-105 ripple-btn">
                    <iconify-icon icon="mdi:account-plus" width="18" height="18"></iconify-icon>
                    <span>Daftar Akun</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Floating Ornament Elements -->
    <div class="fixed top-20 left-5 w-20 h-20 opacity-20 pointer-events-none floating">
        <iconify-icon icon="mdi:star-four-points" width="60" class="text-emerald-500"></iconify-icon>
    </div>
    <div class="fixed bottom-32 right-5 w-28 h-28 opacity-20 pointer-events-none floating float-delay-1">
        <iconify-icon icon="mdi:mosque" width="70" class="text-teal-500"></iconify-icon>
    </div>
    <div class="fixed top-1/3 right-8 w-16 h-16 opacity-10 pointer-events-none floating float-delay-2">
        <iconify-icon icon="mdi:book-open-page-variant" width="50" class="text-amber-600"></iconify-icon>
    </div>

    <!-- Hero Section dengan animasi fade-in -->
    <section class="pt-28 pb-12 md:pt-36 md:pb-20 px-5 text-center max-w-6xl mx-auto relative z-10">
        <div
            class="inline-flex items-center gap-2 bg-white/60 backdrop-blur-sm rounded-full px-5 py-2 text-emerald-700 text-sm font-semibold mb-6 shadow-sm border border-emerald-100 reveal visible">
            <iconify-icon icon="mingcute:school-line" width="20"></iconify-icon>
            <span>Solusi Absensi Sholat Terintegrasi untuk Sekolah & Madrasah</span>
        </div>
        <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight leading-tight reveal">
            <span class="bg-gradient-to-r from-emerald-800 to-teal-500 bg-clip-text text-transparent">Catat
                Kehadiran</span><br>
            Sholat Siswa & Guru
        </h1>
        <p class="text-gray-700 text-lg max-w-2xl mx-auto mt-6 leading-relaxed reveal delay-75">
            Platform digital untuk memantau kedisiplinan ibadah sholat di lingkungan sekolah. <br>Jadwal, laporan
            otomatis, dan motivasi jamaah.
        </p>
        <div class="flex flex-wrap justify-center gap-5 mt-10 reveal delay-100">
            <button id="heroRegisterBtn"
                class="bg-gradient-to-r from-emerald-700 to-teal-600 text-white px-8 py-3.5 rounded-full font-bold shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center gap-2 transform hover:-translate-y-1">
                <iconify-icon icon="mdi:calendar-check" width="22"></iconify-icon>
                Mulai Absensi Sekarang
            </button>
            <button id="heroLoginBtn"
                class="border-2 border-emerald-600 text-emerald-700 px-8 py-3.5 rounded-full font-bold hover:bg-emerald-50 transition-all duration-300 flex items-center gap-2 transform hover:scale-105">
                <iconify-icon icon="mdi:login-variant"></iconify-icon>
                Login Dashboard
            </button>
        </div>
        <!-- Statistic mockup menarik -->
        <div class="flex flex-wrap justify-center gap-6 mt-16 reveal delay-150">
            <div class="flex items-center gap-3 bg-white/40 backdrop-blur-sm px-5 py-2 rounded-2xl">
                <iconify-icon icon="mdi:school" width="28" class="text-emerald-600"></iconify-icon>
                <div><span class="font-bold text-gray-800">120+</span><span class="text-sm text-gray-600 ml-1">Sekolah
                        Mitra</span></div>
            </div>
            <div class="flex items-center gap-3 bg-white/40 backdrop-blur-sm px-5 py-2 rounded-2xl">
                <iconify-icon icon="mdi:account-group" width="28" class="text-emerald-600"></iconify-icon>
                <div><span class="font-bold text-gray-800">8.5rb+</span><span class="text-sm text-gray-600 ml-1">Siswa
                        Aktif</span></div>
            </div>
            <div class="flex items-center gap-3 bg-white/40 backdrop-blur-sm px-5 py-2 rounded-2xl">
                <iconify-icon icon="mdi:chart-line" width="28" class="text-emerald-600"></iconify-icon>
                <div><span class="font-bold text-gray-800">96%</span><span class="text-sm text-gray-600 ml-1">Kepatuhan
                        Ibadah</span></div>
            </div>
        </div>
    </section>

    <!-- Jadwal Sholat Section dengan animasi scroll -->
    <section class="max-w-6xl mx-auto px-5 py-8 pb-20 relative z-10">
        <div class="text-center mb-10 reveal">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800">🕌 Jadwal Sholat<span
                    class="text-emerald-600"> Hari Ini</span></h2>
            <p class="text-gray-500 mt-2">Lokasi: Padang, Sumatera Barat • Metode Kemenag RI 2025</p>
            <div id="dateInfo"
                class="flex justify-center items-center gap-3 bg-white/70 rounded-full w-fit mx-auto px-5 py-2 mt-4 shadow-md backdrop-blur-sm border border-emerald-100">
                <iconify-icon icon="mdi:calendar-today" width="18" class="text-emerald-600"></iconify-icon>
                <span id="gregorianDate" class="font-medium text-gray-700">Memuat...</span>
                <span class="mx-1 text-emerald-400">•</span>
                <iconify-icon icon="mdi:moon-waning-crescent" width="16"></iconify-icon>
                <span id="hijriDate" class="font-medium text-gray-700">-</span>
            </div>
        </div>

        <!-- Loading State dengan skeleton -->
        <div id="loadingPrayers" class="flex flex-col items-center justify-center py-16">
            <div class="relative w-20 h-20">
                <div
                    class="absolute inset-0 rounded-full border-4 border-emerald-200 border-t-emerald-600 animate-spin">
                </div>
                <iconify-icon icon="mdi:mosque" width="32"
                    class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-emerald-700"></iconify-icon>
            </div>
            <p class="text-emerald-700 font-medium mt-5">Mengambil jadwal sholat & waktu terkini...</p>
        </div>

        <!-- Error State dengan animasi -->
        <div id="errorMessage"
            class="hidden bg-red-50/90 backdrop-blur-sm border border-red-200 rounded-2xl p-7 text-center max-w-md mx-auto shadow-lg">
            <iconify-icon icon="mdi:alert-circle-outline" class="text-red-500 text-6xl mx-auto"></iconify-icon>
            <p class="text-red-700 font-bold mt-3">Gagal memuat jadwal sholat</p>
            <p class="text-red-600 text-sm mt-1" id="errorDetail"></p>
            <button id="retryBtn"
                class="mt-5 bg-red-100 hover:bg-red-200 text-red-700 px-6 py-2 rounded-full transition-all font-semibold flex items-center gap-2 mx-auto">
                <iconify-icon icon="mdi:reload"></iconify-icon> Coba Lagi
            </button>
        </div>

        <!-- Konten Jadwal + Next Prayer -->
        <div id="prayerContent" class="hidden">
            <!-- Next prayer highlight -->
            <div
                class="bg-gradient-to-br from-white to-emerald-50/80 rounded-3xl p-6 mb-12 shadow-xl border border-emerald-200 transform transition-all hover:shadow-2xl reveal">
                <div class="flex flex-col md:flex-row justify-between items-center gap-5">
                    <div class="flex items-center gap-4">
                        <div class="bg-emerald-100 rounded-full p-4 pulse-countdown">
                            <iconify-icon icon="mdi:clock-time-four" width="36"
                                class="text-emerald-700"></iconify-icon>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wider">⌛ Waktu Sholat
                                Berikutnya</p>
                            <p id="nextPrayerName" class="text-3xl font-black text-gray-800 mt-1">-</p>
                        </div>
                    </div>
                    <div class="text-center md:text-right">
                        <span id="nextPrayerTime"
                            class="text-4xl font-mono font-bold text-emerald-800 bg-white/60 px-5 py-2 rounded-2xl shadow-inner">--:--</span>
                        <p id="timeRemaining"
                            class="text-md font-semibold text-gray-600 mt-2 flex items-center justify-center md:justify-end gap-1">
                            <iconify-icon icon="mdi:progress-clock"></iconify-icon><span>menghitung...</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grid Kartu Jadwal Sholat -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="prayerGrid"></div>
            <div class="text-center mt-10 text-sm text-gray-500 flex items-center justify-center gap-2 reveal">
                <iconify-icon icon="mdi:information-outline"></iconify-icon>
                Jadwal berdasarkan koordinat sekolah. Waktu sholat menggunakan WIB & metode Kemenag
            </div>
        </div>
    </section>

    <!-- Fitur Sekolah: Keunggulan Absensi -->
    <section class="max-w-6xl mx-auto px-5 pb-20">
        <div class="grid md:grid-cols-3 gap-7">
            <div
                class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 shadow-lg text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 reveal">
                <iconify-icon icon="mdi:clipboard-list-outline" width="48"
                    class="mx-auto text-emerald-600 mb-3"></iconify-icon>
                <h3 class="text-xl font-bold text-gray-800">Laporan Otomatis</h3>
                <p class="text-gray-600 mt-2">Rekap kehadiran sholat per kelas & per individu, siap cetak untuk wali
                    kelas.</p>
            </div>
            <div
                class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 shadow-lg text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 reveal delay-100">
                <iconify-icon icon="mdi:bell-ring-outline" width="48"
                    class="mx-auto text-emerald-600 mb-3"></iconify-icon>
                <h3 class="text-xl font-bold text-gray-800">Notifikasi Pengingat</h3>
                <p class="text-gray-600 mt-2">Siswa & guru dapat notifikasi waktu sholat via WhatsApp/Telegram
                    terintegrasi.</p>
            </div>
            <div
                class="bg-white/60 backdrop-blur-sm rounded-2xl p-6 shadow-lg text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 reveal delay-150">
                <iconify-icon icon="mdi:shield-check" width="48"
                    class="mx-auto text-emerald-600 mb-3"></iconify-icon>
                <h3 class="text-xl font-bold text-gray-800">Verifikasi Lokasi</h3>
                <p class="text-gray-600 mt-2">Absensi berbasis GPS & QR Code masjid sekolah, akurasi tinggi.</p>
            </div>
        </div>
    </section>

    <!-- Call to Action + Daftar Sekolah -->
    <section class="max-w-5xl mx-auto px-5 pb-24">
        <div
            class="bg-gradient-to-r from-emerald-800 to-teal-700 rounded-3xl p-8 text-white shadow-2xl transform transition-all hover:scale-[1.01] reveal">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <iconify-icon icon="mdi:hand-heart" width="50"></iconify-icon>
                    <div>
                        <h3 class="text-2xl font-extrabold">Siap tingkatkan kedisiplinan ibadah di sekolah?</h3>
                        <p class="text-emerald-100">Akses gratis untuk ujicoba 30 hari pertama.</p>
                    </div>
                </div>
                <button id="ctaRegisterBtn"
                    class="bg-white text-emerald-800 px-7 py-3 rounded-full font-bold shadow-xl hover:shadow-2xl transition-all flex items-center gap-2 hover:bg-emerald-50">
                    <iconify-icon icon="mdi:register"></iconify-icon> Daftarkan Sekolah
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-10 mt-8 border-t border-gray-700">
        <div class="max-w-6xl mx-auto px-5 text-center">
            <div class="flex justify-center gap-5 mb-5">
                <iconify-icon icon="mdi:heart" class="text-emerald-400 animate-pulse"></iconify-icon>
                <span class="text-sm">Platform Absensi Sholat Digital untuk Sekolah Islam</span>
                <iconify-icon icon="mdi:mosque" class="text-emerald-400"></iconify-icon>
            </div>
            <p class="text-xs text-gray-500">Powered by API Aladhan · Sholatify Sekolah | Membangun Generasi Sholeh
                dengan Kedisiplinan Ibadah</p>
        </div>
    </footer>

    <!-- ========== MODAL LOGIN ========== -->
    <div id="loginModal" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop"
        style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
        <div
            class="modal-container bg-white rounded-2xl max-w-md w-full mx-4 shadow-2xl transform transition-all overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-700 to-teal-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white text-xl font-bold flex items-center gap-2">
                    <iconify-icon icon="mdi:login"></iconify-icon> Masuk ke Akun
                </h3>
                <button class="close-modal text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6">
                <form id="loginForm">
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Email / NIS</label>
                        <input type="email" id="loginEmail" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition"
                            placeholder="contoh@sekolah.sch.id">
                    </div>
                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Password</label>
                        <input type="password" id="loginPassword" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 outline-none transition"
                            placeholder="********">
                    </div>
                    <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl transition transform hover:scale-[1.02] flex items-center justify-center gap-2">
                        <iconify-icon icon="mdi:login-variant"></iconify-icon> Masuk
                    </button>
                </form>
                <p class="text-center text-sm text-gray-500 mt-4">Belum punya akun? <button
                        id="switchToRegisterFromLogin" class="text-emerald-600 font-semibold hover:underline">Daftar
                        sekarang</button></p>
            </div>
        </div>
    </div>

    <!-- ========== MODAL REGISTER ========== -->
    <div id="registerModal" class="fixed inset-0 z-50 hidden items-center justify-center modal-backdrop"
        style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
        <div
            class="modal-container bg-white rounded-2xl max-w-md w-full mx-4 shadow-2xl transform transition-all overflow-hidden">
            <div class="bg-gradient-to-r from-teal-700 to-emerald-600 px-6 py-4 flex justify-between items-center">
                <h3 class="text-white text-xl font-bold flex items-center gap-2">
                    <iconify-icon icon="mdi:account-plus"></iconify-icon> Daftar Akun Baru
                </h3>
                <button class="close-modal text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6">
                <form id="registerForm">
                    <div class="mb-3">
                        <label class="block text-gray-700 font-semibold mb-1">Nama Lengkap</label>
                        <input type="text" id="regFullname" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-400"
                            placeholder="Ahmad Faiz">
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700 font-semibold mb-1">Email</label>
                        <input type="email" id="regEmail" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-400"
                            placeholder="siswa@sekolah.sch.id">
                    </div>
                    <div class="mb-3">
                        <label class="block text-gray-700 font-semibold mb-1">Kelas / Asal Sekolah</label>
                        <input type="text" id="regClass" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-400"
                            placeholder="XII MIPA 1 / SMA Negeri 1">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-1">Password</label>
                        <input type="password" id="regPassword" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-400"
                            placeholder="Minimal 6 karakter">
                    </div>
                    <button type="submit"
                        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 rounded-xl transition transform hover:scale-[1.02] flex items-center justify-center gap-2">
                        <iconify-icon icon="mdi:account-check"></iconify-icon> Daftar Sekarang
                    </button>
                </form>
                <p class="text-center text-sm text-gray-500 mt-4">Sudah punya akun? <button
                        id="switchToLoginFromRegister" class="text-emerald-600 font-semibold hover:underline">Login
                        disini</button></p>
            </div>
        </div>
    </div>

    <script>
        const LAT = -0.227819;
        const LNG = 100.626617;
        const METHOD = 20;

        const prayersList = [{
                key: 'Imsak',
                label: 'Imsak',
                icon: 'mdi:weather-night',
                bgColor: 'bg-indigo-50/80',
                borderColor: 'border-indigo-200'
            },
            {
                key: 'Fajr',
                label: 'Subuh',
                icon: 'mdi:weather-sunset-up',
                bgColor: 'bg-amber-50/80',
                borderColor: 'border-amber-200'
            },
            {
                key: 'Dhuhr',
                label: 'Dzuhur',
                icon: 'mdi:sun-clock',
                bgColor: 'bg-orange-50/80',
                borderColor: 'border-orange-200'
            },
            {
                key: 'Asr',
                label: 'Ashar',
                icon: 'mdi:weather-sunset-down',
                bgColor: 'bg-yellow-50/80',
                borderColor: 'border-yellow-200'
            },
            {
                key: 'Maghrib',
                label: 'Maghrib',
                icon: 'mdi:weather-sunset',
                bgColor: 'bg-rose-50/80',
                borderColor: 'border-rose-200'
            },
            {
                key: 'Isha',
                label: 'Isya',
                icon: 'mdi:night-sky',
                bgColor: 'bg-slate-100/80',
                borderColor: 'border-slate-300'
            }
        ];
        const order = ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'];

        const loadingEl = document.getElementById('loadingPrayers');
        const errorEl = document.getElementById('errorMessage');
        const prayerContentEl = document.getElementById('prayerContent');
        const errorDetailSpan = document.getElementById('errorDetail');
        const retryBtn = document.getElementById('retryBtn');
        const gregorianSpan = document.getElementById('gregorianDate');
        const hijriSpan = document.getElementById('hijriDate');
        const prayerGrid = document.getElementById('prayerGrid');
        const nextPrayerName = document.getElementById('nextPrayerName');
        const nextPrayerTimeSpan = document.getElementById('nextPrayerTime');
        const timeRemainingSpan = document.getElementById('timeRemaining');

        // Helper: WIB time
        function getCurrentWIBMinutes() {
            const now = new Date();
            const formatter = new Intl.DateTimeFormat('en-US', {
                timeZone: 'Asia/Jakarta',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
            const parts = formatter.formatToParts(now);
            let hour = 0,
                minute = 0;
            for (const p of parts) {
                if (p.type === 'hour') hour = parseInt(p.value);
                if (p.type === 'minute') minute = parseInt(p.value);
            }
            return hour * 60 + minute;
        }

        function timeToMin(timeStr) {
            const [h, m] = timeStr.split(':').map(Number);
            return h * 60 + m;
        }

        function formatRemaining(currentMin, targetMin, isTomorrow = false) {
            let diff = targetMin - currentMin;
            if (isTomorrow && diff < 0) diff += 1440;
            if (diff <= 0) return "Waktu sholat! Segera absen.";
            const hours = Math.floor(diff / 60);
            const mins = diff % 60;
            if (hours === 0) return `${mins} menit lagi`;
            if (hours > 0 && mins === 0) return `${hours} jam lagi`;
            return `${hours} jam ${mins} menit lagi`;
        }

        function getNextPrayerData(timings, nowMin) {
            for (let p of order) {
                const t = timings[p];
                if (t && timeToMin(t) > nowMin) {
                    return {
                        key: p,
                        timeStr: t,
                        isTomorrow: false,
                        targetMin: timeToMin(t)
                    };
                }
            }
            const first = order[0];
            const firstTime = timings[first];
            return {
                key: first,
                timeStr: firstTime,
                isTomorrow: true,
                targetMin: timeToMin(firstTime) + 1440
            };
        }

        function renderPrayerCards(timings) {
            prayerGrid.innerHTML = '';
            prayersList.forEach(p => {
                let waktu = timings[p.key] || '--:--';
                if (p.key === 'Imsak' && !timings.Imsak) waktu = '--:--';
                const card = document.createElement('div');
                card.className =
                    `prayer-card ${p.bgColor} border ${p.borderColor} rounded-2xl p-5 shadow-md transition-all duration-300 flex justify-between items-center cursor-default backdrop-blur-sm`;
                card.innerHTML = `
            <div class="flex items-center gap-3">
                <div class="bg-white rounded-full p-2 shadow-sm">
                    <iconify-icon icon="${p.icon}" width="28" class="text-gray-700"></iconify-icon>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase">${p.label}</p>
                    <p class="text-2xl font-mono font-bold text-gray-800">${waktu}</p>
                </div>
            </div>
            <iconify-icon icon="mdi:chevron-right-circle" width="24" class="text-emerald-400 opacity-60"></iconify-icon>
        `;
                prayerGrid.appendChild(card);
            });
        }

        let countdownInterval = null;

        function updateCountdown(timings) {
            if (!timings) return;
            const nowMin = getCurrentWIBMinutes();
            const next = getNextPrayerData(timings, nowMin);
            let displayName = prayersList.find(p => p.key === next.key)?.label || next.key;
            if (next.key === 'Fajr') displayName = 'Subuh';
            nextPrayerName.innerText = displayName;
            nextPrayerTimeSpan.innerText = next.timeStr;
            const remainingText = formatRemaining(nowMin, next.isTomorrow ? next.targetMin : next.targetMin, next
                .isTomorrow);
            timeRemainingSpan.innerHTML =
                `<iconify-icon icon="mdi:progress-clock" width="16"></iconify-icon> ${remainingText}`;
        }

        function startTimer(timings) {
            if (countdownInterval) clearInterval(countdownInterval);
            updateCountdown(timings);
            countdownInterval = setInterval(() => updateCountdown(timings), 30000);
        }

        async function fetchSchedule() {
            try {
                loadingEl.classList.remove('hidden');
                errorEl.classList.add('hidden');
                prayerContentEl.classList.add('hidden');
                const today = new Date().toISOString().split('T')[0];
                const url =
                    `https://api.aladhan.com/v1/timings/${today}?latitude=${LAT}&longitude=${LNG}&method=${METHOD}`;
                const resp = await fetch(url);
                if (!resp.ok) throw new Error('Gagal mengambil data');
                const json = await resp.json();
                if (json.code !== 200 || !json.data) throw new Error('Format API error');
                const timings = json.data.timings;
                const greg = json.data.date.readable;
                const hijriData = json.data.date.hijri;
                gregorianSpan.innerText = greg || new Date().toLocaleDateString('id-ID', {
                    dateStyle: 'full'
                });
                hijriSpan.innerText = `${hijriData.day} ${hijriData.month.en} ${hijriData.year}`;
                renderPrayerCards(timings);
                startTimer(timings);
                loadingEl.classList.add('hidden');
                prayerContentEl.classList.remove('hidden');
                errorEl.classList.add('hidden');
            } catch (err) {
                console.error(err);
                loadingEl.classList.add('hidden');
                errorDetailSpan.innerText = err.message || 'Tidak bisa memuat jadwal sholat, periksa koneksi internet.';
                errorEl.classList.remove('hidden');
                prayerContentEl.classList.add('hidden');
                if (countdownInterval) clearInterval(countdownInterval);
            }
        }

        retryBtn.addEventListener('click', fetchSchedule);

        const revealElements = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        revealElements.forEach(el => observer.observe(el));


        document.getElementById('loginBtn')?.addEventListener('click', () => {
            window.location.href = '/login';
        });
        document.getElementById('registerBtn')?.addEventListener('click', () => {
            window.location.href = '/register';
        });
        document.getElementById('heroLoginBtn')?.addEventListener('click', () => {
            window.location.href = '/login';
        });
        document.getElementById('heroRegisterBtn')?.addEventListener('click', () => {
            window.location.href = '/register';
        });
        document.getElementById('ctaRegisterBtn')?.addEventListener('click', () => {
            window.location.href = '/register';
        });

        fetchSchedule();
    </script>
</body>

</html>
