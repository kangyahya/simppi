<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengaturan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
    }

    public function index()
    {
        provideAccessTo("1|2");
        $pengaturan = $this->Pengaturan->first();
        $data = [
            'title' => 'Pengaturan',
            'pengaturan' => $pengaturan
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules();
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate("pengaturan/index", $data);
            } else {
                $data_pengaturan = [
                    'app_name' => $this->main_lib->getPost('app_name'),
                    'color_theme' => $this->main_lib->getPost('color_theme'),
                    'show_full_sidebar' => $this->main_lib->getPost('show_full_sidebar'),
                ];

                //Check pengaturan
                $check = $this->Pengaturan->first();
                if ($check) {
                    $id_pengaturan = $check->id_pengaturan;
                    $insert = $this->Pengaturan->update($data_pengaturan, ['id_pengaturan' => $id_pengaturan]);
                } else {
                    $insert = $this->Pengaturan->insert($data_pengaturan);
                }

                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Pengaturan aplikasi berhasil diperbarui',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan perubahan pengaturan aplikasi!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('pengaturan-aplikasi'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate("pengaturan/index", $data);
        }
    }

    private function _rules()
    {
        return [
            [
                'field' => 'app_name',
                'label' => 'Nama Aplikasi',
                'rules' => 'required'
            ],
            [
                'field' => 'color_theme',
                'label' => 'Warna Tema',
                'rules' => 'required'
            ],
            ['field' => 'show_full_sidebar',
                'label' => 'Tampilkan full menu',
                'rules' => 'required'
            ]
        ];
    }

    public function change_sidebar_appearance()
    {
        if ($this->input->is_ajax_request()) {
            $status = $this->main_lib->getPost('status');
            $pengaturan = $this->Pengaturan->first();
            $id_pengaturan = $pengaturan->id_pengaturan;
            $update = $this->Pengaturan->update([
                'show_full_sidebar' => $status
            ], ['id_pengaturan' => $id_pengaturan]);
            if ($update) {
                $response = ['status' => 'success',];
            } else {
                $response = ['status' => 'error'];
            }
            echo json_encode($response);
        }
    }
}

/* End of file Pengaturan.php */