<?php 
session_start();
include 'config.php';

$id_elic = !empty($_POST['id_elic']) ? $_POST['id_elic'] : null;
$re_nameelic = trim($_POST['re_nameelic']);
$customer_nameelic = trim($_POST['customer_nameelic']);
$datesaveelic = trim($_POST['datesaveelic']);
$datefinishelic = trim($_POST['datefinishelic']);
$namesaveelic = trim($_POST['namesaveelic']);
$detail_eli = trim($_POST['detail_eli']);
$status_elic = trim($_POST['status_elic']);

$search = !empty($_POST['search']) ? $_POST['search'] : '';
$search_url = $search ? '?search=' . urlencode($search) : '';

$image_name_elic = $_FILES['picelic_elic']['name'];
$image_tmp_elic = $_FILES['picelic_elic']['tmp_name'];
$folder = 'upload_image_elic/';
$image_location_elic = $folder . $image_name_elic;

// ถ้าเป็นการอัปเดต
if ($id_elic) {
    if (!empty($image_name_elic)) {
        move_uploaded_file($image_tmp_elic, $image_location_elic);
        $query = mysqli_query($conn, "
            UPDATE requireelic SET
                re_nameelic = '$re_nameelic',
                customer_nameelic = '$customer_nameelic',
                datesaveelic = '$datesaveelic',
                datefinishelic = '$datefinishelic',
                namesaveelic = '$namesaveelic',
                detail_eli = '$detail_eli',
                picelic_elic = '$image_name_elic',
                status_elic = '$status_elic'
            WHERE id_elic = '$id_elic'
        ");
    } else {
        $query = mysqli_query($conn, "
            UPDATE requireelic SET
                re_nameelic = '$re_nameelic',
                customer_nameelic = '$customer_nameelic',
                datesaveelic = '$datesaveelic',
                datefinishelic = '$datefinishelic',
                namesaveelic = '$namesaveelic',
                detail_eli = '$detail_eli',
                status_elic = '$status_elic'
            WHERE id_elic = '$id_elic'
        ");
    }

    $_SESSION['message'] = $query ? 'Requirement updated successfully' : 'Failed to update Requirement';
} else {
    $query = mysqli_query($conn, "
        INSERT INTO requireelic (
            re_nameelic,
            customer_nameelic,
            datesaveelic,
            datefinishelic,
            namesaveelic,
            detail_eli,
            picelic_elic,
            status_elic
        ) VALUES (
            '$re_nameelic',
            '$customer_nameelic',
            '$datesaveelic',
            '$datefinishelic',
            '$namesaveelic',
            '$detail_eli',
            '$image_name_elic',
            '$status_elic'
        )
    ");

    if ($query) {
        move_uploaded_file($image_tmp_elic, $image_location_elic);
    }

    $_SESSION['message'] = $query ? 'Requirement saved successfully' : 'Failed to save Requirement';
}

header('Location: ' . $base_url . '/elicenseRe.php' . $search_url);
exit();
?>