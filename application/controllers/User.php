<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
        provideAccessTo("1");
        $data = [
            'title' => 'Data Pengguna',
            'no' => 1
        ];
        $this->main_lib->getTemplate('user/index', $data);
    }

    public function get_pengguna()
    {
        if ($this->input->is_ajax_request()) {
            header('Content-Type: application/json');
            $pengguna = $this->User->getJsonResult();
            echo $pengguna;
        } else {
            redirect(base_url('error'));
        }
    }

    public function create()
    {
        provideAccessTo("1");

        $list_user_levels = getUserLevel();

        $data = [
            'title' => 'Tambah Pengguna',
            'user_levels' => $list_user_levels
        ];

        if (isset($_POST['submit'])) {
            $rules = $this->_rules('create');
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('user/form-create', $data);
            } else {
                $password = $this->input->post('password');
                $user_data = [
                    'nama_lengkap' => $this->main_lib->getPost('nama_lengkap'),
                    'username' => $this->main_lib->getPost('username'),
                    'email' => $this->main_lib->getPost('email'),
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'level' => $this->main_lib->getPost('level')
                ];

                $insert = $this->User->insert($user_data);
                if ($insert) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data pengguna berhasil ditambahkan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menambahkan pengguna baru!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('user'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('user/form-create', $data);
        }
    }

    public function edit($user_id)
    {
        provideAccessTo("1");

        if (empty(trim($user_id))) {
            redirect(base_url('user'));
        }

        $list_user_levels = getUserLevel();
        $user = $this->User->findById(['id_pengguna' => $user_id]);
        $data = [
            'title' => 'Edit Pengguna',
            'user' => $user,
            'user_levels' => $list_user_levels
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules('update');
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('user/form-update', $data);
            } else {
                $user_data = [
                    'nama_lengkap' => $this->main_lib->getPost('nama_lengkap'),
                    'username' => $this->main_lib->getPost('username'),
                    'email' => $this->main_lib->getPost('email'),
                    'level' => $this->main_lib->getPost('level')
                ];

                $update = $this->User->update($user_data, ['id_pengguna' => $user_id]);
                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data pengguna berhasil disimpan!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menyimpan data pengguna!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('user'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate('user/form-update', $data);
        }
    }

    public function delete($user_id)
    {
        provideAccessTo("1");
        if (isset($_POST['_method']) && $_POST['_method'] == "DELETE") {
            $data_id = $this->main_lib->getPost('data_id');
            $data_type = $this->main_lib->getPost('data_type');

            if ($data_id === $user_id && $data_type === 'user') {
                $delete = $this->User->delete(['id_pengguna' => $data_id]);
                if ($delete) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Data pengguna berhasil dihapus!',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal menghapus data pengguna!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('user'), 'refresh');
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Gagal menghapus data!',
                ];
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('user'), 'refresh');
            }
        } else {
            redirect('dashboard');
        }
    }

    public function _rules($type)
    {
        //Rule when create new user
        $rules = [
            [
                'field' => 'nama_lengkap',
                'label' => 'Nama Lengkap',
                'rules' => 'required|alpha_numeric_spaces'
            ],
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'required|is_unique[pengguna.username]|min_length[6]|max_length[30]'
            ],
            [
                'field' => 'email',
                'label' => 'email',
                'rules' => 'required|is_unique[pengguna.email]|valid_email'
            ],
            [
                'field' => 'password',
                'label' => 'password',
                'rules' => 'required|min_length[6]'
            ],
            [
                'field' => 'confirm_password',
                'label' => 'confirm_password',
                'rules' => 'required|matches[password]|trim'
            ],
            [
                'field' => 'level',
                'label' => 'level',
                'rules' => 'required|trim'
            ],
        ];

        if ($type == "update") {
            //Rule when update user
            
            $rules = [
                [
                    'field' => 'nama_lengkap',
                    'label' => 'Nama Lengkap',
                    'rules' => 'required|alpha_numeric_spaces'
                ],
                [
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'required|min_length[5]|max_length[30]'
                ],
                [
                    'field' => 'email',
                    'label' => 'email',
                    'rules' => 'required|valid_email'
                ],
                [
                    'field' => 'level',
                    'label' => 'level',
                    'rules' => 'required|trim'
                ],
            ];
        } else if ($type == "password") {
            //Rule when update password user
            $rules = [
                [
                    'field' => 'old_password',
                    'label' => 'Password lama',
                    'rules' => 'required|min_length[6]'
                ],
                [
                    'field' => 'new_password',
                    'label' => 'Password baru',
                    'rules' => 'required|min_length[6]'
                ],
                [
                    'field' => 'confirm_password',
                    'label' => 'Konfirmasi password',
                    'rules' => 'required|matches[new_password]|trim'
                ]
            ];
        }

        return $rules;
    }

    public function profile()
    {
        $id_pengguna = getUser('id_pengguna');
        $list_user_levels = getUserLevel();
        $list_religi = getReligi();
        $data = [
            'title' => 'Profil pengguna',
            'user' => $this->User->findById(['id_pengguna' => $id_pengguna]),
            'biodata' => $this->Biodata->findById(['nra' => getUser('username')]),
            'user_levels' => $list_user_levels,
            'agama' => $list_religi
        ];
        if (isset($_POST['update'])) {
            $rules = $this->_rules('update');
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('user/profile', $data);
            } else {
                if(getUser('level') == "ADMIN_SUPER"):
                    $user_data = [
                        'nama_lengkap' => $this->main_lib->getPost('nama_lengkap'),
                        'username' => $this->main_lib->getPost('username'),
                        'email' => $this->main_lib->getPost('email'),
                        'level' => $this->main_lib->getPost('level')
                    ];
                    $update = $this->User->update($user_data, ['id_pengguna' => $id_pengguna]);
                    if ($update) {
                        $messages = [
                            'type' => 'success',
                            'text' => 'Profil berhasil diperbarui!',
                        ];
                    } else {
                        $messages = [
                            'type' => 'error',
                            'text' => 'Gagal memperbarui profil!'
                        ];
                    }
                
                elseif(getUser("level") == "ANGGOTA_PPI"):
                    $user_data = [
                        'nama_lengkap' => $this->main_lib->getPost('nama_lengkap'),
                        'username' => $this->main_lib->getPost('username'),
                        'email' => $this->main_lib->getPost('email'),
                        'level' => $this->main_lib->getPost('level')
                    ];
                    $update = $this->User->update($user_data, ['id_pengguna' => $id_pengguna]);
                    if ($update) {
                        $messages = [
                            'type' => 'success',
                            'text' => 'Profil berhasil diperbarui!',
                        ];
                    } else {
                        $messages = [
                            'type' => 'error',
                            'text' => 'Gagal memperbarui profil!'
                        ];
                    }
                    $user_biodata = [
                        'nama_lengkap' => $this->main_lib->getPost('nama_lengkap'),
                        'tempat_tanggal_lahir' => $this->main_lib->getPost('tempat_tanggal_lahir'),
                        'golongan_darah' => $this->main_lib->getPost('golongan_darah'),
                        'agama' => $this->main_lib->getPost('agama'),
                        'jenis_kelamin' => $this->main_lib->getPost('jenis_kelamin'),
                        'alamat_rumah' => $this->main_lib->getPost('alamat_rumah'),
                        'asal_sekolah' => $this->main_lib->getPost('asal_sekolah'),
                        'tingkat_paskibraka' => $this->main_lib->getPost('tingkat_paskibraka'),
                        'no_hp' => $this->main_lib->getPost('no_hp'),
                        'email' => $this->main_lib->getPost('email')
                        
                    ];
                    $updatebiodata = $this->Biodata->update($user_biodata, ['nra' => $this->main_lib->getPost('username')]);
                    if ($updatebiodata) {
                        $messages = [
                            'type' => 'success',
                            'text' => 'Biodata berhasil diperbarui!',
                        ];
                    } else {
                        $messages = [
                            'type' => 'error',
                            'text' => 'Gagal memperbarui biodata!'
                        ];
                    }
                endif;
                $this->session->set_flashdata('message', $messages);
                redirect(base_url('user/profile'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate("user/profile", $data);
        }
    }

    public function change_password()
    {
        $id_pengguna = getUser('id_pengguna');
        $user = $this->User->findById(['id_pengguna' => $id_pengguna]);
        $data = [
            'title' => 'Ubah password',
        ];

        if (isset($_POST['update'])) {
            $rules = $this->_rules('password');
            $this->form_validation->set_rules($rules);
            $this->form_validation->set_error_delimiters("<small class='form-text text-danger'>", "</small>");

            if ($this->form_validation->run() === FALSE) {
                $this->main_lib->getTemplate('user/form-password', $data);
            } else {
                $new_password = $this->main_lib->getPost('new_password');
                $old_password = $this->main_lib->getPost('old_password');

                //Validate old password
                $validate = password_verify($old_password, $user->password);
                if ($validate) {
                    $update = $this->User->update([
                        'password' => password_hash($new_password, PASSWORD_DEFAULT)
                    ], [
                        'id_pengguna' => $id_pengguna
                    ]);
                    if ($update) {
                        $messages = [
                            'type' => 'success',
                            'text' => 'Password pengguna berhasil diperbarui!',
                        ];
                    } else {
                        $messages = [
                            'type' => 'error',
                            'text' => 'Gagal mengubah password pengguna!'
                        ];
                    }
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Password lama yang Anda masukan salah!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('user/change-password'), 'refresh');
            }
        } else {
            $this->main_lib->getTemplate("user/form-password", $data);
        }
    }

    public function change_picture()
    {
        if (isset($_POST['upload'])) {
            $config = [
                'upload_path' => './uploads/user/',
                'allowed_types' => 'jpeg|jpg|png',
                'max_size' => '2048',
                'max_width' => '512',
                'max_height' => '512',
                'file_ext_tolower' => TRUE,
                'encrypt_name' => TRUE
            ];

            $this->load->library('upload');
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('picture')) {
                $error = $this->upload->display_errors();
                $error = str_replace(" ", "-", $error);
                redirect(base_url('user/profile') . '?show_modal=true&errmsg=' . $error);
            } else {
                $upload_data = $this->upload->data();
                $file_name = 'uploads/user/' . $upload_data['file_name'];

                //Get user
                $id_pengguna = getUser('id_pengguna');
                $user = $this->User->findById(['id_pengguna' => $id_pengguna]);

                //If there are picture
                if ($user->picture != '' && file_exists(FCPATH . $user->picture)) {
                    //remove old picture
                    unlink(FCPATH . $user->picture);
                }

                $update = $this->User->update(['picture' => $file_name], ['id_pengguna' => $id_pengguna]);

                if ($update) {
                    $messages = [
                        'type' => 'success',
                        'text' => 'Foto profil pengguna berhasil diperbarui',
                    ];
                } else {
                    $messages = [
                        'type' => 'error',
                        'text' => 'Gagal memperbarui foto profil pengguna!'
                    ];
                }

                $this->session->set_flashdata('message', $messages);
                redirect(base_url('user/profile'), 'refresh');
            }

        } else {
            redirect(base_url('user/profile') . '?show_modal=true');
        }
    }
    public function kta()
    {
        $id_pengguna = getUser('id_pengguna');
        $list_user_levels = getUserLevel();
        $data = [
            'title' => 'Kartu Tanda Anggota',
            'user' => $this->User->findById(['id_pengguna' => $id_pengguna]),
            'biodata' => $this->Biodata->findById(['nra' => getUser('username')]),
            'user_levels' => $list_user_levels
        ];
        $this->main_lib->getTemplate("user/kta", $data);

    }
    public function cetak_kta()
    {
        $this->load->view('kta/cetak_kta');
    }
}

/* End of file User.php */
