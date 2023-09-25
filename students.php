<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="bg-light">
    <?php require_once('./data.php'); ?>
    <div class="container d-flex flex-column justify-content-flex-start">
        <table class="table text-center ">
                <th>ลำดับ</th>
                <th>รหัสนิสิต (ID)</th>
                <th>อีเมล (email)</th>
                <th>Name</th>
                <th>Surname</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>Major</th>
                <th></th>
            <tbody class="table-group-divider align-middle">
                <?php
                    if($_SERVER["REQUEST_METHOD"] === "GET"){
                        if(isset($_GET["status"])){
                            $status = $_GET["status"];
                            if($status === '1'){
                                echo "<script> Swal.fire('ลบข้อมูลสำเร็จ', '') </script>";
                            }else if($status === '2'){
                                echo "<script> Swal.fire('เพิ่มข้อมูลสำเร็จ', '') </script>";
                            }else if($status === '3'){
                                echo "<script> Swal.fire('อัพเดตข้อมูลสำเร็จ', '') </script>";
                            }
                        }
                    }
                    $sql = "SELECT `id`, `en_name`, `en_surname`, `th_name`, `th_surname`, `major_code`, `email` FROM `std_info`";
                    $query = mysqli_query($connection, $sql);
                    if(!$query){
                        die('<script> Swal.fire("การแสดงข้อมูลล้มเหลว", "") </script>');
                    }else{
                        $index = 1;
                        while($result = mysqli_fetch_object($query)){
                ?>
                        <tr>
                            <th><?php echo $index ?></th>
                            <td><?php echo $result->id ?></td>
                            <td><?php echo $result->email ?></td>
                            <td><?php echo $result->en_name ?></td>
                            <td><?php echo $result->en_surname ?></td>
                            <td><?php echo $result->th_name ?></td>
                            <td><?php echo $result->th_surname ?></td>
                            <td><?php echo $result->major_code ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="./update.php?id=<?php echo $result->id ?>" class="btn ">
                                        แก้ไข
                                    </a>
                                    <a href="./delete.php?id=<?php echo $result->id ?>" class="btn">
                                        ลบ
                                    </a>
                                </div>
                            </td>
                        </tr>
                <?php ++$index; } } ?>
            </tbody>
        </table>
        <div class="mb-2">
        <a href='insert.php'>Insert new record</a>
        </div>
    </div>
    <?php mysqli_close($connection); ?>
    </body>
</html>