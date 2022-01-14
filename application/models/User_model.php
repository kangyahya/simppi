<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends Main_model
{

    protected $table = "pengguna";

    public function getPicture($key, $value)
    {
        $sql = $this->db->select("picture")->from($this->table)
            ->where($key, $value)->get();
        return $sql->row();
    }

    public function getJsonResult()
    {
        $actionEdit = anchor(base_url('user/edit/$1'), '<i class="fa fa-edit"></i>', array('class' => 'btn btn-light'));
        $actionDelete = "<a href='#' class='btn btn-light' onclick='showConfirmDelete(`user`, $1)'>";
        $actionDelete .= "<i class='fa fa-trash-alt'></i></a>";

        $action = $actionEdit . " " . $actionDelete;

        $level = "<span class='badge badge-$1'>$1</span>";
        $this->datatables->select("id_pengguna, nama_lengkap, username, email, level, (
            CASE
                WHEN level = 'ADMIN_SUPER' THEN 'primary'
                WHEN level = 'ADMIN_TOKO' THEN 'info'
    			WHEN level = 'ADMIN_KEUANGAN' THEN 'success'
    			WHEN level = 'ADMIN_SUPPLIER' THEN 'warning'
    			WHEN level = 'ADMIN_PAJAK' THEN 'danger'
    		END
        ) AS user_level")
            ->from($this->table)
            ->add_column('action', $action, 'id_pengguna');
        return $this->datatables->generate();
    }
}

/* End of file User_model.txt */
/* Location: ./application/models/User_model.txt */