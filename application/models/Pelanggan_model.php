<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends Main_model
{
    protected $table = 'pelanggan';

    public function getJsonResult()
    {
        $actionEdit = anchor(base_url('pelanggan/edit/$1'), '<i class="fa fa-edit"></i>', array('class' => 'btn btn-light'));
        $actionDelete = "<a href='#' class='btn btn-light' onclick='showConfirmDelete(`pelanggan`, $1)'>";
        $actionDelete .= "<i class='fa fa-trash-alt'></i></a>";
        
        $action = $actionEdit . " ". $actionDelete;
        $this->datatables->select('id_pelanggan, nama_pelanggan, alamat, kontak, kota')
            ->from($this->table)
            ->add_column('action', $action, 'id_pelanggan');
        return $this->datatables->generate();
    }
}

/* End of file Pelanggan_model.php */