<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAM-DPTM UNY</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4338ca;
            --secondary-color: #8b5cf6;
            --accent-color: #06b6d4;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --text-primary: #f8fafc;
            --text-secondary: #cbd5e1;
            --text-muted: #64748b;
            --border-radius: 16px;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--bg-primary) 0%, var(--bg-secondary) 50%, var(--bg-primary) 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-shape {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            opacity: 0.1;
            animation: float 20s ease-in-out infinite;
        }

        .bg-shape:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            left: 10%;
            animation-delay: -2s;
        }

        .bg-shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 70%;
            right: 10%;
            animation-delay: -8s;
        }

        .bg-shape:nth-child(3) {
            width: 100px;
            height: 100px;
            top: 40%;
            right: 20%;
            animation-delay: -15s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-30px) rotate(120deg); }
            66% { transform: translateY(30px) rotate(240deg); }
        }

        /* Header with glassmorphism */
        .header {
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(20px);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            animation: slideDown 0.8s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            animation: fadeInLeft 1s ease-out;
        }

        @keyframes fadeInLeft {
            from {
                transform: translateX(-50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .logo i {
            font-size: 1.75rem;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .login-btn {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: var(--text-primary);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
            animation: fadeInRight 1s ease-out;
        }

        @keyframes fadeInRight {
            from {
                transform: translateX(50px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        /* Hero Section with enhanced animations */
        .hero-section {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(51, 65, 85, 0.9) 100%);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 4rem 3rem;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--warning-color));
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0% { background-position: -200px 0; }
            100% { background-position: calc(200px + 100%) 0; }
        }

        .title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, var(--text-primary), var(--primary-color), var(--accent-color));
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 4s ease-in-out infinite, typewriter 2s steps(40) forwards;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes typewriter {
            from { width: 0; }
            to { width: 100%; }
        }

        .description {
            color: var(--text-secondary);
            font-size: 1.2rem;
            line-height: 1.8;
            margin-bottom: 2.5rem;
            max-width: 800px;
            opacity: 0;
            animation: fadeIn 1s ease-out 0.5s forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Feature Cards */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin: 3rem 0;
        }

        .feature-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(51, 65, 85, 0.8) 100%);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            animation: slideInUp 0.8s ease-out;
        }

        .feature-card:nth-child(2) { animation-delay: 0.2s; }
        .feature-card:nth-child(3) { animation-delay: 0.4s; }

        @keyframes slideInUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--success-color), var(--accent-color));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            font-size: 3rem;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            display: block;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--text-primary);
        }

        .feature-description {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Statistics Section */
        .stats-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
            margin: 3rem 0;
            text-align: center;
            animation: fadeInScale 1s ease-out;
        }

        @keyframes fadeInScale {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .stat-item {
            animation: countUp 2s ease-out;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            display: block;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        /* Workshop Image */
        .workshop-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: var(--border-radius);
            margin: 3rem 0;
            box-shadow: var(--shadow-lg);
            transition: var(--transition);
            animation: zoomIn 1s ease-out;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .workshop-image:hover {
            transform: scale(1.05);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(99, 102, 241, 0.1));
            border: 2px solid rgba(99, 102, 241, 0.3);
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
            text-align: center;
            margin: 3rem 0;
            animation: bounceIn 1s ease-out;
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }
            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
            70% {
                transform: scale(0.9);
                opacity: 0.9;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .cta-button {
            background: linear-gradient(45deg, var(--success-color), var(--accent-color));
            color: var(--text-primary);
            border: none;
            padding: 1rem 2rem;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            position: relative;
            overflow: hidden;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.4);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--bg-secondary) 0%, var(--bg-primary) 100%);
            padding: 4rem 2rem 2rem;
            border-top: 1px solid var(--bg-tertiary);
            animation: slideUp 1s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .footer-brand {
            color: var(--primary-color);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-links {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .social-icon {
            color: var(--text-secondary);
            font-size: 1.5rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .social-icon:hover {
            color: var(--primary-color);
            background: rgba(99, 102, 241, 0.2);
            transform: translateY(-5px) scale(1.1);
        }

        .footer-nav {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .footer-column h3 {
            color: var(--text-primary);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .footer-column a {
            color: var(--text-secondary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            transition: var(--transition);
        }

        .footer-column a:hover {
            color: var(--primary-color);
            transform: translateX(8px);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .login-modal {
            background: linear-gradient(145deg, rgba(30, 41, 59, 0.95), rgba(51, 65, 85, 0.95));
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            position: relative;
            transform: translateY(-50px) scale(0.8);
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            overflow: hidden;
        }

        .modal-overlay.active .login-modal {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .login-modal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .login-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .login-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .close-modal {
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 1.5rem;
            cursor: pointer;
            transition: var(--transition);
            padding: 0.5rem;
            border-radius: 50%;
        }

        .close-modal:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(90deg);
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.9rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius);
            color: var(--text-primary);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            background-color: rgba(255, 255, 255, 0.08);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon .form-input {
            padding-left: 3rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: var(--transition);
        }

        .form-input:focus + .input-icon {
            color: var(--primary-color);
        }

        .login-btn-modal {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: var(--text-primary);
            border: none;
            width: 100%;
            padding: 1rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-btn-modal::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .login-btn-modal:hover::before {
            left: 100%;
        }

        .login-btn-modal:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.3);
        }

        .login-footer {
            text-align: center;
            margin-top: 2rem;
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .login-spinner {
            display: none;
        }

        .login-spinner.active {
            display: inline-block;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .login-error {
            background-color: rgba(239, 68, 68, 0.1);
            border-left: 3px solid var(--danger-color);
            color: var(--danger-color);
            padding: 1rem;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            display: none;
        }

        .login-error.active {
            display: block;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
            }

            .main-content {
                padding: 2rem 1rem;
            }

            .title {
                font-size: 2.2rem;
            }

            .hero-section {
                padding: 2rem 1.5rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Scroll animations */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg">
        <div class="bg-shape"></div>
        <div class="bg-shape"></div>
        <div class="bg-shape"></div>
    </div>

    <header class="header">
        <div class="logo">
            <i class="fas fa-cogs"></i>
            <span>EAM-DPTM UNY</span>
        </div>
        <button class="login-btn" onclick="openLoginModal()">
            <i class="fas fa-sign-in-alt"></i>
            <span>Login</span>
        </button>
    </header>
    
    <main class="main-content">
        <div class="hero-section">
            <h1 class="title">Enterprise Asset Management System</h1>
            <p class="description">
                Sistem Enterprise Asset Management (EAM) ini dirancang untuk membantu bengkel pemesinan DPTM dalam memantau kondisi aset secara real-time, menjadwalkan perawatan rutin maupun perbaikan, serta mengelola data inventaris seperti lokasi, status, dan riwayat aset.
            </p>
            <button class="cta-button" onclick="openLoginModal()">
                <i class="fas fa-rocket"></i>
                <span>Mulai Sekarang</span>
            </button>
        </div>

        <!-- Features Section -->
        <div class="features-grid scroll-reveal">
            <div class="feature-card">
                <i class="fas fa-chart-line feature-icon"></i>
                <h3 class="feature-title">Monitoring Real-time</h3>
                <p class="feature-description">Pantau kondisi aset secara real-time dengan dashboard interaktif yang memberikan insight mendalam tentang performa peralatan.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-calendar-alt feature-icon"></i>
                <h3 class="feature-title">Jadwal Perawatan</h3>
                <p class="feature-description">Kelola jadwal perawatan preventif dan korektif untuk memastikan aset selalu dalam kondisi optimal dan meminimalkan downtime.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-database feature-icon"></i>
                <h3 class="feature-title">Manajemen Inventaris</h3>
                <p class="feature-description">Sistem inventaris terintegrasi untuk tracking lokasi, status, dan riwayat lengkap setiap aset dalam bengkel.</p>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="stats-section scroll-reveal">
            <h2 style="font-size: 2rem; margin-bottom: 1rem; color: white;">Statistik Sistem</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number" data-count="150">0</span>
                    <div class="stat-label">Total Aset</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="98">0</span>
                    <div class="stat-label">Uptime (%)</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="25">0</span>
                    <div class="stat-label">Pengguna Aktif</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number" data-count="500">0</span>
                    <div class="stat-label">Maintenance Records</div>
                </div>
            </div>
        </div>

        <!-- Workshop Image with placeholder -->
        <div style="position: relative; animation: fadeInUp 1
        s ease-out;">
           <img class="workshop-image" src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Bengkel DPTM UNY" loading="lazy">
           <div style="position: absolute; bottom: 20px; left: 20px; background: rgba(0,0,0,0.7); padding: 1rem; border-radius: 8px; color: white;">
               <h3>Bengkel Pemesinan DPTM</h3>
               <p>Fasilitas modern dengan teknologi terdepan</p>
           </div>
       </div>

       <!-- CTA Section -->
       <div class="cta-section scroll-reveal">
           <h2 style="font-size: 2.2rem; margin-bottom: 1rem; color: var(--text-primary);">Siap Mengoptimalkan Aset Anda?</h2>
           <p style="color: var(--text-secondary); font-size: 1.1rem; margin-bottom: 1.5rem;">
               Bergabunglah dengan sistem EAM terdepan untuk mengelola aset bengkel pemesinan dengan lebih efisien dan efektif.
           </p>
           <button class="cta-button" onclick="openLoginModal()">
               <i class="fas fa-play"></i>
               <span>Akses Sistem</span>
           </button>
       </div>
   </main>

   <!-- Footer -->
   <footer class="footer">
       <div style="max-width: 1200px; margin: 0 auto;">
           <div class="footer-brand">
               <i class="fas fa-cogs"></i>
               EAM-DPTM UNY
           </div>
           
           <div class="footer-links">
               <a href="#" class="social-icon" aria-label="Facebook">
                   <i class="fab fa-facebook-f"></i>
               </a>
               <a href="#" class="social-icon" aria-label="Twitter">
                   <i class="fab fa-twitter"></i>
               </a>
               <a href="#" class="social-icon" aria-label="LinkedIn">
                   <i class="fab fa-linkedin-in"></i>
               </a>
               <a href="#" class="social-icon" aria-label="Instagram">
                   <i class="fab fa-instagram"></i>
               </a>
           </div>

           <div class="footer-nav">
               <div class="footer-column">
                   <h3>Tentang</h3>
                   <a href="#"><i class="fas fa-chevron-right"></i> Visi & Misi</a>
                   <a href="#"><i class="fas fa-chevron-right"></i> Tim Pengembang</a>
                   <a href="#"><i class="fas fa-chevron-right"></i> Karir</a>
               </div>
               <div class="footer-column">
                   <h3>Layanan</h3>
                   <a href="#"><i class="fas fa-chevron-right"></i> Asset Monitoring</a>
                   <a href="#"><i class="fas fa-chevron-right"></i> Maintenance Planning</a>
                   <a href="#"><i class="fas fa-chevron-right"></i> Inventory Management</a>
               </div>
               <div class="footer-column">
                   <h3>Support</h3>
                   <a href="#"><i class="fas fa-chevron-right"></i> Dokumentasi</a>
                   <a href="#"><i class="fas fa-chevron-right"></i> FAQ</a>
                   <a href="#"><i class="fas fa-chevron-right"></i> Kontak</a>
               </div>
               <div class="footer-column">
                   <h3>Kontak</h3>
                   <a href="mailto:eam@uny.ac.id"><i class="fas fa-envelope"></i> eam@uny.ac.id</a>
                   <a href="tel:+62274586168"><i class="fas fa-phone"></i> (0274) 586168</a>
                   <a href="#"><i class="fas fa-map-marker-alt"></i> Yogyakarta, Indonesia</a>
               </div>
           </div>

           <div style="text-align: center; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--bg-tertiary); color: var(--text-muted);">
               <p>&copy; 2024 EAM-DPTM UNY. All rights reserved. | Developed with ❤️ by DPTM UNY</p>
           </div>
       </div>
   </footer>

   <!-- Login Modal -->
   <div class="modal-overlay" id="loginModal">
       <div class="login-modal">
           <div class="login-header">
               <h2 class="login-title">
                   <i class="fas fa-sign-in-alt"></i>
                   Login Sistem
               </h2>
               <button class="close-modal" onclick="closeLoginModal()" aria-label="Close">
                   <i class="fas fa-times"></i>
               </button>
           </div>

           <div class="login-error" id="loginError">
               <i class="fas fa-exclamation-triangle"></i>
               <span id="errorMessage">Username atau password salah!</span>
           </div>

           <form id="loginForm" onsubmit="handleLogin(event)">
               <div class="form-group">
                   <label class="form-label" for="username">Username</label>
                   <div class="input-with-icon">
                       <input type="text" id="username" class="form-input" placeholder="Masukkan username" required>
                       <i class="fas fa-user input-icon"></i>
                   </div>
               </div>

               <div class="form-group">
                   <label class="form-label" for="password">Password</label>
                   <div class="input-with-icon">
                       <input type="password" id="password" class="form-input" placeholder="Masukkan password" required>
                       <i class="fas fa-lock input-icon"></i>
                   </div>
               </div>

               <button type="submit" class="login-btn-modal">
                   <i class="fas fa-spinner login-spinner" id="loginSpinner"></i>
                   <span id="loginText">Login</span>
               </button>
           </form>

           <div class="login-footer">
               <p>Lupa password? <a href="#" style="color: var(--primary-color);">Reset di sini</a></p>
           </div>
       </div>
   </div>

   <script>
       // Modal functionality
       function openLoginModal() {
           const modal = document.getElementById('loginModal');
           modal.classList.add('active');
           document.body.style.overflow = 'hidden';
           document.getElementById('username').focus();
       }

       function closeLoginModal() {
           const modal = document.getElementById('loginModal');
           modal.classList.remove('active');
           document.body.style.overflow = 'auto';
           resetLoginForm();
       }

       function resetLoginForm() {
           document.getElementById('loginForm').reset();
           document.getElementById('loginError').classList.remove('active');
           document.getElementById('loginSpinner').classList.remove('active');
           document.getElementById('loginText').textContent = 'Login';
       }

       // Handle login form submission
       async function handleLogin(event) {
           event.preventDefault();
           
           const username = document.getElementById('username').value;
           const password = document.getElementById('password').value;
           const spinner = document.getElementById('loginSpinner');
           const loginText = document.getElementById('loginText');
           const errorDiv = document.getElementById('loginError');
           
           // Show loading state
           spinner.classList.add('active');
           loginText.textContent = 'Memproses...';
           errorDiv.classList.remove('active');
           
           try {
               // Simulate API call
               await new Promise(resolve => setTimeout(resolve, 2000));
               
               // Demo credentials
               if (username === 'admin' && password === 'admin123') {
                   // Success
                   loginText.textContent = 'Berhasil!';
                   setTimeout(() => {
                       alert('Login berhasil! Redirecting to dashboard...');
                       closeLoginModal();
                   }, 1000);
               } else {
                   throw new Error('Invalid credentials');
               }
           } catch (error) {
               // Show error
               errorDiv.classList.add('active');
               document.getElementById('errorMessage').textContent = 'Username atau password salah!';
           } finally {
               // Reset loading state
               spinner.classList.remove('active');
               loginText.textContent = 'Login';
           }
       }

       // Close modal when clicking overlay
       document.getElementById('loginModal').addEventListener('click', function(e) {
           if (e.target === this) {
               closeLoginModal();
           }
       });

       // Close modal with Escape key
       document.addEventListener('keydown', function(e) {
           if (e.key === 'Escape' && document.getElementById('loginModal').classList.contains('active')) {
               closeLoginModal();
           }
       });

       // Animated counter for statistics
       function animateCounters() {
           const counters = document.querySelectorAll('.stat-number');
           
           counters.forEach(counter => {
               const target = parseInt(counter.getAttribute('data-count'));
               const duration = 2000; // 2 seconds
               const start = 0;
               let current = start;
               const increment = target / (duration / 16); // 60fps
               
               const timer = setInterval(() => {
                   current += increment;
                   if (current >= target) {
                       counter.textContent = target;
                       clearInterval(timer);
                   } else {
                       counter.textContent = Math.floor(current);
                   }
               }, 16);
           });
       }

       // Scroll reveal animation
       function revealOnScroll() {
           const reveals = document.querySelectorAll('.scroll-reveal');
           
           reveals.forEach(element => {
               const elementTop = element.getBoundingClientRect().top;
               const elementVisible = 150;
               
               if (elementTop < window.innerHeight - elementVisible) {
                   element.classList.add('revealed');
               }
           });
       }

       // Initialize animations
       document.addEventListener('DOMContentLoaded', function() {
           // Start counter animation when stats section is visible
           const statsSection = document.querySelector('.stats-section');
           const observer = new IntersectionObserver(entries => {
               entries.forEach(entry => {
                   if (entry.isIntersecting) {
                       animateCounters();
                       observer.unobserve(entry.target);
                   }
               });
           });
           
           if (statsSection) {
               observer.observe(statsSection);
           }
           
           // Initial scroll reveal check
           revealOnScroll();
       });

       // Scroll event listener
       window.addEventListener('scroll', revealOnScroll);

       // Smooth scroll for anchor links
       document.querySelectorAll('a[href^="#"]').forEach(anchor => {
           anchor.addEventListener('click', function (e) {
               e.preventDefault();
               const target = document.querySelector(this.getAttribute('href'));
               if (target) {
                   target.scrollIntoView({
                       behavior: 'smooth',
                       block: 'start'
                   });
               }
           });
       });

       // Add loading animation to buttons
       document.querySelectorAll('button').forEach(button => {
           if (!button.classList.contains('close-modal')) {
               button.addEventListener('click', function() {
                   this.style.transform = 'scale(0.95)';
                   setTimeout(() => {
                       this.style.transform = '';
                   }, 150);
               });
           }
       });

       // Performance optimization: lazy load images
       if ('IntersectionObserver' in window) {
           const imageObserver = new IntersectionObserver((entries, observer) => {
               entries.forEach(entry => {
                   if (entry.isIntersecting) {
                       const img = entry.target;
                       img.src = img.dataset.src || img.src;
                       img.classList.remove('lazy');
                       observer.unobserve(img);
                   }
               });
           });

           document.querySelectorAll('img[loading="lazy"]').forEach(img => {
               imageObserver.observe(img);
           });
       }

       // Add parallax effect to background shapes
       window.addEventListener('scroll', () => {
           const scrolled = window.pageYOffset;
           const parallax = document.querySelectorAll('.bg-shape');
           const speed = 0.5;

           parallax.forEach((element, index) => {
               const yPos = -(scrolled * speed * (index + 1) * 0.1);
               element.style.transform = `translateY(${yPos}px)`;
           });
       });

       // Add typing effect to title
       function typeWriter(element, text, speed = 100) {
           let i = 0;
           element.innerHTML = '';
           
           function type() {
               if (i < text.length) {
                   element.innerHTML += text.charAt(i);
                   i++;
                   setTimeout(type, speed);
               }
           }
           
           type();
       }

       // Initialize typing effect after page load
       window.addEventListener('load', () => {
           const title = document.querySelector('.title');
           if (title) {
               const originalText = title.textContent;
               setTimeout(() => {
                   typeWriter(title, originalText, 80);
               }, 1000);
           }
       });
   </script>
</body>
</html>