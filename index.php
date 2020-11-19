<?php

session_start();
include 'connectDB.php';



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=Logi, initial-scale=1.0">
    <?php include '_headtags.php' ?>
    <title>Login | AntrianKu</title>
</head>
<body>

    <!-- header -->
    <?php include "_navbar.php"; ?>
    <!-- end header -->

    <div class="row center">
        <div class="col s6 offset-s3 card">
            <h3 class="header light center">Silahkan Login Terlebih Dahulu</h3>
            <div class="card-content">
                <form action="" method="post">
                    <ul>
                        <li><button class="btn-large blue darken-2" type="submit" name="loginKaryawan">Login Sebagai Admin</button> <a class="btn-large blue darken-2" href="antrian.php">Login Sebagai Pelanggan</a></li>
                    </ul>
                </form>

                <br>
                <!-- login karyawan -->
                <?php if (isset($_POST["loginKaryawan"])) : ?>

                <h3 class="header light center">Login Admin</h3>
                <div class="login">
                    <form action="" method="post" class="input-field inline">
                        <ul>
                            <li><label for="username">Username</label></li>
                            <li><input type="text" size=40 id="username" name="username" placeholder="Username"></li>
                            <li><label for="password">Password</label></li>
                            <li><input type="password" id="password" name="password" placeholder="Password"></li>
                            <li><button class="btn-large red darken-2" type="submit" name="login">Login</button></li>
                        </ul>
                    </form>
                </div>

                <?php endif; ?>
                <!-- end login karyawan -->
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include "_footer.php"; ?>
    <!-- end footer -->


</body>
</html>

<?php  

if ( isset($_SESSION["admin"])){
    echo "
        <script>
            Swal.fire('Anda Sudah Login','Silahkan Logout Terlebih Dahulu','warning').then(function(){
                window.location = 'dashboard.php';
            });
        </script>
    ";
}

if (isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    // cek apakah ada karyawan
    $karyawan = mysqli_query($connect, "SELECT * from karyawan");

    // kalau gak ada 
    if (mysqli_num_rows($karyawan) < 1){
        mysqli_query($connect, "INSERT INTO karyawan VALUES ('root','root')");
    }

    // cari berdasarkan username
    $karyawan = mysqli_query($connect, "SELECT * from admin where username = '$username'");

    // cek apakah ada username
    if (mysqli_num_rows($karyawan) < 1){
        echo "
            <script>
                Swal.fire('Gagal Login','Username Tidak Ditemukan','error');
            </script>
        ";
        exit;
    }

    $karyawan = mysqli_fetch_assoc($karyawan);

    if ($password != $karyawan['password']){
        echo "
            <script>
                Swal.fire('Gagal Login','Kata Sandi Salah','error');
            </script>
        ";
        exit;
    }

    $_SESSION["admin"] = $username;
    echo "
        <script>
            Swal.fire('Berhasil Login','Anda Akan Dialihkan Ke Halaman Karyawan','success').then(function(){
                window.location = 'dashboard.php';
            });
        </script>
    ";
}

?>