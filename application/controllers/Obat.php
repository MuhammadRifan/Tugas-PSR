<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class Obat extends CI_Controller{
    function __construct(){
      parent::__construct();
      $this -> load -> database();
      $this -> load -> library('form_validation');
      $this -> load -> model('model_obat', 'obat');
    }

    function index()
    {
      $this -> login();
    }

    function login()
    {
      $submit = $this -> input -> post('submit');

      if($submit == "Login"){
        $this -> form_validation -> set_rules('nama', 'Nama User', 'required');
        $this -> form_validation -> set_rules('pass', 'Password', 'required');

        if($this -> form_validation -> run() == TRUE){

          $nama = $this -> input -> post('nama');
          $pass = md5($this -> input -> post('pass'));
          $sql = $this -> obat -> login();

          foreach($sql as $key){
            if(($nama == $key -> nama) && ($pass == $key -> password)){
              if($key -> level == 1){
                $data = array(
          				'is_logged_in' => 1
                );
                $this -> session -> set_userdata($data);
                redirect('Obat/admin_home');
              }else if($key -> level == 0){
                $data = array(
          				'is_logged_in' => 2
                );
                $this -> session -> set_userdata($data);
                redirect('Obat/home_page');
              }
            }
          }
          echo "<p class='text-center' style='color: red;'>Nama atau Password Salah</p>";
        }
      }
      $this -> load -> view('login');
    }

    function register()
    {
      $submit = $this -> input -> post('submit');

      if($submit == "Register"){
        $this -> form_validation -> set_rules('nama', 'Nama User', 'required|is_unique[tbl_user.nama]');
        $this -> form_validation -> set_rules('pass', 'Password', 'required');
    		$this -> form_validation -> set_rules('passcon', 'Confirm Password', 'required|matches[pass]');

    		$this -> form_validation -> set_message('is_unique', "Maaf, nama sudah digunakan");

        if($this -> form_validation -> run() == TRUE){
          $this -> obat -> register();
          redirect('Obat/login');
        }
      }
      $this -> load -> view('register');
    }

    function admin_home()
    {
      if($this -> session -> userdata('is_logged_in') == 1){
        $data['db'] = $this -> obat -> select_obat();
        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/admin', $data);
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function admin_add()
    {
      $submit = $this -> input -> post('submit');

      if($submit == "Submit"){
        $this -> form_validation -> set_rules('nama', 'Nama Obat', 'required');
        $this -> form_validation -> set_rules('fungsi', 'Fungsi Obat', 'required');
        $this -> form_validation -> set_rules('tgl_beli', 'Tanggal Pembelian', 'required');
        $this -> form_validation -> set_rules('nomor', 'Nomor Faktur', 'required');
        $this -> form_validation -> set_rules('jumlah', 'Jumlah Obat', 'required|numeric');
        $this -> form_validation -> set_rules('hbeli', 'Harga Beli Obat', 'required|numeric');
        $this -> form_validation -> set_rules('hjual', 'Harga Jual Obat', 'required|numeric');

        $nama = $this -> input -> post('nama');

        if($this -> form_validation -> run() == TRUE){
          $num_rows = $this -> obat -> cek($nama);
          if($num_rows == 1){
            $this -> obat -> update_stok($nama);
          }else{
            $this -> obat -> insert_obat();
          }
          $this -> obat -> pembelian($nama);

          redirect('Obat/admin_home');
        }
      }

      if($this -> session -> userdata('is_logged_in') == 1){
        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/add/beli');
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function admin_edit($id)
    {
      $submit = $this -> input -> post('submit');

      if($submit == "Submit"){
        $this -> form_validation -> set_rules('nama', 'Nama Obat', 'required');
        $this -> form_validation -> set_rules('fungsi', 'Fungsi Obat', 'required');
        $this -> form_validation -> set_rules('stok', 'Stok', 'required|numeric');
        $this -> form_validation -> set_rules('harga', 'Harga Obat', 'required|numeric');

        $nama = $this -> input -> post('nama');

        if($this -> form_validation -> run() == TRUE){
          $this -> obat -> update_obat($id);
          redirect('Obat/admin_home');
        }
      }

      if($this -> session -> userdata('is_logged_in') == 1){
        $data['db'] = $this -> obat -> get_edit($id);
        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/edit/edit', $data);
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function admin_hapus($id)
    {
      $this -> obat -> delete_obat($id);
      redirect('Obat/admin_home');
    }

    function user_home()
    {
      if($this -> session -> userdata('is_logged_in') == 1){
        $data['db'] = $this -> obat -> select_user();
        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/user', $data);
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function user_add()
    {
      $submit = $this -> input -> post('submit');

      if($submit == "Submit"){
        $this -> form_validation -> set_rules('nama', 'Nama User', 'required|is_unique[tbl_user.nama]');
        $this -> form_validation -> set_rules('pass', 'Password', 'required');
    		$this -> form_validation -> set_rules('passcon', 'Confirm Password', 'required|matches[pass]');
        $this -> form_validation -> set_rules('level', 'Level', 'required');

    		$this -> form_validation -> set_message('is_unique', "Maaf, nama sudah digunakan");

        if($this -> form_validation -> run() == TRUE){
          $this -> obat -> insert_user();
          redirect('Obat/user_home');
        }
      }

      if($this -> session -> userdata('is_logged_in') == 1){
        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/add/user_add');
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function user_hapus($id)
    {
      $this -> obat -> delete_user($id);
      redirect('Obat/user_home');
    }

    function user_edit($id)
    {
      $submit = $this -> input -> post('submit');

      if($submit == "Submit"){
        $this -> form_validation -> set_rules('nama', 'Nama', 'required');
        if(!empty($this -> input -> post('passold')) || !empty($this -> input -> post('passnew')) || !empty($this -> input -> post('passcon'))){
          $this -> form_validation -> set_rules('pass', 'Database', 'trim');
          $this -> form_validation -> set_rules('passold', 'Password Lama', 'trim|md5|required|matches[pass]');
          $this -> form_validation -> set_rules('passnew', 'Password Baru', 'trim|required');
          $this -> form_validation -> set_rules('passcon', 'Confirm Password', 'trim|required|matches[passnew]');
        }

        if($this -> form_validation -> run() == TRUE){
          $this -> obat -> update_user($id);
          redirect('Obat/user_home');
        }
      }

      if($this -> session -> userdata('is_logged_in') == 1){
        $data['db'] = $this -> obat -> get_user($id);
        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/edit/user_edit', $data);
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function lap_pembelian()
    {
      if($this -> session -> userdata('is_logged_in') == 1){
        $data['db'] = $this -> obat -> select_lap_beli();

        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/laporan/lap_pembelian', $data);
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function lap_penjualan()
    {
      if($this -> session -> userdata('is_logged_in') == 1){
        $data['db'] = $this -> obat -> select_lap_jual();

        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/laporan/lap_penjualan', $data);
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function pembelian()
    {
      if($this -> session -> userdata('is_logged_in') == 1){
        $data['db'] = $this -> obat -> select_beli();

        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/transaksi/pembelian', $data);
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function penjualan()
    {
      if($this -> session -> userdata('is_logged_in') == 1){
        $data['db'] = $this -> obat -> select_jual();

        $this -> load -> view('admin/template/header');
        $this -> load -> view('admin/transaksi/penjualan', $data);
        $this -> load -> view('admin/template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function home_page()
    {
      if($this -> session -> userdata('is_logged_in') == 2){
        $data['db'] = $this -> obat -> select_obat();
        $this -> load -> view('template/header');
        $this -> load -> view('Home_Page', $data);
        $this -> load -> view('template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function cart()
    {
      if($this -> session -> userdata('is_logged_in') == 2){
        $id = $this -> input -> post('id');

        if(empty($this -> session -> userdata('id'.$id))){
          $data = array(
            'id'.$id => $id,
            'nama'.$id => $this -> input -> post('nama'),
            'jumlah'.$id => $this -> input -> post('jumlah'),
            'harga'.$id => $this -> input -> post('harga'),
            'htotal'.$id => $this -> input -> post('harga') * $this -> input -> post('jumlah')
          );
        }else if(!empty($this -> session -> userdata('id'.$id))){
          $data = array(
            'jumlah'.$id => $this -> input -> post('jumlah') + $this -> session -> userdata('jumlah'.$id),
            'htotal'.$id => $this -> input -> post('harga') + $this -> session -> userdata('htotal'.$id)
          );
        }

        $this -> session -> set_userdata($data);

        $data = array(
          'db' => $this -> obat -> select_obat(),
          'num' => $this -> obat -> get_num_rows()
        );

        $this -> load -> view('template/header');
        $this -> load -> view('cart', $data);
        $this -> load -> view('template/footer');
      }else{
        redirect('Obat/login');
      }
    }

    function ubah_cart($id)
    {
      if($this -> session -> userdata('is_logged_in') == 2){
        $data = array(
          'jumlah'.$id => $this -> input -> post('jumlah'),
          'htotal'.$id => $this -> session -> userdata('harga'.$id) * $this -> input -> post('jumlah')
        );
        $this -> session -> set_userdata($data);
        redirect('Obat/cart');
      }else{
        redirect('Obat/login');
      }
    }

    function actdel($id)
    {
      if($this -> session -> userdata('is_logged_in') == 2){
        $this -> session -> unset_userdata('id'.$id);
        $this -> session -> unset_userdata('nama'.$id);
        $this -> session -> unset_userdata('harga'.$id);
        $this -> session -> unset_userdata('jumlah'.$id);
        $this -> session -> unset_userdata('htotal'.$id);
        redirect('Obat/cart');
      }else{
        redirect('Obat/login');
      }
    }

    function pembayaran()
    {
      if($this -> session -> userdata('is_logged_in') == 2){
        $num_rows = $this -> obat -> get_num_rows();
        for($i = 1; $i <= $num_rows; $i ++){
          $id = $this -> session -> userdata('id'.$i);
          if($id == $i){
            $data = array(
              'nama' => $this -> session -> userdata('nama'.$i),
              'id' => $this -> session -> userdata('id'.$i)
            );
            $this -> obat -> stok_jual($data);
            $this -> obat -> penjualan($id);
          }
          $this -> session -> unset_userdata('id'.$id);
          $this -> session -> unset_userdata('nama'.$id);
          $this -> session -> unset_userdata('harga'.$id);
          $this -> session -> unset_userdata('jumlah'.$id);
          $this -> session -> unset_userdata('htotal'.$id);
        }
        $this -> load -> view('pembayaran');
      }else{
        redirect('Obat/login');
      }
    }

    function logout()
    {
      $this -> session -> sess_destroy();
      redirect('Obat/login');
    }

  }
?>
