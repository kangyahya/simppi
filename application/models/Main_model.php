<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    protected $table = "";

    public function all()
    {
        $sql = $this->db->get($this->table);
        return $sql->result();
    }

    public function findById($where = [])
    {
        $column = array_keys($where)[0];
        $value = array_values($where)[0];
        $sql = $this->db->get_where($this->table, [$column => $value]);
        return $sql->row();
    }

    public function getBy($column, $value, $all = FALSE)
    {
        if (is_array($column) && is_bool($value)) {
            $sql = $this->db->select('*')->from($this->table)->where($column)->get();
        } else if (is_string($column) && is_string($value)) {
            $sql = $this->db->select('*')->from($this->table)->where($column, $value)->get();
        }

        if ($all != FALSE || (is_bool($value) && $value == true)) {
            return $sql->result();
        }
        return $sql->row();

    }

    public function insert($data = [], $bacth = FALSE)
    {
        if ($bacth == TRUE) {
            $insert = $this->db->insert_batch($this->table, $data);
        } else {
            $insert = $this->db->insert($this->table, $data);
        }
        return $insert;
    }

    public function update($data = [], $where = [])
    {
        $column = array_keys($where)[0];
        $value = array_values($where)[0];
        return $this->db->where($column, $value)->update($this->table, $data);
    }

    public function updateBy($col, $val, $data = [])
    {
        return $this->db->where($col, $val)->update($this->table, $data);
    }

    public function delete($where = [])
    {
        $column = array_keys($where)[0];
        $value = array_values($where)[0];
        return $this->db->where($column, $value)->delete($this->table);
    }

    public function selectOnly($columns, $where = [], $all = true)
    {
        $sql = $this->db->select($columns)->from($this->table);

        if ($where != NULL) {
            $sql->where($where);
        }

        if ($all == false) {
            return $sql->get()->row();
        }

        return $sql->get()->result();
    }

    public function only($table, $where = NULL)
    {
        $sql = $this->db->select('*')->from($table);
        if ($where != NULL) {
            $sql->where($where);
        }
        return $sql->get()->result();
    }

    public function count()
    {
        $sql = $this->db->get($this->table);
        return $sql->num_rows();
    }

    public function sum($column, $where = NULL)
    {
        $sql = $this->db->select_sum($column)->from($this->table);
        if ($where != NULL) {
            $sql->where($where);
        }
        return $sql->get()->row();
    }

    public function get_last_id()
    {
        $sql = $this->db->select('MAX(id) as id')->from($this->table)->get()->row();
        return $sql->id;
    }

    public function getIdBy($column, $value)
    {
        $sql = $this->db->select('id')->from($this->table)->where($column, $value)->limit(1)->get();
        return $sql->row();
    }

    public function getById($id)
    {
        return $this->findById($id);
    }

    public function first()
    {
        return $this->db->limit(1)->get($this->table)->row();
    }

    public function get($rows)
    {
        $sql = $this->db->limit($rows)->get($this->table);
        return $sql->result();
    }

    public function getLastInsertID()
    {
        return $this->db->insert_id();
    }

    public function getSumOfColumn($column, $conditions = [])
    {
        return $this->db->select_sum($column)
            ->where($conditions)
            ->get($this->table)->row();
    }

    /*
     *  Given two conditions only
     *  where columns1 = 'X' or columns2 = 'Y'
     * */
    public function findByOr($firstWhere = [], $secondWhere = [], $all = true)
    {
        $query = $this->db->select('*')
            ->from($this->table)
            ->where($firstWhere)
            ->or_where($secondWhere)
            ->get();
        if ($all == false) {
            return $query->row();
        }

        return $query->result();
    }

    public function getWhereLike($columns = '*', $where = [], $all = true)
    {
        $query = $this->db->select($columns)
            ->from($this->table)
            ->like($where)
            ->get();
        if ($all == false) {
            return $query->row();
        }

        return $query->result();
    }

}