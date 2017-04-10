<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <a href="<?= base_url() ?>Obat/userHome" class="btn btn-info">Back</a>
            Edit User
        </div>
        <div class="panel-body">
            <?php echo validation_errors("<p style='color: red;'>", "</p>");
            foreach ($db as $key) {
            ?>
            <form action="<?= base_url() ?>Obat/userEdit/<?= $key->id ?>" method='post'>
                <input type="hidden" name="pass" value="<?= $key->password ?>">
                <div class="form-group">
                    <label>Nama User</label>
                    <input type="name" class="form-control" name="nama" value="<?= $key->nama ?>">
                </div>
                <div class="form-group">
                    <label>Password Lama User</label>
                    <input type="password" class="form-control" name="passold">
                </div>
                <div class="form-group">
                    <label>Password Baru User</label>
                    <input type="password" class="form-control" name="passnew">
                </div>
                <div class="form-group">
                    <label>Password Baru Confirm</label>
                    <input type="password" class="form-control" name="passcon">
                </div>
                <div class="form-group">
                    <label>Level User</label>
                    <select class="form-control" name="level">
                        <?php if ($key->level == 1) { ?>
                            <option value="1" selected>Admin</option>
                            <option value="0">Staff</option>
                        <?php } elseif ($key->level == 0) { ?>
                            <option value="1">Admin</option>
                            <option value="0" selected>Staff</option>
                        <?php } ?>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" name="submit" value="Submit">
            </form>
            <?php
            }
            ?>
        </div>
    </div>
</div>
