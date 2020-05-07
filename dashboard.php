<?php

session_start();
include 'connectDB.php';

$jam = date("H:i:s");

if (isset($_POST["panggilAntrianA"])){
    $query = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' AND loket = 'A' ORDER BY nomor DESC");
    if (mysqli_num_rows($query) > 0){
        $query = mysqli_fetch_assoc($query);
        $nomorSekarang = $query["nomor"];
        mysqli_query($connect, "UPDATE antrian SET status = 'selesai' where nomor = $nomorSekarang");
    }

    $query = mysqli_query($connect, "SELECT * from antrian where status = 'mengantri'");
    $query = mysqli_fetch_assoc($query);

    $nomorSekarang = $query["nomor"];

    mysqli_query($connect, "UPDATE antrian SET status = 'dilayani', loket = 'A', dilayani = '$jam' where nomor = $nomorSekarang");
}

if (isset($_POST["panggilAntrianB"])){
    $query = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' AND loket = 'B' ORDER BY nomor DESC");
    if (mysqli_num_rows($query) > 0){
        $query = mysqli_fetch_assoc($query);
        $nomorSekarang = $query["nomor"];
        mysqli_query($connect, "UPDATE antrian SET status = 'selesai' where nomor = $nomorSekarang");
    }

    $query = mysqli_query($connect, "SELECT * from antrian where status = 'mengantri'");
    $query = mysqli_fetch_assoc($query);

    $nomorSekarang = $query["nomor"];

    mysqli_query($connect, "UPDATE antrian SET status = 'dilayani', loket = 'B', dilayani = '$jam' where nomor = $nomorSekarang");
}

if (isset($_POST["panggilAntrianC"])){
    $query = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' AND loket = 'C' ORDER BY nomor DESC");
    if (mysqli_num_rows($query) > 0){
        $query = mysqli_fetch_assoc($query);
        $nomorSekarang = $query["nomor"];
        mysqli_query($connect, "UPDATE antrian SET status = 'selesai' where nomor = $nomorSekarang");
    }
    

    $query = mysqli_query($connect, "SELECT * from antrian where status = 'mengantri'");
    $query = mysqli_fetch_assoc($query);
    $nomorSekarang = $query["nomor"];

    mysqli_query($connect, "UPDATE antrian SET status = 'dilayani', loket = 'C', dilayani = '$jam' where nomor = $nomorSekarang");
}

if (isset($_POST["selesaiA"])){
    $query = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' AND loket = 'A' ORDER BY nomor DESC");
    if (mysqli_num_rows($query) > 0){
        $query = mysqli_fetch_assoc($query);
        $nomorSekarang = $query["nomor"];
        mysqli_query($connect, "UPDATE antrian SET status = 'selesai' where nomor = $nomorSekarang");
    }
}

if (isset($_POST["selesaiB"])){
    $query = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' AND loket = 'B' ORDER BY nomor DESC");
    if (mysqli_num_rows($query) > 0){
        $query = mysqli_fetch_assoc($query);
        $nomorSekarang = $query["nomor"];
        mysqli_query($connect, "UPDATE antrian SET status = 'selesai' where nomor = $nomorSekarang");
    }
}

if (isset($_POST["selesaiC"])){
    $query = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' AND loket = 'C' ORDER BY nomor DESC");
    if (mysqli_num_rows($query) > 0){
        $query = mysqli_fetch_assoc($query);
        $nomorSekarang = $query["nomor"];
        mysqli_query($connect, "UPDATE antrian SET status = 'selesai' where nomor = $nomorSekarang");
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '_headtags.php' ?>
    <script src="js/jquery.js"></script> 
    <script>
        var refreshId = setInterval(function(){
            $('#tampilAntrian').load('tampilAntrian.php');
        }, 1000);
    </script>
    <title>Program Antrian</title>
</head>
<body>

    <!-- header -->
    <?php include '_navbar.php' ?>
    <!-- end header -->

    <!-- body -->
    <div class="row">

        <div class="col s5 offset-s1 card">
            <div class="card-content">
                <!-- tampilan antrian -->
                <div id="tampilAntrian"></div>
                <!-- end tampilan antrian -->
            </div>
            <br><br>
        </div>

        <div class="col s4 offset-s1 card">
            <h3 class="header center">Loket A</h3>
            <div class="card-content">
                <form action="" method="post">
                    <div class="center"><button class="btn-large blue darken-2" type="submit" name="panggilAntrianA">Panggil</button> <button class="btn-large red darken-2" type="submit" name="selesaiA">Selesai</button></div>
                </form>
            </div>

            <h3 class="header center">Loket B</h3>
            <div class="card-content">
                <form action="" method="post">
                    <div class="center"><button class="btn-large blue darken-2" type="submit" name="panggilAntrianB">Panggil</button> <button class="btn-large red darken-2" type="submit" name="selesaiB">Selesai</button></div>
                </form>
            </div>

            <h3 class="header center">Loket C</h3>
            <div class="card-content">
                <form action="" method="post">
                    <div class="center"><button class="btn-large blue darken-2" type="submit" name="panggilAntrianC">Panggil</button> <button class="btn-large red darken-2" type="submit" name="selesaiC">Selesai</button></div>
                </form>
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

if ( !isset($_SESSION["admin"])){
    echo "
        <script>
            Swal.fire('Akses Ditolak','Anda Belum Login Sebagai Karyawan','warning').then(function(){
                document.location.href = 'index.php';
            });
        </script>
    ";
}

?>