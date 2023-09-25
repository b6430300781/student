<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            $sql = "INSERT INTO `std_info`(`id`, `en_name`, `en_surname`, `th_name`, `th_surname`, `major_code`, `email`) VALUES 
            ('$id','$en_name','$en_surname','$th_name','$th_surname','$major_code','$email')";
            $query = mysqli_query($connection, $sql);
            if(!$query){
                echo '<script> Swal.fire("การเพิ่มข้อมูลล้มเหลว", "") </script>';
            }else{
                header("Location: ./students.php?status=2");
                exit();
            }
        }else{
            echo '<script> Swal.fire("กรุณากรอกข้อมูลให้ถูกต้อง", "") </script>';
        }
    }
    ?>
    <div class="container d-flex flex-column justify-content-flex-start align-items-center">
            <div class="h3">เพิ่มข้อมูล</div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="row">
                id:
                <?php if ($error["id"]) { ?>
                            <input name="id" type="text" id="studentID">
                            <div class="invalid-feedback"><?php echo $error["id"]; ?></div>
                        <?php } else if (!empty($id)) { ?>
                            <input name="id" type="text" id="studentID" value="<?php echo $id; ?>">
                        <?php } else { ?>
                            <input name="id" type="text" id="studentID">
                        <?php } ?>
                name:
                <?php if ($error["en_name"]) { ?>
                            <input name="en_name" type="text" id="studentNameEng">
                            <div class="invalid-feedback"><?php echo $error["en_name"]; ?></div>
                        <?php } else if (!empty($en_name)) { ?>
                            <input name="en_name" type="text" id="studentNameEng" value="<?php echo $en_name; ?>">
                        <?php } else { ?>
                            <input name="en_name" type="text" id="studentNameEng">
                        <?php } ?>
                surname:
                <?php if ($error["en_surname"]) { ?>
                            <input name="en_surname" type="text" id="studentSurnameEng">
                            <div class="invalid-feedback"><?php echo $error["en_surname"]; ?></div>
                        <?php } else if (!empty($en_surname)) { ?>
                            <input name="en_surname" type="text" id="studentSurnameEng" value="<?php echo $en_surname; ?>">
                        <?php } else { ?>
                            <input name="en_surname" type="text" id="studentSurnameEng">
                        <?php } ?>
                ชื่อ:
                <?php if ($error["th_name"]) { ?>
                            <input name="th_name" type="text"  id="studentNameTh">
                            <div class="invalid-feedback"><?php echo $error["th_name"]; ?></div>
                        <?php } else if (!empty($th_name)) { ?>
                            <input name="th_name" type="text" id="studentNameTh" value="<?php echo $th_name; ?>">
                        <?php } else { ?>
                            <input name="th_name" type="text" id="studentNameTh">
                        <?php } ?>
                นามสกุล:
                <?php if ($error["th_surname"]) { ?>
                            <input name="th_surname" type="text" id="studentSurnameTh">
                            <div class="invalid-feedback"><?php echo $error["th_surname"]; ?></div>
                        <?php } else if (!empty($th_surname)) { ?>
                            <input name="th_surname" type="text" id="studentSurnameTh" value="<?php echo $th_surname; ?>">
                        <?php } else { ?>
                            <input name="th_surname" type="text" id="studentSurnameTh">
                        <?php } ?>
                major:
                <?php if ($error["major_code"]) { ?>
                            <input name="major_code" type="text" id="studentMajor">
                            <div class="invalid-feedback"><?php echo $error["major_code"]; ?></div>
                        <?php } else if (!empty($major_code)) { ?>
                            <input name="major_code" type="text" id="studentMajor" value="<?php echo $major_code; ?>">
                        <?php } else { ?>
                            <input name="major_code" type="text" id="studentMajor">
                        <?php } ?>
                Email:
                <?php if ($error["email"]) { ?>
                            <input name="email" type="text" id="studentEmail">
                            <div class="invalid-feedback"><?php echo $error["email"]; ?></div>
                        <?php } else if (!empty($email)) { ?>
                            <input name="email" type="text" id="studentEmail" value="<?php echo $email; ?>">
                        <?php } else { ?>
                            <input name="email" type="text" id="studentEmail">
                        <?php } ?>
                </body>
                </html>
                <button type="submit" class="col-1  ms-3">Submit</button>
                    <a href="./students.php" class="col-1  ms-3">Reset</a>
                </form>
    </div>
    <?php mysqli_close($connection); ?>
</body>

</html>