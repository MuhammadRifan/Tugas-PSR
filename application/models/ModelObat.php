<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  class ModelObat extends CI_Model{
    function index()
    {
      echo "Hai";
    }

    function selectObat()
    {
      $query = $this->db->get('tbl_obat');
      return $query->result();
    }

    function selectLapBeli()
    {
      $query = $this->db->get('view_beli');
      return $query->result();
    }

    function selectLapJual()
    {
      $query = $this->db->get('view_jual');
      return $query->result();
    }

    function selectBeli()
    {
      $query = $this->db->get('tbl_pembelian');
      return $query->result();
    }

    function selectJual()
    {
      $query = $this->db->get('tbl_penjualan');
      return $query->result();
    }

    function selectUser()
    {
      $query = $this->db->get('tbl_user');
      return $query->result();
    }

    function insertObat()
    {
      $data = array(
        'nama' => $this->input->post('nama'),
        'fungsi' => $this->input->post('fungsi'),
        'stok' => $this->input->post('jumlah'),
        'harga' => $this->input->post('hjual')
      );

      return $this->db->insert('tbl_obat', $data);
    }

    function insertUser()
    {
      $data = array(
        'nama' => $this->input->post('nama'),
        'password' => md5($this->input->post('pass')),
        'level' => $this->input->post('level')
      );

      return $this->db->insert('tbl_user', $data);
    }

    function stok($nama)
    {
      $this->db->where('nama', $nama);
      $query = $this->db->get('tbl_obat');
      return $query->result();
    }

    function updateStok($nama)
    {
      $stok = $this->stok($nama);
      foreach ($stok as $key) {
        $stok_lama = $key->stok;
      }

      $stok_baru = $this->input->post('jumlah');
      $stok_update = $stok_lama + $stok_baru;

      $data = array(
        'nama' => $this->input->post('nama'),
        'fungsi' => $this->input->post('fungsi'),
        'stok' => $stok_update,
        'harga' => $this->input->post('hjual')
      );
      $this->db->where('nama', $nama);
      return $this->db->update('tbl_obat', $data);
    }

    function stokJual($data)
    {
      $nama = $data['nama'];
      $id = $data['id'];

      $query = $this->stok($nama);
      foreach ($query as $key) {
        $stok_lama = $key->stok;
      }

      $stok_baru = $this->session->userdata('jumlah'.$id);
      $stok_update = $stok_lama - $stok_baru;

      $this->db->set('stok', $stok_update);
      $this->db->where('id', $id);
      $query = $this->db->update('tbl_obat');
      return $query;
    }

    function updateObat($id)
    {
      $data = array(
        'nama' => $this->input->post('nama'),
        'fungsi' => $this->input->post('fungsi'),
        'stok' => $this->input->post('stok'),
        'harga' => $this->input->post('harga')
      );

      $this->db->where('id', $id);
      return $this->db->update('tbl_obat', $data);
    }

    function updateUser($id)
    {
      if (!empty($this->input->post('passold')) && !empty($this->input->post('passnew'))) {
        $pass = md5($this->input->post('passnew'));
      } else {
        $pass = $this->input->post('pass');
      }

      $data = array(
        'nama' => $this->input->post('nama'),
        'password' => $pass,
        'level' => $this->input->post('level')
      );

      $this->db->where('id', $id);
      return $this->db->update('tbl_user', $data);
    }

    function deleteObat($id)
    {
      $this->db->where('id', $id);
      return $this->db->delete('tbl_obat');
    }

    function deleteUser($id)
    {
      $this->db->where('id', $id);
      return $this->db->delete('tbl_user');
    }

    function pembelian($nama)
    {
      $query = $this->stok($nama);
      foreach ($query as $key) {
        $id = $key->id;
      }

      $data = array(
        'id_obat' => $id,
        'tgl_beli' => $this->input->post('tgl_beli'),
        'nofaktur' => $this->input->post('nomor'),
        'jumlah' => $this->input->post('jumlah'),
        'harga_beli' => $this->input->post('hbeli'),
        'harga_jual' => $this->input->post('hjual')
      );

      return $this->db->insert('tbl_pembelian', $data);
    }

    function laba($data)
    {
      $harga = $data['harga_jual'];
      $id = $data['id_obat'];

      $this->db->where('id_obat', $id);
      $this->db->where('harga_jual', $harga);

      $query = $this->db->get('tbl_pembelian');
      return $query->result_array();
    }

    function penjualan($id)
    {
      $data = array(
        'id_obat' => $id,
        'harga_jual' => $this->session->userdata('harga'.$id)
      );

      $query = $this->laba($data);

      foreach ($query as $key) {
        $harga = $key['harga_beli'];
      }

      $laba = $this->session->userdata('harga'.$id) - $harga;
      $tlaba = $this->session->userdata('jumlah'.$id) * $laba;

      $datestring = '%Y-%m-%d';
      $time = time();
      $date = mdate($datestring, $time);

      $data = array(
        'id_obat' => $id,
        'tgl_jual' => $date,
        'nofaktur' => uniqid(),
        'jumlah' => $this->session->userdata('jumlah'.$id),
        'harga_jual' => $this->session->userdata('harga'.$id),
        'laba' => $tlaba
      );

      return $this->db->insert('tbl_penjualan', $data);
    }

    function getEdit($id)
    {
      $this->db->where('id', $id);
      $query = $this->db->get('tbl_obat');
      return $query->result();
    }

    function getUser($id)
    {
      $this->db->where('id', $id);
      $query = $this->db->get('tbl_user');
      return $query->result();
    }

    function getNumRows()
    {
      $query = $this->db->get('tbl_obat');
      return $query->num_rows();
    }

    function cek($nama)
    {
      $this->db->where('nama', $nama);
      $total = $this->db->get('tbl_obat');
      $num_rows = $total->num_rows();
      return $num_rows;
    }

    function login()
    {
      $query = $this->db->get('tbl_user');
      return $query->result();
    }

    function register()
    {
      $data = array(
        'nama' => $this->input->post('nama'),
        'password' => md5($this->input->post('pass')),
        'level' => 0
      );

      return $this->db->insert('tbl_user', $data);
    }

  }
