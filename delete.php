<?php
require_once('./data.php');

$id = $_GET["id"];
$sql = "DELETE FROM `std_info` WHERE `id` = '$id'";
$query = mysqli_query($connection, $sql);
mysqli_close($connection);
if(!$query){
    die('<script> Swal.fire("การแสดงข้อมูลล้มเหลว", "") </script>');
}else{
    header("Location: ./students.php?status=1");
    exit();
}
?>