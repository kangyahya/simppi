<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keterangan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2");
    }

    public function index()
    {
        $data = [
            'title' => 'Data keterangan',
            'keterangans' => $this->Keterangan->all(),
            'no' => 1
        ];
        $this->main_lib->getTemplate('keterangan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah keterangan',
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('keterangan/form-create', $data);
            } else {
                $keterangan_data = [
                    'nama_keterangan' => $this->main_lib->getPost('nama_keterangan'),
                    'penjelasan' => $this->main_lib->getPost('penjelasan'),
                ];

                $insert = $this->Keterangan->insert($keterangan_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data keterangan berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan data keterangan baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('keterangan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('keterangan/form-create', $data);
        }
    }

    public function edit($id_keterangan)
    {
        if (empty(trim($id_keterangan))) {
            redirect(base_url('keterangan'));
        }

        $keterangan = $this->Keterangan->findById(['id_keterangan' => $id_keterangan]);
        $data = [
            'title' => 'Edit keterangan',
            'keterangan' => $keterangan,
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('keterangan/form-update', $data);
            } else {
                $keterangan_data = [
                    'nama_keterangan' => $this->main_lib->getPost('nama_keterangan'),
                    'penjelasan' => $this->main_lib->getPost('penjelasan'),
                ];

                $update = $this->Keterangan->update($keterangan_data, ['id_keterangan' => $id_keterangan]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data keterangan berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data keterangan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('keterangan'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('keterangan/form-update', $data);
        }
    }

    public function delete($id_keterangan)
    {
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $id_keterangan && $data_type === 'keterangan') {
                $delete = $this->Keterangan->delete(['id_keterangan' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data keterangan berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data keterangan!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('keterangan'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('keterangan'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules()
    {
        return [
            [
                'field' => 'nama_keterangan',
                'name' => 'nama_keterangan',
                'rules' => 'required'
            ],
            [
                'field' => 'penjelasan',
                'name' => 'Penjelasan',
                'rules' => 'required'
            ]
        ];
    }
}

/* End of file keterangan.php */
