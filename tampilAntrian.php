<?php

include 'connectDB.php';
// ambil data antrian
$antrian = mysqli_query($connect, "SELECT * from antrian where status = 'mengantri'");

// ambil data yang dilayani
$A = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' AND loket = 'A' ORDER BY nomor DESC");
if (mysqli_num_rows($A) < 1){
    $A = 0;
}else{
    $A = mysqli_fetch_assoc($A);
    $A = $A["nomor"];
}

$B = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' AND loket = 'B' ORDER BY nomor DESC");
if (mysqli_num_rows($B) < 1){
    $B = 0;
}else{
    $B = mysqli_fetch_assoc($B);
    $B = $B["nomor"];
}

$C = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' AND loket = 'C' ORDER BY nomor DESC");
if (mysqli_num_rows($C) < 1){
    $C = 0;
}else {
    $C = mysqli_fetch_assoc($C);
    $C = $C["nomor"];
}
?>

<div class="center">
    <div class="col s4">
        <h5 class="header">Loket A</h5>
        <h5 class="header light"><?= $A ?></h5>
    </div>
    <div class="col s4">
        <h5 class="header">Loket B</h5>
        <h5 class="header light"><?= $B ?></h5>
    </div>
    <div class="col s4">
        <h5 class="header">Loket C</h5>
        <h5 class="header light"><?= $C ?></h5>
    </div>
</div>


<h5 class="header center">Daftar Antrian</h3>
<div class="center">
    <?php foreach ($antrian as $data) : ?>
    <div class="col s4"><h5 class="light center"><?= $data["nomor"]; ?></h5></div>
    <?php endforeach;?>
</div>