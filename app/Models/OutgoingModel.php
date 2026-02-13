<?php
namespace App\Models;
use CodeIgniter\Model;

class OutgoingModel extends Model{
    
    protected $table      = 'outgoing';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['membership_id', 'store_id', 'unit_cost', 'user_id', 'qty', 'total_cost', 'date', 'active', 'created_at'];
    protected $useTimestamps = false;

    //begin model extends

    public function get_search_row($data)
    {
        $builder = $this->db->table($this->table);
        if (isset($data["select"]) && $data["select"] != "") $builder->select($data["select"]);
        if (isset($data["where"]) && $data["where"] != "") $builder->where($data["where"]);
        if (isset($data["order"]) && $data["order"] != "") $builder->orderBy($data["order"]);
        if (isset($data["group"]) && $data["group"] != "") $builder->groupBy($data["group"]);
        if (isset($data["join"])) {
            if (count($data["join"]) > 0) {
                foreach ($data["join"] as $rowJoin) {
                    $split = explode(",", $rowJoin);
                    $builder->join($split[0], $split[1]);
                }
            }
        }
        $query = $builder->get();
        return $query->getRow();
    }

    public function search($data)
    {
        $builder = $this->db->table($this->table);
        if (isset($data["select"]) && $data["select"] != "") $builder->select($data["select"]);
        if (isset($data["where"]) && $data["where"] != "") $builder->where($data["where"]);
        if (isset($data["order"]) && $data["order"] != "") $builder->orderBy($data["order"]);
        if (isset($data["group"]) && $data["group"] != "") $builder->groupBy($data["group"]);
        if (isset($data["join"])) {
            if (count($data["join"]) > 0) {
                foreach ($data["join"] as $rowJoin) {
                    $split = explode(",", $rowJoin);
                    $builder->join($split[0], $split[1]);
                }
            }
        }
        if (isset($data["limit"]) && $data["limit"] != "") $builder->limit($data["limit"]);
        $query = $builder->get();
        return $query->getResult();
    }

    public function total_records($data)
    {
        $builder = $this->db->table($this->table);
        if (isset($data["select"]) && $data["select"] != "") $builder->select($data["select"]);
        if (isset($data["where"]) && $data["where"] != "") $builder->where($data["where"]);
        if (isset($data["order"]) && $data["order"] != "") $builder->orderBy($data["order"]);
        if (isset($data["group"]) && $data["group"] != "") $builder->groupBy($data["group"]);
        if (isset($data["join"])) {
            if (count($data["join"]) > 0) {
                foreach ($data["join"] as $rowJoin) {
                    $split = explode(",", $rowJoin);
                    $builder->join($split[0], $split[1]);
                }
            }
        }
        $query = $builder->get();
        return $query->getNumRows();
    }

    public function search_data($data, $inicio, $num_reg)
    {
        $builder = $this->db->table($this->table);
        if (isset($data["select"]) && $data["select"] != "") $builder->select($data["select"]);
        if (isset($data["where"]) && $data["where"] != "") $builder->where($data["where"]);
        if (isset($data["order"]) && $data["order"] != "") $builder->orderBy($data["order"]);
        if (isset($data["group"]) && $data["group"] != "") $builder->groupBy($data["group"]);
        if (isset($data["join"])) {
            if (count($data["join"]) > 0) {
                foreach ($data["join"] as $rowJoin) {
                    $split = explode(",", $rowJoin);
                    $builder->join($split[0], $split[1]);
                }
            }
        }
        $query = $builder->get($num_reg, $inicio);
        return $query->getResult();
    }

    public function searchDataRows($data, $inicio, $num_reg)
    {
        $builder = $this->db->table($this->table);
        if (isset($data["select"]) && $data["select"] != "") {
            $builder->select($data["select"]);
        }

        if (isset($data["where"]) && $data["where"] != "") {
            $builder->where($data["where"]);
        }

        if (isset($data["order"]) && $data["order"] != "") {
            $builder->orderBy($data["order"]);
        }

        if (isset($data["group"]) && $data["group"] != "") {
            $builder->groupBy($data["group"]);
        }

        if (isset($data["join"])) {
            if (count($data["join"]) > 0) {
                foreach ($data["join"] as $rowJoin) {
                    $split = explode(",", $rowJoin);
                    $builder->join($split[0], $split[1]);
                }
            }
        }

        return $builder->get($num_reg, $inicio)->getRow();
    }
    // end extend model  
    
    
    public function get_all($first_day, $last_day){
        $obj_result =  $this->db->query("SELECT outgoing.id, outgoing.qty, outgoing.invoice_id, outgoing.date, outgoing.active, memberships.name AS membership, store.name AS store, CONCAT(users.name ,' ', users.lastname) AS user
                                        FROM outgoing
                                        JOIN memberships ON outgoing.membership_id = memberships.id
                                        JOIN store ON outgoing.store_id = store.id
                                        LEFT JOIN users ON outgoing.user_id = users.id
                                        WHERE outgoing.date >= '$first_day' and outgoing.date < '$last_day'");
        return $obj_result->getResult();
    }

    public function get_data_by_export($where){
        $obj_result =  $this->db->query("SELECT outgoing.id, outgoing.qty, outgoing.invoice_id, outgoing.date, outgoing.active, memberships.name AS membership, store.name AS store
                                        FROM outgoing
                                        JOIN memberships ON outgoing.membership_id = memberships.id
                                        JOIN store ON outgoing.store_id = store.id
                                        WHERE $where");
        return $obj_result->getResult();
    }

    public function get_by_id($id){
        $obj_result =  $this->db->query("SELECT * FROM $this->table WHERE id = $id");
        return $obj_result->getRow();
    }

    public function insertar($data){
        $query = $this->db->table($this->table);
        $query->insert($data);
        return $this->db->insertId();
    }

    public function eliminar($id){
        return $this->db->query("DELETE FROM $this->table WHERE id = $id");
    }
}