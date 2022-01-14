<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Main_lib {
    protected $ci;

    public function __construct()
    {
    	$this->ci =& get_instance();
    }

    public function  isLogin()
	{
		if ($this->ci->session->is_logged_in === TRUE) {
			return true;
		} else {
			return false;
		}
	}

	public function getPost($key)
	{
        return $this->ci->input->post($key, true);
	}

	public function getParam($key)
	{
        return $this->ci->input->get($key, true);
	}

	public function createFirstUser()
	{
		$check_in_users_table = $this->ci->db->query("SELECT * FROM pengguna")->num_rows();

		if($check_in_users_table == 0) {
			$data_users = [
				'nama_lengkap'	=> 'Muhammad Yahya',
				'username'	=> 'yahya',
				'email'		=> 'yahya@mail.com',
				'password'	=> password_hash(123456, PASSWORD_DEFAULT),
				'level'		=> 'ADMIN_SUPER',
			];

			return $this->ci->db->insert('pengguna', $data_users);
		} else {
			return false;
		}
	}

	public function getTemplate($view_file, $data = [])
    {
        $this->ci->load->view('templates/header', $data);
        $this->ci->load->view('templates/layout');
        $this->ci->load->view('templates/sidebar');
        $this->ci->load->view($view_file);
        $this->ci->load->view('templates/footer');
        $this->ci->load->view('templates/js');
    }

    /*
     *  If return is as array value, it means there are error while upload the image
     *  But, if return is string value, it means successfully upload image or file
     * */
    public function _doUpload($inputName, $config = [])
    {
        $fileName = "";
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['name'] !== '') {
            $this->ci->load->library('upload', $config);

            if ($this->ci->upload->do_upload($inputName)) {
                $fileName = $this->ci->upload->data("file_name");
            } else {
                $error = $this->ci->upload->display_errors();
                return [
                    'error' => $error
                ];
            }
        } else {
            $fileName = "noimage.png";
        }

        return $fileName;
    }

}