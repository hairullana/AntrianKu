<?php

session_start();
include 'connectDB.php';

if (isset($_POST["antriBaru"])){
    $jam = date("H:i:s");
    mysqli_query($connect, "INSERT into antrian values ('','mengantri','','$jam','00:00:00')");
    if (mysqli_affected_rows($connect) < 1){
        echo mysqli_error($connect);
    }
}

$query = "SELECT * FROM antrian WHERE status = 'mengantri'";
$antrian = mysqli_query($connect, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Antrian</title>
    <?php include '_headtags.php'; ?>
    <script src="js/jquery.js"></script> 
    <script>
        var refreshId = setInterval(function(){
            $('#tampilAntrian').load('tampilAntrian.php');
        }, 1000);
    </script>
    <script>
        var refreshId = setInterval(function(){
            $('#notasiAntrian').load('notasiAntrian.php');
        }, 1000);
    </script>
</head>
<body>

    <!-- header -->
    <?php include '_navbar.php'; ?>
    <!-- end header -->

    <!-- body -->
    <div class="row">

        <div class="col s5 offset-s1 card">
            <div class="card-content">
                <!-- antrian -->
                <div id="tampilAntrian"></div>
                <!-- end antrian -->
            </div>
        </div>

        <div class="col s4 offset-s1 card">
            <h3 class="header center">Pelanggan</h3>
            <div class="card-content">
                <form action="" method="post">
                    <div class="center"><button class="btn-large blue darken-2" type="submit" name="antriBaru">Ambil Antrian</button></div>
                </form>
                <h3 class="header center">Info</h3>
                <div id="notasiAntrian"></div>
            </div>
        </div>
    </div>
    <!-- body -->

    <!-- footer -->
    <?php include "_footer.php"; ?>
    <!-- end footer -->
</body>
</html>
