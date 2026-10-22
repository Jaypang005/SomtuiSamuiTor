<?php
require_once 'config.php';

// 1) ภาพรวมงานแจ้งซ่อม (สัปดาห์ที่ 3 จะนับจากข้อมูลจริงแทนการพิมพ์ตัวเลขเอง)
$completedJobs  = 10; // int
$inProgressJobs = 5;  // int
$pendingJobs    = 5;  // int
$totalJobs = $completedJobs + $inProgressJobs + $pendingJobs;
$completedPercent = $totalJobs > 0 ? ($completedJobs / $totalJobs) * 100 : 0;          // float
$pendingPercent   = $totalJobs > 0 ? round($pendingJobs / $totalJobs * 100, 1) : 0;    // float
$hasPending   = $pendingJobs > 0;                                                       // bool
$allCompleted = $totalJobs > 0 && $completedJobs == $totalJobs;                         // bool

// 2) งานแจ้งซ่อมล่าสุด 1 รายการ
$reporter    = 'อาจารย์สมชาย ใจดี';
$contact     = '081-234-5678';
$location    = 'ห้องคอมพิวเตอร์ 2 ตึก 4';
$deviceName  = 'คอมพิวเตอร์เปิดไม่ติด';
$qty         = 3;
$reportDate  = '2026-10-20';
$dueDate     = date('Y-m-d', strtotime($reportDate . ' +' . SLA_DAYS . ' days'));
$today       = date('Y-m-d');
$daysOverdue = intdiv(strtotime($today) - strtotime($dueDate), 86400);
$isOverdue   = $daysOverdue > 0;

// 3) เงื่อนไขการเตือน
$needAlert  = $pendingPercent >= ALERT_PENDING_PERCENT || $isOverdue;
$statusText = $isOverdue ? "เกินกำหนด $daysOverdue วัน" : 'ยังไม่เกินกำหนด';

// ---- ข้อมูลประกอบหน้าตา (ตัวอย่างคงที่ ยังไม่ใช้ฐานข้อมูล) ----
$thDays = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
$thMonths = ['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
$thDate = 'วัน' . $thDays[date('w')] . 'ที่ ' . date('j') . ' ' . $thMonths[(int)date('n')] . ' ' . (date('Y') + 543) . ' ' . date('H:i') . ' น.';

$stats = [ // ชื่อ, ค่า, สี, ไอคอน, % เปลี่ยนแปลง(ตัวอย่าง), จุดกราฟเล็ก, เตือนไหม
  ['งานทั้งหมด', $totalJobs, '#3b82f6', '📄', '▲ 12%', '0,22 15,14 30,19 45,9 60,15 75,5 90,11', false],
  ['รอตรวจสอบ', $pendingJobs, '#f59e0b', '🕓', '▲ 8%', '0,18 15,22 30,12 45,16 60,8 75,14 90,6', $pendingPercent >= ALERT_PENDING_PERCENT],
  ['กำลังดำเนินการ', $inProgressJobs, '#8b5cf6', '⚙️', '▲ 5%', '0,20 15,12 30,17 45,8 60,13 75,7 90,12', false],
  ['สำเร็จแล้ว', $completedJobs, '#10b981', '✔', '▲ 10%', '0,24 15,18 30,20 45,12 60,14 75,6 90,8', false],
];
$weekLabels = ['จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์','อาทิตย์'];
$series = [
  ['ทั้งหมด', '#3b82f6', [8, 12, 9, 14, 11, 13, 10]],
  ['เสร็จสิ้น', '#10b981', [5, 7, 6, 9, 8, 9, 7]],
  ['รอดำเนินการ', '#f59e0b', [3, 4, 2, 4, 2, 3, 2]],
];
$donut = [
  ['เสร็จสิ้น', $completedJobs, '#10b981'],
  ['กำลังดำเนินการ', $inProgressJobs, '#8b5cf6'],
  ['รอตรวจสอบ', $pendingJobs, '#f59e0b'],
];
$recent = [
  ['#00024', $deviceName . ' ' . $qty . ' เครื่อง', $reporter, $reportDate, 'รอตรวจสอบ'],
  ['#00023', 'อินเทอร์เน็ตช้า ห้องสมุด', 'นางสาวพิมพ์ ใจดี', '2026-10-19', 'กำลังดำเนินการ'],
  ['#00022', 'Wi-Fi ใช้งานไม่ได้ ตึก 2', 'นายวิชัย แสงทอง', '2026-10-18', 'กำลังดำเนินการ'],
  ['#00021', 'ติดตั้งโปรแกรม Microsoft Office', 'อาจารย์สุดา มีสุข', '2026-10-17', 'สำเร็จแล้ว'],
  ['#00020', 'เครื่องพิมพ์ไม่ทำงาน ห้องธุรการ', 'นางมาลี รักงาน', '2026-10-16', 'สำเร็จแล้ว'],
];
$badge = ['สำเร็จแล้ว' => 'g', 'กำลังดำเนินการ' => 'p', 'รอตรวจสอบ' => 'o'];
$menu = [['📊','Dashboard','index.php'],['➕','แจ้งงานใหม่','#'],['📋','รายการงานของฉัน','#'],['🗂️','รายการงานทั้งหมด','#'],['👤','ข้อมูลผู้ใช้','#']];
$admin = [['🗃️','จัดการงานทั้งหมด'],['🔄','เปลี่ยนสถานะงาน'],['📈','รายงานสถิติ'],['🕘','ประวัติการดำเนินงาน'],['👥','จัดการผู้ใช้']];
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo APP_NAME; ?></title>
<style>
*{box-sizing:border-box}
body{margin:0;display:grid;grid-template-columns:230px 1fr;min-height:100vh;background:#eef2fa;color:#1d2740;font-family:'Sarabun','Noto Sans Thai','Segoe UI',Tahoma,sans-serif}
aside.side{background:linear-gradient(180deg,#0b2152,#13306f);color:#cfd9f5;padding:18px 12px;display:flex;flex-direction:column;gap:4px;font-size:14px}
.logo{display:flex;align-items:center;gap:10px;color:#fff;font-weight:700;font-size:20px;margin-bottom:4px}
.logo i{background:#3b82f6;border-radius:10px;width:36px;height:36px;display:grid;place-items:center;font-style:normal}
.side small{color:#8fa3d6;font-size:11px;margin-bottom:12px;display:block}
.side h6{margin:14px 8px 4px;font-size:11px;color:#7f93c8;font-weight:400}
.side a,.side span.it{display:block;padding:9px 12px;border-radius:9px;color:#cfd9f5;text-decoration:none}
.side a:hover{background:rgba(255,255,255,.08)}
.side a.on{background:#2f6bff;color:#fff;font-weight:600}
.side .bot{margin-top:auto}
.page{padding:16px 22px 28px;min-width:0}
.top{display:flex;align-items:center;gap:14px;margin-bottom:14px}
.top .s{flex:1;max-width:340px;background:#fff;border-radius:10px;padding:9px 14px;color:#8a96b3;font-size:14px}
.top .r{margin-left:auto;display:flex;align-items:center;gap:16px;font-size:14px}
.av{background:#fff;border-radius:999px;padding:4px 14px 4px 4px;display:flex;align-items:center;gap:8px;font-weight:600}
.av i{background:#2f6bff;color:#fff;border-radius:50%;width:30px;height:30px;display:grid;place-items:center;font-style:normal}
.hi{display:flex;justify-content:space-between;align-items:flex-end;margin-bottom:14px}
.hi h1{margin:0;font-size:26px}.hi p{margin:2px 0 0;color:#6a7692;font-size:14px}.hi span{color:#6a7692;font-size:14px}
.c{background:#fff;border-radius:14px;padding:16px 18px;box-shadow:0 4px 14px rgba(20,40,100,.07)}
.c h3{margin:0 0 12px;font-size:16px}
.cards{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:14px}
.st{display:flex;align-items:center;gap:12px}
.st .ic{width:46px;height:46px;border-radius:12px;display:grid;place-items:center;color:#fff;font-size:20px;flex:none}
.st small{display:block;color:#6a7692;font-size:13px}.st b{font-size:30px;line-height:1.15}.st em{display:block;font-style:normal;font-size:12px;color:#10b981}
.st .sp{margin-left:auto;width:70px;height:28px}
.st.warn{background:#fff3f3;outline:2px solid #f6c3c5}
.alert{background:#fff1f1;border:1px solid #f6c3c5;color:#a12b30;font-weight:600;border-radius:12px;padding:12px 16px;margin-bottom:14px}
.grid{display:grid;grid-template-columns:1.5fr 1fr 1fr;gap:14px}
.grid .tbl{grid-column:1/3}.grid .rt{grid-column:3;grid-row:1/3;display:flex;flex-direction:column;gap:14px}
.lg{display:flex;gap:14px;font-size:12px;color:#6a7692;margin-bottom:6px}
.dot{display:inline-block;width:9px;height:9px;border-radius:50%;margin-right:5px}
.dn{display:flex;align-items:center;gap:14px;flex-wrap:wrap;justify-content:center}
.dn ul{list-style:none;margin:0;padding:0;font-size:13px;line-height:1.9}
table{width:100%;border-collapse:collapse;font-size:13px}
th{text-align:left;color:#6a7692;font-weight:500;padding:8px 6px;border-bottom:1px solid #e4e9f4}
td{padding:10px 6px;border-bottom:1px solid #f0f3fa}
.bd{display:inline-block;padding:2px 10px;border-radius:999px;font-size:12px;font-weight:600}
.bd.g{background:#dcf5ea;color:#0f6e4c}.bd.p{background:#ece4fd;color:#6a3fc2}.bd.o{background:#fdeed2;color:#a86a00}
.li{display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:1px solid #f0f3fa;font-size:13px}
.li:last-child{border:0}.li div{flex:1;min-width:0}.li small{display:block;color:#8a96b3;font-size:11px}
.new{background:linear-gradient(135deg,#1f3f9c,#2f6bff);color:#fff;text-align:center}
.new a{display:inline-block;margin-top:8px;background:#fff;color:#1f3f9c;padding:8px 18px;border-radius:10px;font-weight:700;text-decoration:none}
.mini{display:grid;grid-template-columns:1fr 1fr;gap:10px;text-align:center}.mini b{font-size:24px;display:block}.mini small{color:#6a7692}
@media(max-width:1000px){body{grid-template-columns:1fr}.cards{grid-template-columns:1fr 1fr}.grid{grid-template-columns:1fr}.grid .tbl,.grid .rt{grid-column:1;grid-row:auto}}
</style>
</head>
<body>
<aside class="side">
  <div class="logo"><i>🛠️</i>UniServe</div>
  <small>ระบบแจ้งซ่อมและติดตามสถานะงาน IT</small>
  <nav>
    <?php foreach ($menu as [$ic, $name, $href]): ?>
      <a href="<?php echo $href; ?>" class="<?php echo $href == 'index.php' ? 'on' : ''; ?>"><?php echo $ic . ' ' . $name; ?></a>
    <?php endforeach; ?>
    <h6>ส่วนของ Admin</h6>
    <?php foreach ($admin as [$ic, $name]): ?>
      <a href="#"><?php echo $ic . ' ' . $name; ?></a>
    <?php endforeach; ?>
    <h6>โครงงาน</h6>
    <a href="about.php">ℹ️ เกี่ยวกับโครงงาน</a>
    <a href="server.php">🖥️ ข้อมูลเซิร์ฟเวอร์</a>
  </nav>
  <div class="bot"><a href="#">⚙️ ตั้งค่า</a><a href="#">↪ ออกจากระบบ</a></div>
</aside>

<div class="page">
  <div class="top">
    <span>☰</span><div class="s">🔍 ค้นหา...</div>
    <div class="r"><span>🔔</span><div class="av"><i>A</i>Admin</div></div>
  </div>
  <div class="hi">
    <div><h1>สวัสดี, แอดมิน! 👋</h1><p>ยินดีต้อนรับสู่ระบบแจ้งซ่อมและติดตามสถานะงาน IT</p></div>
    <span>📅 <?php echo $thDate; ?></span>
  </div>

  <?php if ($needAlert): ?>
    <div class="alert">⚠️ ต้องติดตาม: มีงานรอดำเนินการมาก หรือมีงานเกินกำหนดซ่อม · งานล่าสุด<?php echo $statusText; ?></div>
  <?php endif; ?>

  <div class="cards">
    <?php foreach ($stats as [$label, $num, $color, $icon, $chg, $pts, $warn]): ?>
      <div class="c st <?php echo $warn ? 'warn' : ''; ?>">
        <div class="ic" style="background:<?php echo $color; ?>"><?php echo $icon; ?></div>
        <div><small><?php echo $label; ?></small><b><?php echo $num; ?></b><em><?php echo $chg; ?></em></div>
        <svg class="sp" viewBox="0 0 90 28"><polyline fill="none" stroke="<?php echo $color; ?>" stroke-width="2" points="<?php echo $pts; ?>"/></svg>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="grid">
    <div class="c">
      <h3>สรุปจำนวนงานในช่วง 7 วัน</h3>
      <div class="lg"><?php foreach ($series as [$n, $col]): ?><span><i class="dot" style="background:<?php echo $col; ?>"></i><?php echo $n; ?></span><?php endforeach; ?></div>
      <svg viewBox="0 0 520 200" width="100%">
        <?php foreach ([0, 4, 8, 12, 16] as $v): $y = 170 - $v / 16 * 160; ?>
          <line x1="30" x2="500" y1="<?php echo $y; ?>" y2="<?php echo $y; ?>" stroke="#e8edf7"/>
          <text x="22" y="<?php echo $y + 4; ?>" font-size="10" fill="#8a96b3" text-anchor="end"><?php echo $v; ?></text>
        <?php endforeach; ?>
        <?php foreach ($weekLabels as $i => $d): ?>
          <text x="<?php echo 30 + $i * 78.3; ?>" y="190" font-size="10" fill="#8a96b3" text-anchor="middle"><?php echo $d; ?></text>
        <?php endforeach; ?>
        <?php foreach ($series as [$n, $col, $vals]):
          $pts = [];
          foreach ($vals as $i => $v) { $pts[] = round(30 + $i * 78.3, 1) . ',' . round(170 - $v / 16 * 160, 1); } ?>
          <polyline fill="none" stroke="<?php echo $col; ?>" stroke-width="2.5" stroke-linejoin="round" points="<?php echo implode(' ', $pts); ?>"/>
        <?php endforeach; ?>
      </svg>
    </div>

    <div class="c">
      <h3>สถานะงานทั้งหมด</h3>
      <div class="dn">
        <svg viewBox="0 0 100 100" width="130" height="130">
          <?php $C = 2 * M_PI * 38; $off = 0;
          foreach ($donut as [$n, $cnt, $col]):
            $len = $totalJobs > 0 ? $cnt / $totalJobs * $C : 0; ?>
            <circle cx="50" cy="50" r="38" fill="none" stroke="<?php echo $col; ?>" stroke-width="14"
              stroke-dasharray="<?php echo round($len, 2) . ' ' . round($C - $len, 2); ?>" stroke-dashoffset="<?php echo round(-$off, 2); ?>" transform="rotate(-90 50 50)"/>
            <?php $off += $len; endforeach; ?>
          <text x="50" y="48" text-anchor="middle" font-size="9" fill="#6a7692">งานทั้งหมด</text>
          <text x="50" y="64" text-anchor="middle" font-size="18" font-weight="700" fill="#1d2740"><?php echo $totalJobs; ?></text>
        </svg>
        <ul>
          <?php foreach ($donut as [$n, $cnt, $col]): ?>
            <li><i class="dot" style="background:<?php echo $col; ?>"></i><?php echo $n . ' ' . $cnt . ' (' . ($totalJobs > 0 ? round($cnt / $totalJobs * 100) : 0) . '%)'; ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <div class="rt">
      <div class="c">
        <h3>งานล่าสุด</h3>
        <?php foreach ($recent as $r): ?>
          <div class="li"><span>🔧</span><div><?php echo $r[1]; ?><small><?php echo $r[3]; ?></small></div><span class="bd <?php echo $badge[$r[4]]; ?>"><?php echo $r[4]; ?></span></div>
        <?php endforeach; ?>
      </div>
      <div class="c new"><b>แจ้งงานใหม่</b><br><small>แจ้งปัญหา หรือขอความช่วยเหลือ</small><br><a href="#">＋ เพิ่มงานใหม่</a></div>
      <div class="c"><h3>สถิติวันนี้</h3><div class="mini"><div><b>12</b><small>ผู้ใช้งานวันนี้</small></div><div><b>7</b><small>งานที่ปิดวันนี้</small></div></div></div>
    </div>

    <div class="c tbl">
      <h3>รายการงานล่าสุด</h3>
      <table>
        <tr><th>#</th><th>หัวข้อ</th><th>ผู้แจ้ง</th><th>วันที่แจ้ง</th><th>สถานะ</th></tr>
        <?php foreach ($recent as $r): ?>
          <tr><td><?php echo $r[0]; ?></td><td><?php echo $r[1]; ?></td><td><?php echo $r[2]; ?></td><td><?php echo $r[3]; ?></td>
              <td><span class="bd <?php echo $badge[$r[4]]; ?>"><?php echo $r[4]; ?></span></td></tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
  <p style="text-align:center;color:#8a96b3;font-size:12px;margin-top:18px">พัฒนาโดยทีม <?php echo TEAM_NAME; ?></p>
</div>
</body>
</html>