<div class="panel panel-primary">
  <div class="panel-heading">
    <a href="<?= base_url() ?>Obat/home_page" class="btn btn-info">Back</a> Cart
  </div>
  <div class="panel-body">
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Total</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $total = 0;
            for($i = 1; $i <= $num; $i ++){
          if($this -> session -> userdata('jumlah'.$i) > 0){
        ?>
          <tr>
            <td><?= $this -> session -> userdata('nama'.$i) ?></td>
            <td>Rp <?= number_format($this -> session -> userdata('harga'.$i)) ?></td>
            <td><?= $this -> session -> userdata('jumlah'.$i) ?></td>
            <td style="width: 120px">Rp <?= number_format($this -> session -> userdata('htotal'.$i)) ?></td>
            <td style="width: 220px">
              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bs-example-modal-sm-<?= $this -> session -> userdata('id'.$i) ?>">Ubah</button>
              <a href="<?= base_url() ?>Obat/actdel/<?= $this -> session -> userdata('id'.$i) ?>" class="btn btn-danger btn-sm">Hapus</a>
            </td>
          </tr>
        <?php }
          $total = $total + $this -> session -> userdata('htotal'.$i);
        } ?>
      </tbody>
    </table>
    <?php foreach($db as $key){ ?>
      <div class="modal fade bs-example-modal-sm-<?= $key -> id ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title text-center">Ubah Jumlah</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" action="<?= base_url() ?>Obat/ubah_cart/<?= $key -> id ?>" method="post">
                <p class="text-center">
                  <?= $key -> nama ?>&nbsp X &nbsp<input type="number" name="jumlah" min="1" max="<?= $key -> stok ?>" autocomplete="off" required>
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" name="submit" value="Selesai" class="btn btn-primary">
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <div class="panel-footer">
    <p class="text-right">
      Total = Rp <?= number_format($total) ?> &nbsp
      <?php if($total == 0){ ?>
        <a href="<?= base_url() ?>Obat/pembayaran" class="btn btn-success disabled">Bayar</a>
      <?php }else{ ?>
        <a href="<?= base_url() ?>Obat/pembayaran" class="btn btn-success">Bayar</a>
      <?php } ?>
    </p>
  </div>
</div>
