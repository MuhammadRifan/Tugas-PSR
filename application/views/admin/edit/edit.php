<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <a href="<?= base_url() ?>Obat/adminHome" class="btn btn-info">Back</a>
      Edit Obat
    </div>
    <div class="panel-body">
      <?php echo validation_errors("<p style='color: red;'>", "</p>");
        foreach ($db as $key) {
      ?>
      <form action="<?= base_url() ?>Obat/adminEdit/<?= $key->id ?>" method='post'>
        <div class="form-group">
          <label>Nama Obat</label>
          <input type="name" class="form-control" name="nama" value="<?= $key->nama ?>">
        </div>
        <div class="form-group">
          <label>Fungsi Obat</label>
          <textarea name="fungsi" class="form-control"><?= $key->fungsi ?></textarea>
        </div>
        <div class="form-group">
          <label>Stok</label>
          <input type="text" class="form-control" name="stok" value="<?= $key->stok ?>">
        </div>
        <div class="form-group">
          <label>Harga Obat</label>
          <input type="text" class="form-control" name="harga" value="<?= $key->harga ?>">
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
      </form>
      <?php } ?>
    </div>
  </div>
</div>
