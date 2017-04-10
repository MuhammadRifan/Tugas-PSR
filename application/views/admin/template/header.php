<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Admin Page</title>
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Apotik</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <!-- <li class="active"><a href="#">Home <span class="sr-only">(current)</span></a></li> -->
                        <li><a href="<?= base_url() ?>Obat/adminHome">Home</a></li>
                        <li><a href="<?= base_url() ?>Obat/userHome">User</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Transaksi <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url() ?>Obat/pembelian">Pembelian</a></li>
                                <li><a href="<?= base_url() ?>Obat/penjualan">Penjualan</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Laporan <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url() ?>Obat/lapPembelian">Pembelian</a></li>
                                <li><a href="<?= base_url() ?>Obat/lapPenjualan">Penjualan</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url() ?>Obat/logout">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
