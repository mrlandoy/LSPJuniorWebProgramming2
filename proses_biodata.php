<?php
session_start();

// Inisialisasi array biodata jika belum ada
if (!isset($_SESSION['biodata'])) {
    $_SESSION['biodata'] = array();
}

// Fungsi untuk menambahkan biodata
function tambah_biodata($nik, $nama, $tempat_lahir, $tanggal_lahir, $jenis_kelamin, $alamat, $agama) {
    $biodata = array(
        "nik" => $nik,
        "nama" => $nama,
        "tempat_lahir" => $tempat_lahir,
        "tanggal_lahir" => $tanggal_lahir,
        "jenis_kelamin" => $jenis_kelamin,
        "alamat" => $alamat,
        "agama" => $agama
    );
    $_SESSION['biodata'][] = $biodata;
}

// Fungsi untuk menghapus biodata berdasarkan NIK
function hapus_biodata($nik) {
    foreach ($_SESSION['biodata'] as $index => $biodata) {
        if ($biodata['nik'] == $nik) {
            unset($_SESSION['biodata'][$index]);
            $_SESSION['biodata'] = array_values($_SESSION['biodata']); // Reindex array
            return true;
        }
    }
    return false;
}

// Fungsi untuk menampilkan biodata
function tampil_biodata() {
    if (count($_SESSION['biodata']) > 0) {
        echo "<h2>Data Biodata:</h2>";
        foreach ($_SESSION['biodata'] as $biodata) {
            echo "NIK: " . $biodata['nik'] . "<br>";
            echo "Nama: " . $biodata['nama'] . "<br>";
            echo "Tempat Lahir: " . $biodata['tempat_lahir'] . "<br>";
            echo "Tanggal Lahir: " . $biodata['tanggal_lahir'] . "<br>";
            echo "Jenis Kelamin: " . $biodata['jenis_kelamin'] . "<br>";
            echo "Alamat: " . $biodata['alamat'] . "<br>";
            echo "Agama: " . $biodata['agama'] . "<br><br>";
        }
    } else {
        echo "<p>Tidak ada data biodata.</p>";
    }
}

// Memproses data yang dikirim melalui form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nik']) && isset($_POST['nama']) && isset($_POST['tempat_lahir']) &&
        isset($_POST['tanggal_lahir']) && isset($_POST['jenis_kelamin']) &&
        isset($_POST['alamat']) && isset($_POST['agama'])) {
        
        tambah_biodata($_POST['nik'], $_POST['nama'], $_POST['tempat_lahir'],
                       $_POST['tanggal_lahir'], $_POST['jenis_kelamin'], 
                       $_POST['alamat'], $_POST['agama']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Proses Biodata</title>
</head>
<body>

<?php tampil_biodata(); ?>

<h2>Hapus Biodata</h2>
<form action="" method="POST">
    <label for="nik_hapus">Masukkan NIK yang akan dihapus:</label>
    <input type="number" id="nik_hapus" name="nik_hapus" required>
    <button type="submit">Hapus</button>
</form>

<?php
// Memproses penghapusan data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nik_hapus'])) {
        $nik_hapus = $_POST['nik_hapus'];
        if (hapus_biodata($nik_hapus)) {
            echo "<p>Data biodata dengan NIK $nik_hapus telah dihapus.</p>";
        } else {
            echo "<p>Biodata dengan NIK $nik_hapus tidak ditemukan.</p>";
        }
    }
}
?>

<a href="index.html">Kembali ke Form Input</a>

</body>
</html>
