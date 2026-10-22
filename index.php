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
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title><?php echo APP_NAME; ?></title>
  <style>
    body { font-family: sans-serif; margin: 24px; }
    .card { display: inline-block; padding: 12px 20px; margin: 4px; border-radius: 8px; background: #e8eef7; }
    .warn { background: #fde2e1; }
  </style>
</head>
<body>
  <nav>
    <a href="index.php">หน้าแรก</a> |
    <a href="about.php">เกี่ยวกับโครงงาน</a> |
    <a href="server.php">ข้อมูลเซิร์ฟเวอร์</a>
  </nav>

  <h1><?php echo APP_NAME; ?></h1>
  <p>ทีม <?php echo TEAM_NAME; ?> · วันนี้ <?php echo date('d/m/Y'); ?></p>

  <div class="card">งานแจ้งซ่อมทั้งหมด<br><b><?php echo $totalJobs; ?></b> งาน</div>
  <div class="card">ซ่อมเสร็จแล้ว<br><b><?php echo $completedJobs; ?></b> งาน (<?php echo round($completedPercent, 1); ?>%)</div>
  <div class="card">กำลังซ่อม<br><b><?php echo $inProgressJobs; ?></b> งาน</div>
  <div class="card <?php echo $pendingPercent >= ALERT_PENDING_PERCENT ? 'warn' : ''; ?>">รอดำเนินการ<br><b><?php echo $pendingJobs; ?></b> งาน (<?php echo $pendingPercent; ?>%)</div>

  <p><?php echo $allCompleted ? 'งานเสร็จครบทุกงานแล้ว' : ($hasPending ? 'มีงานค้างรอดำเนินการ' : 'ไม่มีงานค้าง'); ?></p>

  <h2>งานแจ้งซ่อมล่าสุด</h2>
  <p><?php echo $reporter . ' แจ้งซ่อม ' . $deviceName . ' จำนวน ' . $qty . ' เครื่อง ที่ ' . $location; ?></p>
  <p>ติดต่อ <?php echo $contact; ?> · วันที่แจ้ง <?php echo $reportDate; ?> · กำหนดเสร็จ <?php echo $dueDate; ?> · <?php echo $statusText; ?></p>

  <?php echo $needAlert ? '<p class="warn">ต้องติดตาม: มีงานรอดำเนินการมาก หรือมีงานเกินกำหนดซ่อม</p>' : ''; ?>
</body>
</html>