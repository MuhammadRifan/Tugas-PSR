<div class="row marketing">
    <?php foreach ($db as $key) {
        $x = "bs-example-modal-sm-$key->id";
        $z = 'autocomplete="off" required';
    ?>
        <div class="col-md-6">
            <h4>
                <?php if ($key->stok <= 0) { ?>
                    <span style="color: blue;"><s><?= $key->nama ?></s></span>
                    <span style="color: red;">Out of Stok</span>
                <?php } else { ?>
                    <span style="color: blue;"><?= $key->nama ?></span>
                <?php } ?>
            </h4>
            <p><?= $key->fungsi ?></p>
            <div class="col-md-10 text-right">
                Rp <?= number_format($key->harga) ?>
            </div>
            <div class="col-md-2">
                <?php if ($key->stok <= 0) { ?>
                    <button type="button" class="btn btn-default disabled"><s>Beli</s></button>
                <?php } else { ?>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".<?= $x ?>">
                      Beli
                    </button>
                <?php } ?>
            </div>
        </div>
        <div class="modal fade <?= $x ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title text-center">Add to Cart</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" action="<?= base_url() ?>Obat/cart" method="post">
                            <input type="hidden" name="id" value="<?= $key->id ?>">
                            <input type="hidden" name="nama" value="<?= $key->nama ?>">
                            <input type="hidden" name="harga" value="<?= $key->harga ?>">
                        <p class="text-center">
                            <?= $key->nama ?>&nbsp X &nbsp
                            <input type="number" name="jumlah" min="1" max="<?= $key->stok ?>" <?= $z ?>>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Beli" class="btn btn-primary">
                    </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
