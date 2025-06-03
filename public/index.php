<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EAM-DPTM UNY</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', Garamond;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #222;
            line-height: 1.5;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 28px 60px;
            background: #fff;
            border-radius: 0 0 24px 24px;
            box-shadow: 0 4px 24px rgba(44,62,80,0.10);
            width: 90%;
            margin: 32px auto 0 auto;
            position: relative;
            z-index: 2;
        }

        .logo {
            font-size: 2rem;
            font-weight: 700;
            color: #1a237e;
            letter-spacing: 1px;
        }

        .login-btn {
            background: linear-gradient(90deg, #1976d2 0%, #0d47a1 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 16px 36px;
            font-size: 1.1rem;
            font-weight: 600;
            line-height: 30px;
            cursor: pointer;
            box-shadow: 0px 2px 8px rgba(25, 118, 210, 0.10);
            transition: background 0.2s, box-shadow 0.2s;
        }

        .login-btn:hover {
            background: linear-gradient(90deg, #0d47a1 0%, #1976d2 100%);
            box-shadow: 0 4px 16px rgba(25, 118, 210, 0.13);
        }

        .main-content {
            padding: 48px 60px 0 60px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .title {
            font-size: 3rem;
            font-weight: 800;
            color: #1a237e;
            margin-bottom: 18px;
            letter-spacing: -1px;
        }

        .description {
            font-size: 1.3rem;
            font-weight: 400;
            line-height: 1.7;
            text-align: justify;
            color: #333;
            max-width: 900px;
            margin-bottom: 36px;
        }

        .workshop-image {
            width: 100%;
            max-width: 900px;
            height: auto;
            border-radius: 16px;
            margin: 40px 0;
            box-shadow: 0 4px 24px rgba(44,62,80,0.10);
            display: block;
        }

        .footer {
            background: #fff;
            padding: 40px 60px;
            border-top: 1px solid #e6e6e6;
            display: flex;
            flex-direction: column;
            margin-top: 60px;
            border-radius: 24px 24px 0 0;
            box-shadow: 0 -2px 16px rgba(44,62,80,0.05);
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a237e;
            margin-bottom: 24px;
        }

        .footer-links {
            display: flex;
            gap: 20px;
            margin-bottom: 24px;
        }

        .social-icon {
            width: 36px;
            height: 36px;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .social-icon:hover {
            opacity: 0.7;
        }

        .footer-nav {
            display: flex;
            justify-content: space-between;
            max-width: 600px;
        }

        .footer-column {
            margin-right: 60px;
        }

        .footer-column h3 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 16px;
            color: #1a237e;
        }

        .footer-column a {
            display: block;
            font-size: 1rem;
            font-weight: 500;
            color: #444444;
            text-decoration: none;
            margin-bottom: 8px;
            transition: color 0.3s;
        }

        .footer-column a:hover {
            color: #1976d2;
        }

        @media (max-width: 900px) {
            .header, .main-content, .footer {
                padding-left: 18px;
                padding-right: 18px;
            }
            .header, .footer {
                width: 98%;
            }
            .main-content {
                padding-top: 24px;
            }
            .title {
                font-size: 2rem;
            }
            .workshop-image {
                margin: 24px 0;
            }
        }

        @media (max-width: 600px) {
            .header, .footer {
                flex-direction: column;
                align-items: flex-start;
                padding: 16px 6px;
                border-radius: 0;
            }
            .main-content {
                padding: 12px 6px 0 6px;
            }
            .footer-nav {
                flex-direction: column;
            }
            .footer-column {
                margin-right: 0;
                margin-bottom: 18px;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">EAM-DPTM UNY</div>
        <button class="login-btn" onclick="window.location.href='login.php'">Login</button>
    </header>
    
    <main class="main-content">
        <h1 class="title">SISTEM EAM</h1>
        <p class="description">
            Sistem Enterprise Asset Management (EAM) ini dirancang untuk membantu bengkel pemesinan DPTM dalam memantau kondisi aset secara real-time, menjadwalkan perawatan rutin maupun perbaikan, serta mengelola data inventaris seperti lokasi, status, dan riwayat aset.
        </p>
        
        <button class="login-btn" onclick="window.location.href='login.php'">Login</button>
        
        <img src="assets/img2.png" alt="Bengkel Pemesinan DPTM" class="workshop-image">
        
        <h1 class="title">Bengkel Pemesinan DPTM</h1>
        
        <p class="description">
            Bengkel pemesinan merupakan unit kerja yang berfokus pada proses manufaktur berbasis pemotongan material, seperti pembubutan, frais, bor, dan gerinda, dengan menggunakan mesin-mesin presisi. Bengkel ini melayani berbagai kebutuhan pembuatan dan perbaikan komponen teknik, baik untuk keperluan produksi, riset, maupun perawatan alat industri. Dilengkapi dengan mesin-mesin konvensional dan CNC, serta tenaga operator berpengalaman, bengkel pemesinan berperan penting dalam menghasilkan produk dengan tingkat ketelitian tinggi sesuai spesifikasi teknis dan standar kualitas industri.
        </p>
    </main>
    
    <footer class="footer">
        <div class="footer-brand">EAM-DPTM</div>
        
        <div class="footer-links">
            <a href="#"><img src="assets/fb.svg" alt="Facebook" class="social-icon"></a>
            <a href="#"><img src="assets/linkedin.svg" alt="LinkedIn" class="social-icon"></a>
            <a href="#"><img src="assets/yt.svg" alt="YouTube" class="social-icon"></a>
            <a href="#"><img src="assets/ig.svg" alt="Instagram" class="social-icon"></a>
        </div>
        
        <div class="footer-nav">
            <div class="footer-column">
                <h3>UNY</h3>
                <a href="#">FT UNY</a>
                <a href="#">DPTM</a>
            </div>
            
            <div class="footer-column">
                <h3>DPTM</h3>
                <a href="#">MANUAKTUR</a>
                <a href="#">PENDIDIKAN TEKNIK MESIN</a>
                <a href="#">S2 TEKNIK MESIN</a>
            </div>
            
            </div>
        </div>
    </footer>
</body>
</html>