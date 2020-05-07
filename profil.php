<?php 

session_start();
include "connectDB.php";

$username = $_SESSION["admin"];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "_headtags.php"; ?>
    <title>Profil Admin</title>
</head>
<body>
    <!-- header -->
    <?php include "_navbar.php"; ?>
    <!-- end header -->

    <!-- body -->
    <div class="row center">
        <div class="col s6 offset-s3 card">
            <div class="card-content">
                <h3>Ubah Profil Admin</h3>
                <form action="" method="post" class="input-field inline">
                    <ul>
                        <li><label for="username">Username</label></li>
                        <li><input type="text" size=40 id="username" name="username" placeholder="Username" value="<?= $username ?>"></li>
                        <li><button class="btn-large blue darken-2" type="submit" name="simpanUser">Simpan Data</button></li>
                        <br>
                        <li><button name="gantiSandi" class="btn red darken-2">Ganti Kata Sandi</button></li>
                    </ul>
                </form>

                
                <?php if(isset($_POST["gantiSandi"])) : ?>
                    <form action="" method="post" class="input-field inline">
                        <ul>
                            <li><label for="password">Password Lama</label></li>
                            <li><input type="password" size=40 id="password" name="password" placeholder="Password Lama"></li>
                            <li><label for="newPassword">Password Baru</label></li>
                            <li><input type="password" size=40 id="newPassword" name="newPassword" placeholder="Password Baru"></li>
                            <li><label for="rePassword">Ulangi Password Baru</label></li>
                            <li><input type="password" size=40 id="rePassword" name="rePassword" placeholder="Ulangi Password Baru"></li>
                            <li><button name="simpanPass" class="btn red darken-2">Simpan Data</button></li>
                        </ul>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- end body -->

    <!-- footer -->
    <?php include "_footer.php"; ?>
    <!-- end footer -->
</body>
</html>

<?php

if (!isset($_SESSION["admin"])){
    echo "
        <script>
            Swal.fire('Akses Ditolak','Anda Belum Login Sebagai Karyawan','error').then(function(){
                window.location = 'index.php';
            });
        </script>
    ";
}

if (isset($_POST["simpanUser"])){
    $user = $_POST["username"];
    $hasil = mysqli_query($connect, "UPDATE admin set username = '$user' where username = '$username'");
    if (mysqli_affected_rows($connect) > 0){
        $_SESSION["admin"] = $user;
        echo "
            <script>
                Swal.fire('Perubahan Data Berhasil','Username Berhasil Diganti','success').then(function(){
                    window.location = 'profil.php';
                });
            </script>
        ";
    }
    
}

if(isset($_POST["simpanPass"])){
    $pass = $_POST["password"];
    $newPass = $_POST["newPassword"];
    $rePass = $_POST["rePassword"];

    $hasil = mysqli_query($connect, "SELECT * from admin where username = '$username'");
    $hasil = mysqli_fetch_assoc($hasil);

    if ($pass != $hasil["password"]){
        echo "
            <script>
                Swal.fire('Perubahan Data Gagal','Password Lama Salah','error');
            </script>
        ";
        exit;
    }else if($newPass != $rePass){
        echo "
            <script>
                Swal.fire('Perubahan Data Gagal','Password Baru Tidak Sama','error');
            </script>
        ";
        exit;
    }

    mysqli_query($connect, "UPDATE admin set password = '$newPass' where username = '$username'");
    if (mysqli_affected_rows($connect) > 0){
        echo "
            <script>
                Swal.fire('Perubahan Data Berhasil','Password Berhasil Diganti','success').then(function(){
                    window.location = 'profil.php';
                });
            </script>
        ";
    }else {
        echo mysqli_error($connect);
    }
}


?>