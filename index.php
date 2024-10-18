<?php
include_once("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="./bootstrap-5.3.3-dist/css/bootstrap.min.css"
    />
    <title>To Do List</title>
  </head>
  <body>
    <!-- start header -->
    <h3>
      To Do List
      <small class="text-muted">
        Catat semua hal yang akan kamu kerjakan disini
      </small>
    </h3>
    <hr>
    <!-- end header -->
    <!-- start form -->
     <form class="form row" method="post" action="" name="myForm" onsubmit="return(validate());">
        <?php
        $isi = '';
        $tgl_awal = '';
        $tgl_akhir = '';
        if (isset($_GET['id'])) {
            $ambil = mysqli_query($mysqli,"SELECT * FROM kegiatan WHERE id='".$_GET['id']."'");
            while ($row = mysqli_fetch_array($ambil)) {
                $isi = $row["isi"];
                $tgl_awal = $row["tgl_awal"];
                $tgl_akhir = $row["tgl_akhir"];
            }
        
        ?>

        <input type="hidden" name="id" value="<?php echo $_GET['id']?>">
        <?php
        }
        ?>
        <div class="col">
            <label for="inputIsi" class="form-label fw-bold">
                kegiatan
            </label>
            <input type="text" class="form-control" name="isi" id="inputIsi" placeholder="Kegiatan" value="<?php echo $isi?>">
        </div>
        <div class="col">
            <label for="inputTanggalAwal" class="form-label fw-bold">
                Tanggal Awal
            </label>
            <input type="date" class="form-control" name="tgl_awal" id="inputTanggalAwal" placeholder="Tanggal Awal" value="<?php echo $tgl_awal?>">
        </div>
        <div class="col mb-2">
            <label for="inputTanggalAkhir" class="form-label fw-bold">
                Tanggal Akhir
            </label>
            <input type="date" class="form-control" name="tgl_akhir" id="inputTanggalAkhir" placeholder="Tanggal Akhir" value="<?php echo $tgl_akhir?>">
        </div>
        <div class="col">
        <button type="submit" class="btn btn-primary rounded-pill px-3" name="simpan">Simpan</button>
    </div>
     </form>
     <!-- end form -->

     <!-- start tabel -->
      <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Kegiatan</th>
                <th scope="col">Awal</th>
                <th scope="col">Akhir</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $result = mysqli_query($mysqli,'SELECT * FROM kegiatan ORDER BY status,tgl_awal');
            $no = 1;
            while($data = mysqli_fetch_array($result)) {   
                ?>
                <tr>
                    <th scope="row"><?php echo $no++ ?></th>
                    <td><?php echo $data['isi'] ?></td>
                    <td><?php echo $data['tgl_awal'] ?></td>
                    <td><?php echo $data['tgl_akhir'] ?></td>
                    <td>
                        <?php 
                       if ($data['status'] == '1') {
                        ?>
                            <a class="btn btn-success rounded-pill px-3" type="button"
                            href="index.php?id=<?php echo $data['id'] ?>&aksi=ubah_status&status=0">
                            Sudah
                            </a>
                        <?php
                        } else {
                        ?>
                            <a class="btn btn-warning rounded-pill px-3" type="button"
                            href="index.php?id=<?php echo $data['id'] ?>&aksi=ubah_status&status=1">
                            Belum</a>
                        <?php
                        }
                        ?>
                    </td>
                    <td>
                      <a class="btn btn-info rounded-pill px-3" href="index.php?id=<?php echo $data['id'] ?>">Ubah</a>
                      <a class="btn btn-danger rounded-pill px-3" href="index.php?id=<?php echo $data['id'] ?>&aksi=hapus">Hapus </a>
                    </td>
                </tr>
                <?php
              }
              ?>
              <?php 
              if (isset($_POST['simpan'])) {
                if (isset($_POST['id'])) {
                  $ubah = mysqli_query($mysqli,"UPDATE kegiatan SET  isi = '" . $_POST['isi'] . "',
                                        tgl_awal = '" . $_POST['tgl_awal'] . "',
                                        tgl_akhir = '" . $_POST['tgl_akhir'] . "'
                                        WHERE
                                        id = '" . $_POST['id'] . "'");
                }else{
                  $tambah = mysqli_query($mysqli, "INSERT INTO kegiatan(isi,tgl_awal,tgl_akhir,status)
                  VALUES (
                      '" . $_POST['isi'] . "',
                      '" . $_POST['tgl_awal'] . "',
                      '" . $_POST['tgl_akhir'] . "',
                      '0'
                      )");
                }
                echo "<script> document.location='index.php';</script>";
              }

              if (isset($_GET['aksi'])) {
                if ($_GET['aksi'] == 'hapus') {
                    $hapus = mysqli_query($mysqli, "DELETE FROM kegiatan WHERE id = '" . $_GET['id'] . "'");
                }else if ($_GET['aksi'] == 'ubah_status') {
                $ubahStatus = mysqli_query($mysqli,"UPDATE kegiatan SET
                                        status = '" . $_GET['status'] . "'
                                        WHERE
                                        id = '" . $_GET['id'] . "'");
              }

              echo "<script>
              document.location='index.php';
              </script>";
            }
              ?>
        </tbody>
      </table>
      <tbody>

      </tbody>
     <!-- end tabel -->
     <script src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
  </body>
</html>
