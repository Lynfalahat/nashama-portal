<?php
session_start();

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
    <title>بوابة النشامى - خريطة الجامعة والموقع</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #111111;
            min-height: 100vh;
        }

        header {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #b4031a;
        }

        .header-logo { width: 50px; height: auto; }

        .btn-back {
            color: #ffffff;
            background-color: #111111;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.3s;
        }
        .btn-back:hover { background-color: #b4031a; }

        main {
            max-width: 1000px;
            width: 90%;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .page-title { text-align: center; margin-bottom: 10px; color: #b4031a; font-size: 24px; }
        .page-subtitle { text-align: center; color: #666666; font-size: 14px; margin-bottom: 35px; }

        .map-flex-container {
            display: flex;
            gap: 25px;
            flex-wrap: wrap;
        }

        .map-box {
            flex: 1;
            min-width: 320px;
            background-color: #fafafa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
        }

        .map-box h4 { font-size: 16px; font-weight: 700; color: #b4031a; margin-bottom: 15px; text-align: right; border-right: 4px solid #b4031a; padding-right: 8px; }

        .btn-google-maps {
            display: inline-block;
            background-color: #34a853;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            transition: background-color 0.2s;
            margin-top: 15px;
            box-shadow: 0 4px 10px rgba(52, 168, 83, 0.2);
        }
        .btn-google-maps:hover { background-color: #2d8e47; }
    </style>
</head>
<body>

    <header>
        <div style="display: flex; align-items: center; gap: 10px;">
            <img src="logo.png" alt="شعار النشامى" class="header-logo">
            <span style="font-weight: 700;">بوابة النشامى الرقمية</span>
        </div>
        <a href="home.php" class="btn-back">رجوع للرئيسية</a>
    </header>

    <main>
        <h2 class="page-title">خريطة الحرم الجامعي والموقع الجغرافي 🗺️</h2>
        <p class="page-subtitle">تصفح خريطة الجامعة الحية وتنقلي بين الكليات، أو افتحي الموقع مباشرة عبر تطبيق الخرائط للوصول للحرم الجامعي.</p>

        <div class="map-flex-container">
            <div class="map-box">
                <h4>🗺️ خريطة الحرم الجامعي التفاعلية (Google Maps)</h4>
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3389.7042571407764!2d35.797274099999994!3d31.8330113!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ca7e1494da2e5%3A0x2964bfa95f26932e!2z2KzYp9mF2LnYqSDYp9mE2LLY2KrZiNmG2Kkg2KfZhNij2LHYr9mG2YrYqQ!5e0!3m2!1sar!2sjo!4v1717460000000!5m2!1sar!2sjo" 
                    width="100%" 
                    height="400" 
                    style="border:0; border-radius: 6px; border: 1px solid #ddd;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
                <p style="font-size:12px; color:#666; margin-top: 12px;">يمكنك تكبير وتصغير الخريطة وتحريكها لمعرفة كليات ومواقف الجامعة بدقة.</p>
            </div>

            <div class="map-box" style="display:flex; flex-direction:column; justify-content:center; align-items:center;">
                <span style="font-size: 40px; margin-bottom: 15px;">📍</span>
                <h4 style="border:none; padding:0; text-align:center; margin-bottom:10px; color:#111;">الموقع الرسمي لجامعة الزيتونة الأردنية</h4>
                <p style="font-size:14px; color:#555; max-width:300px; line-height:1.7; text-align:center;">طريق مطار الملكة علياء الدولي، منطقة مرج الحمام، عمان، الأردن.</p>
                
                <a href="https://maps.app.goo.gl/9QZfX7qNGeuunGfP9" target="_blank" class="btn-google-maps">فتح في تطبيق خرائط جوجل 🗺️</a>
            </div>
        </div>
    </main>

</body>
</html>