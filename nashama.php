<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// حماية الصفحة
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى - عن القائمة والمعرض</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Cairo', sans-serif; }
        body { background-color: #f4f4f4; color: #111111; min-height: 100vh; }
        header { background-color: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 3px solid #b4031a; }
        .header-logo { width: 50px; height: auto; }
        main { max-width: 1100px; width: 90%; margin: 40px auto; background-color: #ffffff; padding: 40px 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .hero-section { text-align: center; margin-bottom: 40px; padding-bottom: 30px; border-bottom: 2px solid #eeeeee; }
        .nashama-big-logo { width: 110px; height: auto; margin-bottom: 15px; }
        .page-title { color: #b4031a; font-size: 26px; font-weight: 700; margin-bottom: 10px; }
        .page-subtitle { color: #555555; font-size: 14px; max-width: 750px; margin: 0 auto; line-height: 1.6; }
        .grid-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 35px; }
        .info-card { background-color: #fafafa; border: 1px solid #e0e0e0; border-radius: 8px; padding: 22px; border-top: 4px solid #b4031a; }
        .card-title { font-size: 17px; font-weight: 700; color: #111111; margin-bottom: 10px; }
        .card-text { font-size: 13px; color: #444444; line-height: 1.6; text-align: justify; }
        .highlight-section { background-color: #fbe9eb; border-right: 5px solid #b4031a; padding: 20px; border-radius: 4px; margin-bottom: 35px; }
        .media-section-title { font-size: 18px; font-weight: 700; color: #b4031a; margin: 35px 0 15px 0; border-right: 4px solid #b4031a; padding-right: 10px; }
        
        .slider-container { width: 100%; overflow: hidden; background: #fafafa; border: 1px solid #ddd; border-radius: 10px; padding: 25px 0; position: relative; }
        .slider-track { display: flex; gap: 20px; width: calc((280px + 20px) * 16); animation: scrollSlider 30s linear infinite; }
        .slider-container:hover .slider-track { animation-play-state: paused; }
        .slider-media-box { width: 280px; height: 180px; flex-shrink: 0; border-radius: 8px; overflow: hidden; border: 1px solid #ddd; background-color: #ffffff; }
        .slider-media-box img, .slider-media-box video { width: 100%; height: 100%; object-fit: cover; display: block; }
        @keyframes scrollSlider { 0% { transform: translateX(0); } 100% { transform: translateX(calc((280px + 20px) * 8)); } }

        .social-container { display: flex; justify-content: center; align-items: center; gap: 15px; flex-wrap: wrap; background: #fafafa; border: 1px solid #e0e0e0; border-radius: 10px; padding: 20px; margin-bottom: 40px; }
        .social-link { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: #ffffff; padding: 10px 22px; border-radius: 8px; font-size: 14px; font-weight: 700; }
        .social-link.facebook { background-color: #1877f2; }
        .social-link.instagram { background-image: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); }
        .social-link.whatsapp { background-color: #25d366; }
        .next-navigation-container { display: flex; justify-content: flex-end; border-top: 2px solid #eeeeee; padding-top: 30px; }
        .btn-go-home { display: inline-flex; align-items: center; gap: 12px; background-color: #b4031a; color: #ffffff; text-decoration: none; padding: 14px 35px; border-radius: 8px; font-size: 15px; font-weight: 700; box-shadow: 0 5px 15px rgba(180, 3, 26, 0.25); }
        .btn-go-home:hover { background-color: #111111; transform: translateX(-5px); }
    </style>
</head>
<body>
    <header>
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="logo.png" alt="شعار النشامى" class="header-logo">
            <span style="font-weight: 700;">بوابة النشامى الرقمية</span>
        </div>
    </header>
    <main>
        <div class="hero-section">
            <img src="logo.png" alt="شعار النشامى الكبير" class="nashama-big-logo">
            <h2 class="page-title">قائمة النشامى - صوت الطالب الواعي</h2>
            <p class="page-subtitle">تجمع طلابي ريادي يسعى لخدمة طلبة جامعة الزيتونة الأردنية.</p>
        </div>
        <div class="grid-container">
            <div class="info-card"><h3 class="card-title">👁️ رؤيتنا</h3><p class="card-text">نطمح إلى بناء بيئة جامعية مثالية تتكامل فيها الأدوار الأكاديمية والأنشطة الإبداعية.</p></div>
            <div class="info-card"><h3 class="card-title">🚀 رسالتنا</h3><p class="card-text">العمل بروح الفريق الواحد لتمثيل الطلبة والدفاع عن حقوقهم الأكاديمية والخدمية.</p></div>
            <div class="info-card" style="border-top-color: #111111;"><h3 class="card-title">🤝 قيمنا وأهدافنا</h3><p class="card-text">نرتكز على قيم الأمانة، والشفافية، والعمل التطوعي الخالص لخدمة الطلاب.</p></div>
        </div>
        <div class="highlight-section">
            <h4>💡 مبادرات وأنشطة متميزة</h4>
            <p>تميزت قائمة النشامى بتنظيم الفعاليات الأكاديمية والخيرية الكبرى كـ "حفل إفطار النشامى الخيري للأيتام".</p>
        </div>
        <div class="media-section-title">📸 معرض وسائط ومبادرات النشامى الميدانية التفاعلي</div>
        <div class="slider-container">
            <div class="slider-track">
                <div class="slider-media-box"><img src="1.jpg" alt="Photo 1" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><img src="2.jpg" alt="Photo 2" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><video autoplay loop muted playsinline preload="metadata"><source src="25.mp4" type="video/mp4"></video></div>
                <div class="slider-media-box"><img src="3.jpg" alt="Photo 3" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><img src="4.jpg" alt="Photo 4" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><video autoplay loop muted playsinline preload="metadata"><source src="24.mp4" type="video/mp4"></video></div>
                <div class="slider-media-box"><img src="5.png" alt="Photo 5" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><img src="6.jpg" alt="Photo 6" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><img src="1.jpg" alt="Photo 1" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><img src="2.jpg" alt="Photo 2" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><video autoplay loop muted playsinline preload="metadata"><source src="23.mp4" type="video/mp4"></video></div>
                <div class="slider-media-box"><img src="3.jpg" alt="Photo 3" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><img src="4.jpg" alt="Photo 4" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><video autoplay loop muted playsinline preload="metadata"><source src="22.mp4" type="video/mp4"></video></div>
                <div class="slider-media-box"><img src="5.png" alt="Photo 5" onerror="this.src='logo.png';"></div>
                <div class="slider-media-box"><img src="6.jpg" alt="Photo 6" onerror="this.src='logo.png';"></div>
            </div>
        </div>
        <div class="media-section-title">🌐 تابعونا على منصاتنا الرسمية</div>
        <div class="social-container">
            <a href="https://www.facebook.com/share/1GTTcf2BH4/?mibextid=wwXIfr" target="_blank" class="social-link facebook"><span>📘 فيسبوك - Facebook</span></a>
            <a href="https://www.instagram.com/nashamazuj?igsh=MXI2c2Z3cTJnb2Z0eQ%3D%3D&utm_source=qr" target="_blank" class="social-link instagram"><span>📸 إنستغرام - Instagram</span></a>
            <a href="https://whatsapp.com/channel/0029Vb7JS4fHltYB5946jH0e" target="_blank" class="social-link whatsapp"><span>💬 قناة الواتساب الإخبارية</span></a>
        </div>
        <div class="next-navigation-container">
            <a href="home.php" class="btn-go-home">التالي: دخول لوحة التحكم الرئيسية ➡️</a>
        </div>
    </main>
</body>
</html>