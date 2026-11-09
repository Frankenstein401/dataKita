<?php

require_once __DIR__ . '/config/koneksi.php';

// Logic CREATE USER
if (isset($_POST['kirim'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelamin = $_POST['kelamin'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $query = "INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelamin`, `kelas`, `jurusan`, `alamat`, `no_hp`, `created_at`) VALUES (NULL,'$nis','$nama','$kelamin','$kelas','$jurusan','$alamat','$no_hp', NOW())";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Data berhasil dikirim')</script>";
    } else {
        echo "<script>alert('Data gagal dikirim')</script>";
    }
}

// Logic DELETE USER
if (isset($_GET['delete']) == true) {
    $id = $_GET['delete'];
    $query = "DELETE FROM `siswa` WHERE id = '$id'";
    $delete = mysqli_query($conn, $query);
}

// Logic UPDATE USER 
if (isset($_POST['update']) == true) {
    $id = $_POST['update'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelamin = $_POST['kelamin'];
    $kelas = $_POST['kelas'];
    $jurusan = $_POST['jurusan'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    $query = "UPDATE `siswa` SET `nis`='$nis',`nama`='$nama',`kelamin`='$kelamin',`kelas`='$kelas',`jurusan`='$jurusan',`alamat`='$alamat',`no_hp`='$no_hp' WHERE id = '$id'";
    $update = mysqli_query($conn, $query);
}

// READ (AMBIL DATA UNTUK FORM EDIT)
$nis = '';
$nama = '';
$kelamin = '';
$kelas = '';
$jurusan = '';
$alamat = '';
$no_hp = '';
if (isset($_GET['update']) == true) {
    $id = $_GET['update'];
    $query = "SELECT * FROM `siswa` WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);


    $nis = $data['nis'];
    $nama = $data['nama'];
    $kelamin = $data['kelamin'];
    $kelas = $data['kelas'];
    $jurusan = $data['jurusan'];
    $alamat = $data['alamat'];
    $no_hp = $data['no_hp'];
}

// Logic search
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';
$result = [];

if (!empty($keyword)) {
    $escapedKeyword = mysqli_real_escape_string($conn, $keyword);

    $query = "SELECT * FROM siswa WHERE nama LIKE '%$escapedKeyword%' OR nis LIKE '%$escapedKeyword%'";
    $resultSearch = mysqli_query($conn, $query);

    if($resultSearch) {
        while($row = mysqli_fetch_assoc($resultSearch)) {
            $result[] = $row; 
        }
    }
} else {
    $query = "SELECT * FROM siswa";
}

// Logic READ USER
$result = mysqli_query($conn, $query);
$no = 1;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datakita</title>
    <link rel="stylesheet" href="/src/output.css">
</head>

<body class="bg-slate-50 text-slate-800 antialiased p-6">
    <div class="max-w-6xl mx-auto space-y-8">
        <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
            <h2 class="text-lg font-semibold mb-4 text-slate-900">Tambah Data Siswa</h2>
            <form action="" method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">NIS</label>
                    <input type="text" name="nis" placeholder="Masukkan NIS" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?= $nis ?>">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Masukkan nama lengkap" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required value="<?= $nama ?>">
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Jenis Kelamin</label>
                    <select name="kelamin" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" required>
                        <option value="" disabled selected>Pilih jenis kelamin</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Kelas</label>
                    <select name="kelas" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" required>
                        <option value="" disabled selected>Pilih kelas</option>
                        <option value="10">X (Sepuluh)</option>
                        <option value="11">XI (Sebelas)</option>
                        <option value="12">XII (Dua Belas)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Jurusan</label>
                    <select name="jurusan" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white" required>
                        <option value="" disabled selected>Pilih jurusan</option>
                        <option value="AK">Akuntansi</option>
                        <option value="MP">Management Perkantoran</option>
                        <option value="BR">Bisnis Ritel</option>
                        <option value="RPL">Rekayasa Perangkat Lunak</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">Nomor Telepon</label>
                    <input type="text" name="no_hp" placeholder="Contoh: 08123456789" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" value="<?= $no_hp ?>">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-slate-600 mb-1">Alamat</label>
                    <textarea name="alamat" rows="2" placeholder="Masukkan alamat lengkap" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"><?= $alamat ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" name="kirim" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg text-sm transition">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Data Siswa -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-200 flex justify-between">
                <h2 class="text-lg font-semibold text-slate-900">Daftar Siswa</h2>
                <form action="" method="get">
                    <input type="text" name="search" value="<?= htmlspecialchars($keyword) ?>" placeholder="Cari siswa berdasarkan Nama/NIS..." class="w-[300px] px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2.5 rounded-lg text-sm transition">Cari</button>
                    <?php if (!empty($keyword)) { ?>
                        <a href="?" class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-4 py-2.5 rounded-lg text-sm transition">
                            Reset
                        </a>
                    <?php } ?>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead class="bg-slate-100 text-slate-600 text-xs uppercase font-medium">
                        <tr>
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">NIS</th>
                            <th class="py-3 px-4">Nama</th>
                            <th class="py-3 px-4">Kelamin</th>
                            <th class="py-3 px-4">Kelas</th>
                            <th class="py-3 px-4">Jurusan</th>
                            <th class="py-3 px-4">Alamat</th>
                            <th class="py-3 px-4">No HP</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 px-4"><?= $no++; ?></td>
                                <td class="py-3 px-4 font-mono text-xs"><?= htmlspecialchars($row['nis']); ?></td>
                                <td class="py-3 px-4 font-medium"><?= htmlspecialchars($row['nama']); ?></td>
                                <td class="py-3 px-4 capitalize"><?= htmlspecialchars($row['kelamin']); ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars($row['kelas']); ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars($row['jurusan']); ?></td>
                                <td class="py-3 px-4 max-w-xs truncate"><?= htmlspecialchars($row['alamat']); ?></td>
                                <td class="py-3 px-4"><?= htmlspecialchars($row['no_hp']); ?></td>
                                <td class="py-3 px-4 text-center space-x-2 flex">
                                    <a href="?update=<?= $row['id'] ?>" class="text-amber-600 hover:underline font-medium ">Edit</a>
                                    <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Hapus data ini?')" class="text-rose-600 hover:underline font-medium">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>

</html>