<?php 
session_start();
include 'config.php';

$idewac = !empty($_POST['idewac']) ? $_POST['idewac'] : null;
$reqnamewac = trim($_POST['reqnamewac']);
$cusnamewac = trim($_POST['cusnamewac']);
$datesaveewac = trim($_POST['datesaveewac']);
$datefinishewac = trim($_POST['datefinishewac']);
$namesavewac = trim($_POST['namesavewac']);
$detailewac = trim($_POST['detailewac']);
$status_ewac = trim($_POST['status_ewac']);

$search = !empty($_POST['search']) ? $_POST['search'] : '';
$search_url = $search ? '?search=' . urlencode($search) : '';

$image_name_ewac = $_FILES['picewac']['name'];
$image_tmp_ewac = $_FILES['picewac']['tmp_name'];
$folder = 'upload_image_ewac/';
$image_location = $folder . $image_name_ewac;

// ถ้าเป็นการอัปเดต
if ($idewac) {
    if (!empty($image_name_ewac)) {
        move_uploaded_file($image_tmp_ewac, $image_location);
        $query = mysqli_query($conn, "
            UPDATE require_ew SET
                reqnamewac = '$reqnamewac',
                cusnamewac = '$cusnamewac',
                datesaveewac = '$datesaveewac',
                datefinishewac = '$datefinishewac',
                namesavewac = '$namesavewac',
                detailewac = '$detailewac',
                picewac = '$image_name_ewac',
                status_ewac = '$status_ewac'
            WHERE idewac = '$idewac'
        ");
    } else {
        $query = mysqli_query($conn, "
            UPDATE require_ew SET
                reqnamewac = '$reqnamewac',
                cusnamewac = '$cusnamewac',
                datesaveewac = '$datesaveewac',
                datefinishewac = '$datefinishewac',
                namesavewac = '$namesavewac',
                detailewac = '$detailewac',
                status_ewac = '$status_ewac'
            WHERE idewac = '$idewac'
        ");
    }

    $_SESSION['message'] = $query ? 'Requirement updated successfully' : 'Failed to update Requirement';
} else {
    $query = mysqli_query($conn, "
        INSERT INTO require_ew (
            reqnamewac,
            cusnamewac,
            datesaveewac,
            datefinishewac,
            namesavewac,
            detailewac,
            picewac,
            status_ewac
        ) VALUES (
            '$reqnamewac',
            '$cusnamewac',
            '$datesaveewac',
            '$datefinishewac',
            '$namesavewac',
            '$detailewac',
            '$image_name_ewac',
            '$status_ewac'
        )
    ");

    if ($query) {
        move_uploaded_file($image_tmp_ewac, $image_location);
    }

    $_SESSION['message'] = $query ? 'Requirement saved successfully' : 'Failed to save Requirement';
}

header('Location: ' . $base_url . '/ewacRe.php' . $search_url);
exit();
?>