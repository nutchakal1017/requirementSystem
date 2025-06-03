<?php
session_start();
include 'config.php';

if (!empty($_GET['idewac'])) {
    $idewac = $_GET['idewac'];

    // ดึงชื่อไฟล์ก่อนลบ
    
    $select = mysqli_query($conn, "SELECT picewac FROM require_ew WHERE idewac='$idewac'");
    $data = mysqli_fetch_assoc($select);

    // ลบรูปออกจากโฟลเดอร์ (ถ้ามี)
    if (!empty($data['picewac'])) {
        $image_path = 'upload_image_ewac/' . $data['picewac'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // ลบข้อมูลจากฐานข้อมูล
    $query = mysqli_query($conn, "DELETE FROM require_ew WHERE idewac='$idewac'");

    $_SESSION['message'] = $query ? 'ลบ Requirement เรียบร้อยแล้วนะคะ ' : 'ลบไม่สำเร็จค่ะ ลองใหม่อีกทีน้า ';
} else {
    $_SESSION['message'] = 'ไม่พบข้อมูลที่ต้องการลบค่ะ ';
}

header('Location: ' . $base_url . '/ewacRe.php');
exit();
?>
?>