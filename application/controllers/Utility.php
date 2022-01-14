<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utility extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!isAuthenticated()) {
            redirect(base_url('auth'));
        }
        provideAccessTo("1|2");
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->library('zip');
    }

    public function index()
    {
        $data = [
            'title' => 'Backup dan Retore Database'
        ];

        $this->main_lib->getTemplate("utility/index", $data);
    }

    public function create_backup()
    {
        if (isset($_POST['backup'])) {
            $this->load->dbutil();
            $fileName = "Backup_" . date("Y_m_d_H_i_s");
            $dbFormat = [
                'format' => 'zip',
                'filename' => $fileName . '.sql'
            ];

            $backup = $this->dbutil->backup($dbFormat);
            $backupFileName = $fileName . '.zip';
            $backupPath = FCPATH . '/backup_db/';
            $save = $backupPath . $backupFileName;

            write_file($save, $backup);
            force_download($backupFileName, $backup);
        } else {
            redirect(base_url('utility'));
        }
    }

    public function create_backup_file()
    {
        if (isset($_POST['backup-file'])) {
            $this->load->dbutil();
            $fileName = "Backup_File_Upload_" . date("Y_m_d_H_i_s") . ".zip";
            $uploadedPath = 'uploads';
            $this->zip->read_dir($uploadedPath);
            $this->zip->download($fileName);
        } else {
            redirect(base_url('utility'));
        }
    }

    public function restore_db()
    {
        if (isset($_POST['restore'], $_FILES['backup_file'])) {
            //Validate password
            $password = $this->main_lib->getPost('password');
            $current_password = getUser('password');

            $validate = password_verify($password, $current_password);

            //When valid password
            if ($validate) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'sql';

                $this->load->library('upload');
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('backup_file')) {
                    $error = $this->upload->display_errors();
                    $error = str_replace(" ", "-", $error);
                    redirect(base_url('utility') . '?error=true&errmsg=' . $error);
                } else {
                    $status_restore = false;
                    $upload_data = $this->upload->data();
                    $file_name = FCPATH . 'uploads/' . $upload_data['file_name'];
                    $sql_contents = file_get_contents($file_name);
                    $sql_statements = explode(";", $sql_contents);

                    foreach ($sql_statements as $query) {
                        if(!empty(trim($query))) {
                            $pos = strpos($query, 'ci_sessions');
                            if ($pos == false) {
                                $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                                $result = $this->db->query($query);
                                if ($result) {
                                    $status_restore = true;
                                }
                            } else {
                                continue;
                            }
                        } else {
                            continue;
                        }
                    }

                    if ($status_restore) {
                        unlink($file_name);

                        $messages = [
                            'type' => 'success',
                            'text' => 'Proses restore database berhasil dilakukan.'
                        ];
                    } else {
                        $messages = [
                            'type' => 'error',
                            'text' => 'Gagal me-restore database. Silahkan ulangi lagi.'
                        ];
                    }
                }
            } else {
                $messages = [
                    'type' => 'error',
                    'text' => 'Password yang Anda masukan salah! Restore database dibatalkan.'
                ];
            }

            $this->session->set_flashdata('message', $messages);
            redirect(base_url('utility'), 'refresh');
        } else {
            redirect(base_url('utility'));
        }
    }

}

/* End of file Utility.php */
