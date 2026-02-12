
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TeamHub - Project & Task Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(135deg, #34d399 0%, #059669 30%, #047857 60%, #064e3b 100%);
            min-height: 100vh;
        }

        .glass {
            background: linear-gradient(135deg, #fbd978 0%, #f8b86a 25%, #f09060 50%, #ed7070 75%, #e05050 100%);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .glass-nav {
            background: linear-gradient(135deg, #fcc84a 0%, #e8873a 50%, #f06060 100%);
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
    </style>
</head>
<body class="p-4">

    <!-- Fixed Navigation -->
    <nav class="glass-nav rounded-2xl shadow-2xl px-8 py-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-white font-black text-xl tracking-tighter" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">TH</span>
                </div>
                <span class="text-3xl logo-3d">TeamHub</span>
            </div>
            <div class="flex gap-4">
                <a href="/login" class="px-6 py-2 text-gray-800 font-medium hover:bg-white hover:bg-opacity-20 rounded-lg transition">
                    Login
                </a>
                <a href="/register" class="px-6 py-2 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition shadow-lg">
                    Sign Up
                </a>
                <a href="/guest-login" class="px-6 py-2 bg-white bg-opacity-30 text-gray-800 font-medium rounded-lg hover:bg-opacity-50 transition border border-white border-opacity-50">
                    👤 Guest Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Spacer -->
    <div class="nav-spacer"></div>

    <div class="max-w-6xl mx-auto">

        <!-- Hero Section -->
        <div class="glass rounded-3xl shadow-2xl p-12 mb-8 text-center">
            <h2 class="text-5xl font-bold text-gray-800 mb-6">
                Manage Your Team.<br>
                <span class="text-6xl font-black" style="background: linear-gradient(145deg, #10b981, #059669); -webkit-background-clip: text; -webkit-text-fill-color: transparent; opacity: 0.95;">
                    Effortlessly.
                </span>
            </h2>
            <p class="text-xl text-gray-700 mb-8 max-w-2xl mx-auto">
                TeamHub is your all-in-one solution for project management, task tracking, and team collaboration.
                Keep everyone on the same page.
            </p>
            <div class="flex gap-4 justify-center flex-wrap">
                <a href="/register" class="px-8 py-4 bg-emerald-600 text-white font-bold text-lg rounded-xl hover:bg-emerald-700 transition shadow-2xl">
                    Get Started Free
                </a>
                <a href="/login" class="px-8 py-4 bg-white bg-opacity-40 backdrop-blur-md text-gray-800 font-bold text-lg rounded-xl hover:bg-opacity-50 transition border border-white border-opacity-50">
                    Login
                </a>
                <a href="/guest-login" class="px-8 py-4 bg-white bg-opacity-20 backdrop-blur-md text-gray-800 font-bold text-lg rounded-xl hover:bg-opacity-40 transition border border-white border-opacity-40">
                    👤 Try as Guest
                </a>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="glass rounded-2xl p-8 card-hover">
                <div class="w-16 h-16 bg-emerald-800 bg-opacity-20 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-emerald-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Project Management</h3>
                <p class="text-gray-700">
                    Create and organize projects with ease. Track progress, set deadlines, and manage resources efficiently.
                </p>
            </div>

            <div class="glass rounded-2xl p-8 card-hover">
                <div class="w-16 h-16 bg-purple-800 bg-opacity-20 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-purple-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Task Tracking</h3>
                <p class="text-gray-700">
                    Assign tasks, set priorities, and monitor completion. Never miss a deadline with smart reminders.
                </p>
            </div>

            <div class="glass rounded-2xl p-8 card-hover">
                <div class="w-16 h-16 bg-blue-800 bg-opacity-20 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Team Collaboration</h3>
                <p class="text-gray-700">
                    Work together seamlessly. Share updates, communicate in real-time, and keep everyone aligned.
                </p>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="glass rounded-2xl p-8 mb-8">
            <div class="grid grid-cols-3 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-emerald-800 mb-2">1000+</div>
                    <div class="text-gray-700">Active Users</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-purple-800 mb-2">5000+</div>
                    <div class="text-gray-700">Projects Completed</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-blue-800 mb-2">99.9%</div>
                    <div class="text-gray-700">Uptime</div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="glass rounded-2xl p-12 text-center">
            <h3 class="text-3xl font-bold text-gray-800 mb-4">Ready to get started?</h3>
            <p class="text-xl text-gray-700 mb-6">Join thousands of teams already using TeamHub</p>
            <a href="/register" class="px-10 py-4 bg-emerald-600 text-white font-bold text-lg rounded-xl hover:bg-emerald-700 transition shadow-2xl">
                Start Your Free Trial
            </a>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-white text-opacity-60 text-sm pb-4">
            <p>&copy; {{ date('Y') }} TeamHub. All rights reserved.</p>
        </div>

    </div>
</body>
</html>