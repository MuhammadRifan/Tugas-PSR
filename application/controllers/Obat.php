<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Obat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model('ModelObat', 'obat');

    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        $submit = $this->input->post('submit');

        if ($submit == "Login") {
            $this->form_validation->set_rules('nama', 'Nama User', 'required');
            $this->form_validation->set_rules('pass', 'Password', 'required');

            if ($this->form_validation->run()) {
                $nama = $this->input->post('nama');
                $pass = md5($this->input->post('pass'));
                $sql = $this->obat->login();

                foreach ($sql as $key) {
                    if (($nama == $key->nama) && ($pass == $key->password)) {
                        if ($key->level == 1) {
                            $data = array(
                                'is_logged_in' => 1
                            );
                            $this->session->set_userdata($data);
                            redirect('Obat/adminHome');
                        } elseif ($key->level == 0) {
                            $data = array(
                                'is_logged_in' => 2
                            );
                            $this->session->set_userdata($data);
                            redirect('Obat/homePage');
                        }
                    }
                }
                echo "<p class='text-center' style='color: red;'>Nama atau Password Salah</p>";
            }
        }
        $this->load->view('login');
    }

    public function register()
    {
        $submit = $this->input->post('submit');

        if ($submit == "Register") {
            $this->form_validation->set_rules('nama', 'Nama User', 'required|is_unique[tbl_user.nama]');
            $this->form_validation->set_rules('pass', 'Password', 'required');
            $this->form_validation->set_rules('passcon', 'Confirm Password', 'required|matches[pass]');

            $this->form_validation->set_message('is_unique', "Maaf, nama sudah digunakan");

            if ($this->form_validation->run()) {
                $this->obat->register();
                redirect('Obat/login');
            }
        }
        $this->load->view('register');
    }

    public function adminHome()
    {
        if ($this->session->userdata('is_logged_in') == 1) {
            $data['db'] = $this->obat->selectObat();

            $this->load->view('admin/template/header');
            $this->load->view('admin/admin', $data);
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function adminAdd()
    {
        $submit = $this->input->post('submit');

        if ($submit == "Submit") {
            $this->form_validation->set_rules('nama', 'Nama Obat', 'required');
            $this->form_validation->set_rules('fungsi', 'Fungsi Obat', 'required');
            $this->form_validation->set_rules('tgl_beli', 'Tanggal Pembelian', 'required');
            $this->form_validation->set_rules('nomor', 'Nomor Faktur', 'required');
            $this->form_validation->set_rules('jumlah', 'Jumlah Obat', 'required|numeric');
            $this->form_validation->set_rules('hbeli', 'Harga Beli Obat', 'required|numeric');
            $this->form_validation->set_rules('hjual', 'Harga Jual Obat', 'required|numeric');

            $nama = $this->input->post('nama');

            if ($this->form_validation->run()) {
                $num_rows = $this->obat->cek($nama);
                if ($num_rows == 1) {
                    $this->obat->updateStok($nama);
                } else {
                    $this->obat->insertObat();
                }
                $this->obat->pembelian($nama);
                redirect('Obat/adminHome');
            }
        }

        if ($this->session->userdata('is_logged_in') == 1) {
            $this->load->view('admin/template/header');
            $this->load->view('admin/add/beli');
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function adminEdit($id)
    {
        $submit = $this->input->post('submit');

        if ($submit == "Submit") {
            $this->form_validation->set_rules('nama', 'Nama Obat', 'required');
            $this->form_validation->set_rules('fungsi', 'Fungsi Obat', 'required');
            $this->form_validation->set_rules('stok', 'Stok', 'required|numeric');
            $this->form_validation->set_rules('harga', 'Harga Obat', 'required|numeric');

            $nama = $this->input->post('nama');

            if ($this->form_validation->run()) {
                $this->obat->updateObat($id);
                redirect('Obat/adminHome');
            }
        }

        if ($this->session->userdata('is_logged_in') == 1) {
            $data['db'] = $this->obat->getEdit($id);
            $this->load->view('admin/template/header');
            $this->load->view('admin/edit/edit', $data);
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function adminHapus($id)
    {
        $this->obat->deleteObat($id);
        redirect('Obat/adminHome');
    }

    public function userHome()
    {
        if ($this->session->userdata('is_logged_in') == 1) {
            $data['db'] = $this->obat->selectUser();

            $this->load->view('admin/template/header');
            $this->load->view('admin/user', $data);
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function userAdd()
    {
        $submit = $this->input->post('submit');

        if ($submit == "Submit") {
            $this->form_validation->set_rules('nama', 'Nama User', 'required|is_unique[tbl_user.nama]');
            $this->form_validation->set_rules('pass', 'Password', 'required');
            $this->form_validation->set_rules('passcon', 'Confirm Password', 'required|matches[pass]');
            $this->form_validation->set_rules('level', 'Level', 'required');

            $this->form_validation->set_message('is_unique', "Maaf, nama sudah digunakan");

            if ($this->form_validation->run()) {
                $this->obat->insertUser();
                redirect('Obat/userHome');
            }
        }

        if ($this->session->userdata('is_logged_in') == 1) {
            $this->load->view('admin/template/header');
            $this->load->view('admin/add/userAdd');
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function userHapus($id)
    {
        $this->obat->deleteUser($id);
        redirect('Obat/userHome');
    }

    public function userEdit($id)
    {
        $submit = $this->input->post('submit');

        if ($submit == "Submit") {
            $this->form_validation->set_rules('nama', 'Nama', 'required');

            $passold = $this->input->post('passold');
            $passnew = $this->input->post('passnew');
            $passcon = $this->input->post('passcon');

            if (!empty($passold) || !empty($passnew) || !empty($passcon)) {
                $this->form_validation->set_rules('pass', 'Database', 'trim');
                $this->form_validation->set_rules('passold', 'Password Lama', 'trim|md5|required|matches[pass]');
                $this->form_validation->set_rules('passnew', 'Password Baru', 'trim|required');
                $this->form_validation->set_rules('passcon', 'Confirm Password', 'trim|required|matches[passnew]');
            }

            if ($this->form_validation->run()) {
                $this->obat->updateUser($id);
                redirect('Obat/userHome');
            }
        }

        if ($this->session->userdata('is_logged_in') == 1) {
            $data['db'] = $this->obat->getUser($id);
            $this->load->view('admin/template/header');
            $this->load->view('admin/edit/userEdit', $data);
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function lapPembelian()
    {
        if ($this->session->userdata('is_logged_in') == 1) {
            $data['db'] = $this->obat->selectLapBeli();

            $this->load->view('admin/template/header');
            $this->load->view('admin/laporan/lapPembelian', $data);
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function lapPenjualan()
    {
        if ($this->session->userdata('is_logged_in') == 1) {
            $data['db'] = $this->obat->selectLapJual();

            $this->load->view('admin/template/header');
            $this->load->view('admin/laporan/lapPenjualan', $data);
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function pembelian()
    {
        if ($this->session->userdata('is_logged_in') == 1) {
            $data['db'] = $this->obat->selectBeli();

            $this->load->view('admin/template/header');
            $this->load->view('admin/transaksi/pembelian', $data);
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function penjualan()
    {
        if ($this->session->userdata('is_logged_in') == 1) {
            $data['db'] = $this->obat->selectJual();

            $this->load->view('admin/template/header');
            $this->load->view('admin/transaksi/penjualan', $data);
            $this->load->view('admin/template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function homePage()
    {
        if ($this->session->userdata('is_logged_in') == 2) {
            $data['db'] = $this->obat->selectObat();

            $this->load->view('template/header');
            $this->load->view('homePage', $data);
            $this->load->view('template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function cart()
    {
        if ($this->session->userdata('is_logged_in') == 2) {
            $id = $this->input->post('id');

            if (empty($this->session->userdata('id'.$id))) {
                $data = array(
                    'id'.$id => $id,
                    'nama'.$id => $this->input->post('nama'),
                    'jumlah'.$id => $this->input->post('jumlah'),
                    'harga'.$id => $this->input->post('harga'),
                    'htotal'.$id => $this->input->post('harga') * $this->input->post('jumlah')
                );
            } elseif (!empty($this->session->userdata('id'.$id))) {
                $data = array(
                    'jumlah'.$id => $this->input->post('jumlah') + $this->session->userdata('jumlah'.$id),
                    'htotal'.$id => $this->input->post('harga') + $this->session->userdata('htotal'.$id)
                );
            }

            $this->session->set_userdata($data);
            $data = array(
                'db' => $this->obat->selectObat(),
                'num' => $this->obat->getNumRows()
            );
            $this->load->view('template/header');
            $this->load->view('cart', $data);
            $this->load->view('template/footer');
        } else {
            redirect('Obat/login');
        }
    }

    public function ubahCart($id)
    {
        if ($this->session->userdata('is_logged_in') == 2) {
            $data = array(
                'jumlah'.$id => $this->input->post('jumlah'),
                'htotal'.$id => $this->session->userdata('harga'.$id) * $this->input->post('jumlah')
            );
            $this->session->set_userdata($data);
            redirect('Obat/cart');
        } else {
            redirect('Obat/login');
        }
    }

    public function actdel($id)
    {
        if ($this->session->userdata('is_logged_in') == 2) {
            $this->session->unset_userdata('id'.$id);
            $this->session->unset_userdata('nama'.$id);
            $this->session->unset_userdata('harga'.$id);
            $this->session->unset_userdata('jumlah'.$id);
            $this->session->unset_userdata('htotal'.$id);
            redirect('Obat/cart');
        } else {
            redirect('Obat/login');
        }
    }

    public function pembayaran()
    {
        if ($this->session->userdata('is_logged_in') == 2) {
            $num_rows = $this->obat->getNumRows();

            for ($i = 1; $i <= $num_rows; $i ++) {
                $id = $this->session->userdata('id'.$i);

                if ($id == $i) {
                    $data = array(
                        'nama' => $this->session->userdata('nama'.$i),
                        'id' => $this->session->userdata('id'.$i)
                    );
                    $this->obat->stokJual($data);
                    $this->obat->penjualan($id);
                }
                $this->session->unset_userdata('id'.$id);
                $this->session->unset_userdata('nama'.$id);
                $this->session->unset_userdata('harga'.$id);
                $this->session->unset_userdata('jumlah'.$id);
                $this->session->unset_userdata('htotal'.$id);
            }
            $this->load->view('pembayaran');
        } else {
            redirect('Obat/login');
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('Obat/login');
    }
}
