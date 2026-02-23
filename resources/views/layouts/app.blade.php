
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TeamHub') - TeamHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #34d399 0%, #059669 30%, #047857 60%, #064e3b 100%);
            min-height: 100vh;
        }

        .glass {
            background: linear-gradient(135deg, #fbd978 0%, #f8b86a 25%, #f09060 50%, #ed7070 75%, #e05050 100%);
            background-size: 100% 150%;
            animation: gradient-move 8s ease infinite;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes gradient-move {
            0% {
                background-position: 0% 0%;
            }
            50% {
                background-position: 100% 100%;
            }
            100% {
                background-position: 0% 0%;
            }
        }

        .glass-nav {
            background: linear-gradient(135deg, #fcc84a 0%, #e8873a 50%, #f06060 100%);
            background-size: 150% 100%;
            animation: gradient-move 8s ease infinite;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            position: fixed;
            top: 1rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            max-width: 80rem;
            width: calc(100% - 2rem);
        }

        .nav-spacer {
            height: 88px;
        }

        .logo-3d {
            font-weight: 900;
            background: linear-gradient(145deg, #047857, #065f46, #064e3b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0px 8px 12px rgba(0, 0, 0, 0.5))
                    drop-shadow(0px 4px 6px rgba(0, 0, 0, 0.3));
            opacity: 0.95;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .watermark {
            position: fixed;
            top: -20%;
            left: -20%;
            width: 200%;
            height: 200%;
            pointer-events: none;
            z-index: 1;
            opacity: 0.08;
            transform: rotate(-45deg) translateY(-25%);
        }

        .watermark-text {
            font-size: 6rem;
            font-weight: 900;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            white-space: nowrap;
            line-height: 12rem;
        }

        .content {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body class="p-4">

    <!-- Wasserzeichen -->
    <div class="watermark">
        <div class="watermark-text">
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
            TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION • TEST SITE • JOB APPLICATION •<br>
        </div>
    </div>

    <div class="content">
        <!-- Fixed Navigation -->
        <nav class="glass-nav rounded-2xl shadow-2xl px-8 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <!-- Logo -->
                    <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-black text-xl tracking-tighter" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">TH</span>
                    </div>
                    <div class="flex flex-col">
                        <a href="/" class="text-3xl logo-3d leading-none" style="filter: none;">TeamHub</a>
                        <span class="text-xs text-gray-700 font-medium italic">This is only a test site for my Job Applications</span>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <a href="/dashboard" class="text-gray-800 font-medium hover:text-gray-600 transition">
                        Dashboard
                    </a>
                    <a href="/projects" class="text-gray-800 font-medium hover:text-gray-600 transition">
                        Projects
                    </a>
                    <a href="/tasks" class="text-gray-800 font-medium hover:text-gray-600 transition">
                        Tasks
                    </a>
                </div>
            </div>
        </nav>

        <!-- Spacer for fixed nav -->
        <div class="nav-spacer"></div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto mb-4">
                <div class="glass rounded-xl px-4 py-3 text-gray-800 font-medium border border-green-300">
                    ✅ {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto mb-4">
                <div class="glass rounded-xl px-4 py-3 text-gray-800 font-medium border border-red-300">
                    ❌ {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Page Content -->
        <main>
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <div class="text-center mt-8 text-white text-opacity-60 text-sm pb-4">
            <p>&copy; {{ date('Y') }} TeamHub. All rights reserved.</p>
        </div>
    </div> <!-- Ende content -->
</body>
</html>