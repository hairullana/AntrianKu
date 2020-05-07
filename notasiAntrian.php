<?php

include 'connectDB.php';

// jumlah channel
$c = 3;

// fungsi faktorial
function faktorial($angka){
    for ($i=$angka-1; $i>0; $i--){
        $angka *= $i;
    }

    return $angka;
}

function x($angka,$lamda,$miu){
    global $c;
    $a = 0;
    for ($i=$c-1; $i<=0; $i++){
        $a += (1/faktorial($i)) * (pow(($lamda/$miu),$i));
    }
    return $a;
}



if (mysqli_num_rows(mysqli_query($connect, "SELECT * FROM antrian where status = 'dilayani' OR status = 'selesai'")) < 2){
    echo "
        <h3 class='header light center'>Data Kosong / Belum Ada Antrian</h3>
    ";
}else {

    // LAMDA
    $jamAwal = mysqli_query($connect, "SELECT * from antrian ORDER BY nomor ASC");
    $jamAwal = mysqli_fetch_assoc($jamAwal);
    $jamAwal = strtotime($jamAwal["datang"]);

    $jamAkhir = mysqli_query($connect, "SELECT * from antrian ORDER BY nomor DESC");
    $jamAkhir = mysqli_fetch_assoc($jamAkhir);
    $jamAkhir = strtotime($jamAkhir["datang"]);


    $detik = $jamAkhir-$jamAwal;
    $menit = $detik/60;

    $jumlahAntrian = mysqli_num_rows(mysqli_query($connect, "SELECT * from antrian"));

    // nilai lamda
    $lamda = $jumlahAntrian / $menit;

    // MIU
    $jamAwal = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' OR status = 'selesai' ORDER BY nomor ASC");
    $jamAwal = mysqli_fetch_assoc($jamAwal);
    $jamAwal = strtotime($jamAwal["dilayani"]);

    $jamAkhir = mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' OR status = 'selesai' ORDER BY nomor DESC");
    $jamAkhir = mysqli_fetch_assoc($jamAkhir);
    $jamAkhir = strtotime($jamAkhir["dilayani"]);

    $detik = $jamAkhir-$jamAwal;
    $menit = $detik/60;

    $jumlahPelayanan = mysqli_num_rows(mysqli_query($connect, "SELECT * from antrian where status = 'dilayani' OR status = 'selesai'"));

    // nilai miu
    $miu = $jumlahPelayanan / $menit;

    $P0 = 1 / ( ( x($c,$lamda,$miu) ) + ( ( (1/faktorial($c)) * pow(($lamda/$miu),$c) * (($c * $miu) / (($c * $miu) - $lamda)) )));
    $L = ((($lamda*$miu) * pow(($lamda/$miu),$c)) / (faktorial($c-1) * pow(($c*$miu - $lamda),2))) * $P0 + ($lamda / $miu);
    $Lq = $L - ($lamda/$miu);
    $W = $L/$lamda;
    $Wq = $Lq/$lamda;

?>
    <table>
        <tr>
            <td>Rata<sup>2</sup> waktu kedatangan</td>
            <td><?= number_format($lamda,2); ?> org/mnt</td>
        </tr>
        <tr>
            <td>Rata<sup>2</sup> waktu pelayanan</td>
            <td><?= number_format($miu,2); ?> org/mnt</td>
        </tr>
        <tr>
            <td>Rata<sup>2</sup> antrian dalam sistem</td>
            <td><?= number_format($L,2); ?> org/mnt</td>
        </tr>
        <tr>
            <td>Rata<sup>2</sup> antrian dalam antrian</td>
            <td><?= number_format($Lq,2); ?> org/mnt</td>
        </tr>
        <tr>
            <td>Rata<sup>2</sup> waktu menunggu dalam sistem</td>
            <td><?= number_format($W,2); ?> menit</td>
        </tr>
        <tr>
            <td>Rata<sup>2</sup> waktu menunggu dalam antrian</td>
            <td><?= number_format($Wq,2); ?> menit</td>
        </tr>
    </table>
    
<?php } ?>