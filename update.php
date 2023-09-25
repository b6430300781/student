<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
    <?php
    require_once('./data.php');
    $error = [
        "id" => "",
        "email" => "",
        "en_name" => "",
        "en_surname" => "",
        "th_name" => "",
        "th_surname" => "",
        "major_code" => "",
    ];
    $id_old = $_GET["id"];
    $id = $email = $en_name = $en_surname = $th_name = $th_surname = $major_code = "";

    function protectInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        empty($_POST["id"]) ? $error["id"] = "*กรุณากรอกรหัสนักศึกษา" : $id = protectInput($_POST["id"]);
        if(!empty($_POST["email"])){
            !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) ? $error["email"] = "*ระบุรูปแบบอีเมลให้ถูกต้อง" : $email = protectInput($_POST["email"]);
        }
        empty($_POST["en_name"]) ? $error["en_name"] = "*กรุณากรอกชื่อ" : $en_name = protectInput($_POST["en_name"]);
        empty($_POST["en_surname"]) ? $error["en_surname"] = "*กรุณากรอกนามสกุล" : $en_surname = protectInput($_POST["en_surname"]);
        empty($_POST["th_name"]) ? $error["th_name"] = "*กรุณากรอกชื่อ" : $th_name = protectInput($_POST["th_name"]);
        empty($_POST["th_surname"]) ? $error["th_surname"] = "*กรุณากรอกนามสกุล" : $th_surname = protectInput($_POST["th_surname"]);
        if(!empty($_POST["email"])){
            $major_code = protectInput($_POST["major_code"]);
        }
        if(empty($error["email"]) && empty($error["major_code"]) && !empty($_POST["id"]) && !empty($_POST["en_name"]) && !empty($_POST["en_surname"]) && !empty($_POST["th_name"]) && !empty($_POST["th_surname"])){
            $sql = "UPDATE `std_info` SET `id`='$id',`en_name`='$en_name',`en_surname`='$en_surname',`th_name`='$th_name',`th_surname`='$th_surname',`major_code`='$major_code',`email`='$email' WHERE `id` = $id_old";
            $query = mysqli_query($connection, $sql);
            if(!$query){
                echo '<script> Swal.fire("การเพิ่มข้อมูลล้มเหลว", "") </script>';
            }else{
                header("Location: ./students.php?status=3");
                exit();
            }
        }else{
            echo '<script> Swal.fire("กรุณากรอกข้อมูลให้ถูกต้อง", "") </script>';
        }
    }
    ?>
    <div class="container d-flex flex-column justify-content-flex-start align-items-center">
            <div class="h3">แก้ไข</div>
                <?php
                    $sql = "SELECT `id`, `en_name`, `en_surname`, `th_name`, `th_surname`, `major_code`, `email` FROM `std_info` WHERE `id` = '$id_old'";
                    $query = mysqli_query($connection, $sql);
                    if(!$query){
                        die('<script> Swal.fire("การแสดงข้อมูลล้มเหลว", "") </script>');
                    }else{
                        while($result = mysqli_fetch_object($query)){
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $result->id); ?>" method="post" class="row">
                id: <input name="id" type="text" id="studentID" value="<?php echo $result->id ?>"></br>
                name:<input name="en_name" type="text" id="studentNameEng" value="<?php echo $result->en_name ?>"></br>
                surname:<input name="en_surname" type="text" id="studentSurnameEng" value="<?php echo $result->en_surname ?>"></br>
                ชื่อ:<input name="th_name" type="text" id="studentNameTh" value="<?php echo $result->th_name ?>"></br>
                นามสกุล:<input name="th_surname" type="text" id="studentSurnameTh" value="<?php echo $result->th_surname ?>"></br>
                major:<input name="major_code" type="text" id="studentMajor" value="<?php echo $result->major_code ?>"></br>
                Email:<input name="email" type="text" id="studentEmail" value="<?php echo $result->email ?>"></br>
                <button type="submit" class="col-1  ms-3">Update</button>
                <a href="./students.php" class="col-1  ms-3">Reset</a>
                </form>
                <?php } } ?>
    </div>
    <?php mysqli_close($connection); ?>
</body>
</html>