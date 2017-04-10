<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <a href="user_add" class="btn btn-info">Tambah Staff</a>
    </div>
    <div class="panel-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Password</th>
            <th class="text-center">Level</th>
            <th class="text-center">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($db as $key){ ?>
            <tr class="text-center">
              <td><?php echo $key -> id ?></td>
              <td><?php echo $key -> nama ?></td>
              <td><?php echo $key -> password ?></td>
              <?php if($key -> level == 1){ ?>
                <td>Admin</td>
              <?php }else{ ?>
                <td>Staff</td>
              <?php } ?>
              <td style="width: 140px;">
                <a href="<?= base_url() ?>Obat/user_edit/<?= $key -> id ?>" class="btn btn-primary">Edit</a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm-<?= $key -> id ?>">Hapus</button>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php foreach($db as $key){ ?>
        <div class="modal fade bs-example-modal-sm-<?= $key -> id ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">Are You Sure ?</h4>
              </div>
              <div class="modal-body">
                <p class="text-center">To delete <?= $key -> nama ?></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <a href="<?= base_url() ?>Obat/user_hapus/<?= $key -> id ?>">
                  <button type="button" class="btn btn-danger">Hapus</button>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</div>
