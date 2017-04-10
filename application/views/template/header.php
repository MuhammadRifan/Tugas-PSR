<!DOCTYPE html>
<html>
  <head>
    <title>Home Page</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/bootstrap-theme.min.css" rel="stylesheet">
    <link href="<?= base_url() ?>assets/css/jumbotron-narrow.css" rel="stylesheet">

  </head>

  <body>
    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation"><a href="<?= base_url() ?>Obat/homePage">Home</a></li>
            <li role="presentation"><a href="<?= base_url() ?>Obat/cart">Cart</a></li>
            <li role="presentation">
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Staff <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?= base_url() ?>Obat/logout">Logout</a></li>
                </ul>
              </li>
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">Apotik</h3>
      </div>
