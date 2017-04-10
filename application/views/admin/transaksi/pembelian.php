<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title">Transaksi Pembelian</h3>
    </div>
    <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nomor Faktur</th>
            <th class="text-center">Tanggal Pembelian</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Harga</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($db as $key) { ?>
            <tr class="text-center">
              <td><?php echo $key->id_beli ?></td>
              <td><?php echo $key->nofaktur ?></td>
              <td><?php echo $key->tgl_beli ?></td>
              <td><?php echo $key->jumlah ?></td>
              <td style="width: 120px;"><?php echo "Rp ".number_format($key->harga_beli) ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
