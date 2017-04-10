<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <a href="admin_home" class="btn btn-info">Back</a>
      Tambah Stok Obat
    </div>
    <div class="panel-body">
      <?= validation_errors("<p style='color: red;'>", "</p>")  ?>
      <form action="<?= base_url() ?>Obat/admin_add" method='post'>
        <div class="form-group">
          <label>Nama Obat</label>
          <input type="name" class="form-control" name="nama" placeholder="Nama Obat">
        </div>
        <div class="form-group">
          <label>Fungsi Obat</label>
          <textarea name="fungsi" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <label>Tanggal Pembelian</label>
          <input type="date" class="form-control" name="tgl_beli">
        </div>
        <div class="form-group">
          <label>Nomor Faktur</label>
          <input type="text" class="form-control" name="nomor" placeholder="Nomor Faktur">
        </div>
        <div class="form-group">
          <label>Jumlah Obat</label>
          <input type="text" class="form-control" name="jumlah" placeholder="Jumlah Obat">
        </div>
        <div class="form-group">
          <label>Harga Beli Obat</label>
          <input type="text" class="form-control" name="hbeli" placeholder="Harga Beli Obat">
        </div>
        <div class="form-group">
          <label>Harga Jual Obat</label>
          <input type="text" class="form-control" name="hjual" placeholder="Harga Jual Obat">
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
      </form>
    </div>
  </div>
</div>
