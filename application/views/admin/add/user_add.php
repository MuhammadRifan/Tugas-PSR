<div class="container">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <a href="<?= base_url() ?>Obat/user_home" class="btn btn-info">Back</a>
      Tambah User
    </div>
    <div class="panel-body">
      <?= validation_errors("<p style='color: red;'>", "</p>"); ?>
      <form action="<?= base_url() ?>Obat/user_add" method='post'>
        <div class="form-group">
          <label>Nama User</label>
          <input type="name" class="form-control" name="nama">
        </div>
        <div class="form-group">
          <label>Password User</label>
          <input type="password" class="form-control" name="pass">
        </div>
        <div class="form-group">
          <label>Password Confirm</label>
          <input type="password" class="form-control" name="passcon">
        </div>
        <div class="form-group">
          <label>Level User</label>
          <select class="form-control" name="level">
              <option value="">Please Select...</option>
              <option value="1">Admin</option>
              <option value="0">Staff</option>
          </select>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
      </form>
    </div>
  </div>
</div>
