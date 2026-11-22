<?php
session_start();

// حماية الصفحة
if (!isset($_SESSION['student_id'])) {
    header("Location: index.php");
    exit();
}

// مصفوفات خطوط الباصات الرسمية 
$amman_buses = [
    ['title' => 'باص البيادر و وادي السير', 'link' => 'https://chat.whatsapp.com/CD1K0JCh0Y12pxEunoUINR'],
    ['title' => 'باص البنيات والمقابلين', 'link' => 'https://chat.whatsapp.com/KjklPDEzXhVCBAgCgfImCG'],
    ['title' => 'باص الشرق الاوسط 1', 'link' => 'https://chat.whatsapp.com/IpckrAaqP4nGkdM99Pb14F'],
    ['title' => 'باص الشرق الاوسط 2', 'link' => 'https://chat.whatsapp.com/GtAwZHZNLDE92q0DxLU7hD'],
    ['title' => 'باص رغدان', 'link' => 'https://chat.whatsapp.com/BBeEEmkvqdfG8MIIQAnNQ6'],
    ['title' => 'باص نزال 1', 'link' => 'https://chat.whatsapp.com/BnXoD000S8k0J4W4wx8Npg'],
    ['title' => 'باص نزال 2', 'link' => 'https://chat.whatsapp.com/Gc0Qx1TdVKZK06gzoNLJLI'],
    ['title' => 'باص الوحدات والاشرفية', 'link' => 'https://chat.whatsapp.com/IkBGz8KRVRv4xiqCKGHUGB'],
    ['title' => 'باص مرج الحمام', 'link' => 'https://chat.whatsapp.com/Bz3Ob8wmDcJKGqYZdA8o0U'],
    ['title' => 'باص طبربور', 'link' => 'https://chat.whatsapp.com/EyCgdYGC6k528CWxl9yMUk'],
    ['title' => 'باص الجامعة الاردنيه', 'link' => 'https://chat.whatsapp.com/HnXAG88AaQrFO6mQpBBvAd'],
    ['title' => 'باص عبدالله غوشة', 'link' => 'https://chat.whatsapp.com/ENncZdfydRnFIOqBWJ6fux'],
    ['title' => 'باص دوار المدينه', 'link' => 'https://chat.whatsapp.com/I5yDzMvBWZZ6Q3bnrkPUio'],
    ['title' => 'باص الهاشمي', 'link' => 'https://chat.whatsapp.com/GAQzDQsx7zFCu4K93ZgZ56'],
    ['title' => 'باص الزهور', 'link' => 'https://chat.whatsapp.com/LKlaiv1KQnUE7U8GKDrS04'],
    ['title' => 'باص العبدلي', 'link' => 'https://chat.whatsapp.com/DmKQxkUfXfnCYka72PlxMJ'],
    ['title' => 'باص صويلح', 'link' => 'https://chat.whatsapp.com/InVIION3up7HZRtLtNN94v'],
    ['title' => 'باص ماركا', 'link' => 'https://chat.whatsapp.com/I3rCCbzomvaDgnSBD12LSQ'],
    ['title' => 'باص ناعور', 'link' => 'https://chat.whatsapp.com/IURGgMXgZCH269dqnKNqqm'],
    ['title' => 'باص النزهة', 'link' => 'https://chat.whatsapp.com/LtcKLotjX0REm3hPK9moc9'],
    ['title' => 'باص ضاحية الرشيد', 'link' => 'https://chat.whatsapp.com/I3MHp5Vq1AyLScgVV7OFIg'],
    ['title' => 'باص ابو نصير', 'link' => 'https://chat.whatsapp.com/CrG784EE3l8KSzn36U0RUJ'],
    ['title' => 'باص الدوار الثاني', 'link' => 'https://chat.whatsapp.com/EdlVAhmqRjS71NcDWaE1sa'],
    ['title' => 'باص الدوار الخامس', 'link' => 'https://chat.whatsapp.com/D2wnErtIS9XCRupuDazOyI'],
    ['title' => 'باص ابو علندا', 'link' => 'https://chat.whatsapp.com/JuKnA0CCQXS1RLmYxrl2nd'],
    ['title' => 'باص خلدا', 'link' => 'https://chat.whatsapp.com/BcSgssWME02B7Te1OyZ0Bs'],
    ['title' => 'باص القويسمه', 'link' => 'https://chat.whatsapp.com/Jwlbqstvbd3AuJON820G1p'],
    ['title' => 'باص الجاردنز', 'link' => 'https://chat.whatsapp.com/D0OVheE2pXmF4pOIgQ1uBk'],
    ['title' => 'باص جبل النصر', 'link' => 'https://chat.whatsapp.com/JVkebxeXYas4DWriN8OxSj'],
    ['title' => 'باص سحاب العز', 'link' => 'https://chat.whatsapp.com/KmORZ36M89B92JQ0VusFOv'],
    ['title' => 'باص ضاحية الأمير علي', 'link' => 'https://chat.whatsapp.com/GqOoI6fY5gM5VR1v7VTQhO']
];

$madaba_buses = [
    ['title' => 'باص مادبا غربي', 'link' => 'https://chat.whatsapp.com/DpjLcrzZ3CtCJjO8TjWBkg'],
    ['title' => 'باص مادبا شرقي', 'link' => 'https://chat.whatsapp.com/JIOXt80rDjw5unB2FmHE70'],
    ['title' => 'باص مادبا الروضة', 'link' => 'https://chat.whatsapp.com/K25EU6DexsT3weizx3i94C'],
    ['title' => 'باص مادبا مخيم', 'link' => 'https://chat.whatsapp.com/EYFfA5GDXac9VmErRmxRLE']
];

$other_buses = [
    ['title' => 'باص الزرقاء', 'link' => 'https://chat.whatsapp.com/IwDrlpefRmO8QgkjClcuRc'],
    ['title' => 'باص البقعه', 'link' => 'https://chat.whatsapp.com/IfCDrTFSQTZGPk6Biib3hT'],
    ['title' => 'باص السلط', 'link' => 'https://chat.whatsapp.com/HmcJhE09uDE0qv8XPhZQO3'],
    ['title' => 'باص زيزيا', 'link' => 'https://chat.whatsapp.com/Cj5ceAlbuUBH0yEyujY9m0'],
    ['title' => 'باص الشونة', 'link' => 'https://chat.whatsapp.com/JsKSYe5N3VqKTa44A2xsIv_']
];

// مصفوفة المسارات الحقيقية (اسم المنطقة وبجانبها اسم ملف الصورة المناسب)
// يمكنك تعديل أسماء الصور والخطوط هنا بأي وقت
$route_images = [
    ['region' => 'مسار باصات عمان وضواحيها', 'img' => 'amman_route.png'],
    ['region' => 'مسار باصات صويلح والسلط', 'img' => 'salt_route.png'],
    ['region' => 'مسار خط الزرقاء والرصيفة', 'img' => 'zarqa_route.png'],
    ['region' => 'مسار خطوط مادبا وقراها', 'img' => 'madaba_route.png']
];
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بوابة النشامى - المواصلات الجامعية</title>
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

        .header-logo {
            width: 50px;
            height: auto;
        }

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

        .btn-back:hover {
            background-color: #b4031a;
        }

        main {
            max-width: 1100px;
            width: 90%;
            margin: 40px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .page-title {
            text-align: center;
            margin-bottom: 30px;
            color: #b4031a;
            font-size: 26px;
        }

        /* تنسيق كارد التتبع المباشر */
        .tracking-card {
            background: linear-gradient(135deg, #111111, #2c3e50);
            color: #ffffff;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 35px;
            border-right: 6px solid #b4031a;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .tracking-info h3 {
            font-size: 18px;
            color: #ffffff;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .credentials-box {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 5px;
        }

        .cred-item {
            background-color: rgba(255, 255, 255, 0.15);
            padding: 6px 14px;
            border-radius: 5px;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .cred-item strong {
            color: #f39c12;
        }

        .btn-track {
            background-color: #b4031a;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 10px rgba(180, 3, 26, 0.3);
        }

        .btn-track:hover {
            background-color: #d6041e;
            transform: translateY(-2px);
        }

        .tabs-container {
            display: flex;
            justify-content: center;
            border-bottom: 2px solid #eeeeee;
            margin-bottom: 30px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 12px 24px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            background: none;
            border: none;
            color: #666666;
            position: relative;
            transition: color 0.3s ease;
        }

        .tab-btn:hover {
            color: #b4031a;
        }

        .tab-btn.active {
            color: #b4031a;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #b4031a;
            border-radius: 3px;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.4s ease;
        }

        .tab-content.active {
            display: block;
        }

        .region-section {
            margin-bottom: 30px;
            background-color: #fafafa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #eaeaea;
        }

        .region-title {
            font-size: 18px;
            font-weight: 700;
            color: #111111;
            margin-bottom: 15px;
            border-right: 4px solid #b4031a;
            padding-right: 10px;
        }

        .transport-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 15px;
        }

        .transport-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.01);
            border-right: 4px solid #b4031a;
        }

        /* استايل كارد عرض المسارات بالصور */
        .route-card {
            background-color: #ffffff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }

        .route-card h3 {
            font-size: 16px;
            color: #111111;
            margin-bottom: 12px;
            font-weight: 700;
        }

        .route-img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: contain;
            border-radius: 6px;
            border: 1px solid #eeeeee;
        }

        /* استايل معرض صور الجولات */
        .tours-container {
            text-align: center;
        }

        .tour-schedule-img {
            width: 100%;
            max-width: 800px;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid #ddd;
        }

        .link-btn {
            background-color: #25d366;
            color: #ffffff;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            transition: background-color 0.3s;
        }

        .link-btn:hover {
            background-color: #128c7e;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
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
        <h2 class="page-title">دليل المواصلات والنقل الجامعي</h2>

        <div class="tracking-card">
            <div class="tracking-info">
                <h3>📍 نظام تتبع حركة الباصات المباشر (GPS)</h3>
                <p style="color: #bdc3c7; font-size: 13px; margin-bottom: 8px;">يمكنك متابعة موقع الباص الخاص بخطك ومعرفة مكان تواجده الحالي باستخدام بيانات الدخول التالية:</p>
                <div class="credentials-box">
                    <div class="cred-item">اسم المستخدم: <strong>zuj@buses.un</strong></div>
                    <div class="cred-item">كلمة المرور: <strong>z@123456</strong></div>
                </div>
            </div>
            <a href="https://gpsrb.telecomcube.com/mobile/index.php" target="_blank" class="btn-track">فتح نظام التتبع الحي 🗺️</a>
        </div>

        <div class="tabs-container">
            <button class="tab-btn active" onclick="openTab(event, 'bus-tab')">قروبات الباصات 🚌</button>
            <button class="tab-btn" onclick="openTab(event, 'tours-tab')">الجولات اليومية 📅</button>
            <button class="tab-btn" onclick="openTab(event, 'routes-tab')">المسارات والنقل 📍</button>
        </div>

        <div id="bus-tab" class="tab-content active">
            
            <div class="region-section">
                <div class="region-title">خطوط باصات عمان وضواحيها</div>
                <div class="transport-grid">
                    <?php foreach ($amman_buses as $bus): ?>
                        <div class="transport-card">
                            <h3><?php echo $bus['title']; ?></h3>
                            <a href="<?php echo $bus['link']; ?>" target="_blank" class="link-btn">انضم للقروب 💬</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="region-section">
                <div class="region-title">خطوط باصات مادبا ومحيطها</div>
                <div class="transport-grid">
                    <?php foreach ($madaba_buses as $bus): ?>
                        <div class="transport-card">
                            <h3><?php echo $bus['title']; ?></h3>
                            <a href="<?php echo $bus['link']; ?>" target="_blank" class="link-btn">انضم للقروب 💬</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="region-section">
                <div class="region-title">خطوط المحافظات  الأخرى</div>
                <div class="transport-grid">
                    <?php foreach ($other_buses as $bus): ?>
                        <div class="transport-card">
                            <h3><?php echo $bus['title']; ?></h3>
                            <a href="<?php echo $bus['link']; ?>" target="_blank" class="link-btn">انضم للقروب 💬</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div id="tours-tab" class="tab-content">
            <div class="tours-container">
                <h3 style="margin-bottom: 15px; font-size: 16px;">مواعيد انطلاق جولات الباصات الرسمية اليومية</h3>
                <img src="tours_schedule.png" alt="جدول مواعيد الجولات اليومية" class="tour-schedule-img">
            </div>
        </div>

        <div id="routes-tab" class="tab-content">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); gap: 25px;">
                <?php foreach ($route_images as $route): ?>
                    <div class="route-card">
                        <h3>📍 <?php echo $route['region']; ?></h3>
                        <img src="<?php echo $route['img']; ?>" alt="<?php echo $route['region']; ?>" class="route-img">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script>
        function openTab(evt, tabId) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
            }
            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabId).classList.add("active");
            evt.currentTarget.classList.add("active");
            window.scrollTo({top: 0, behavior: 'smooth'});
        }
    </script>

</body>
</html>