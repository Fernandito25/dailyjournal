<div class="container">
  <!-- Button trigger modal -->
<button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
    <i class="bi bi-plus-lg"></i> Tambah Gambar
</button>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="w-25">Gambar</th>
                        <th class="w-25">Tanggal</th>
                        <th class="w-25">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM gallery ORDER BY tanggal DESC";
                    $hasil = $conn->query($sql);

                    $no = 1;
                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if ($row["gambar"] != '' && file_exists('img/' . $row["gambar"] . '')) { ?>
                                    <img src="img/<?= $row["gambar"] ?>" width="100">
                                <?php } ?>
                            </td>
                            <td><?= $row["tanggal"] ?></td>
                            <td>
    <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
    <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit<?= $row["id"] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="gambar_lama" value="<?= $row['gambar'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Ganti Gambar</label>
                        <input type="file" class="form-control" name="gambar">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus<?= $row["id"] ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus gambar ini?
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <input type="hidden" name="gambar" value="<?= $row['gambar'] ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <input type="submit" name="hapus" value="Hapus" class="btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gambar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" class="form-control" name="gambar" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include "upload_foto.php";
// Jika tombol simpan diklik
if (isset($_POST['simpan'])) {
    $tanggal = date("Y-m-d H:i:s"); // Ambil tanggal saat ini
    $gambar = '';
    $nama_gambar = $_FILES['gambar']['name'];

    // Jika ada file yang dikirim
    if ($nama_gambar != '') {
        // Panggil function upload_foto untuk cek spesifikasi file
        $cek_upload = upload_foto($_FILES["gambar"]);

        // Cek status true/false
        if ($cek_upload['status']) {
            // Jika true maka message berisi nama file gambar
            $gambar = $cek_upload['message'];
        } else {
            // Jika false maka tampilkan pesan error
            echo "<script>
                alert('" . $cek_upload['message'] . "');
                document.location='admin.php?page=gallery';
            </script>";
            die;
        }
    }

    // Cek apakah ada id yang dikirimkan dari form
    if (isset($_POST['id'])) {
        // Jika ada id, lakukan update data dengan id tersebut
        $id = $_POST['id'];

        if ($nama_gambar == '') {
            // Jika tidak ganti gambar
            $gambar = $_POST['gambar_lama'];
        } else {
            // Jika ganti gambar, hapus gambar lama
            unlink("img/" . $_POST['gambar_lama']);
        }

        $stmt = $conn->prepare("UPDATE gallery 
                                SET 
                                gambar = ?,
                                tanggal = ?
                                WHERE id = ?");

        $stmt->bind_param("ssi", $gambar, $tanggal, $id);
        $simpan = $stmt->execute();
    } else {
        // Jika tidak ada id, lakukan insert data baru
        $stmt = $conn->prepare("INSERT INTO gallery (gambar, tanggal)
                                VALUES (?, ?)");

        $stmt->bind_param("ss", $gambar, $tanggal);
        $simpan = $stmt->execute();
    }

    if ($simpan) {
        echo "<script>
            alert('Simpan data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Simpan data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}

// Jika tombol hapus diklik
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '') {
        // Hapus file gambar
        unlink("img/" . $gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");

    $stmt->bind_param("i", $id);
    $hapus = $stmt->execute();

    if ($hapus) {
        echo "<script>
            alert('Hapus data sukses');
            document.location='admin.php?page=gallery';
        </script>";
    } else {
        echo "<script>
            alert('Hapus data gagal');
            document.location='admin.php?page=gallery';
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>