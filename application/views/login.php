<!DOCTYPE html>
<html>
  <head>
    <title>Login Page</title>
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/signin.css" rel="stylesheet">
  </head>

  <body>

    <div class="container">
      <?php echo validation_errors('<p class="text-center" style="color: red;">', "</p>") ?>
      <form class="form-signin" action="<?= base_url() ?>Obat/login" method="post">
        <h2 class="form-signin-heading">Login</h2>
        <label>Name</label>
        <input type="name" name="nama" class="form-control" placeholder="Name" autofocus>
        <br>
        <label>Password</label>
        <input type="password" name="pass" class="form-control" placeholder="Password">
        <br>
        <input type="submit" name="submit" value="Login" class="btn btn-primary btn-lg">
        <a href="<?= base_url() ?>Obat/register" class="text-right">Register</a>
      </form>
    </div> <!-- /container -->
  </body>
</html>
