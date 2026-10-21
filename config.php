<?php
// config.php
const APP_NAME  = 'ระบบยืม–คืนอุปกรณ์';
const LOAN_DAYS = 7;
 
// index.php
require_once 'config.php';
echo APP_NAME;            // ไม่มี $ นำหน้าค่าคงที่
