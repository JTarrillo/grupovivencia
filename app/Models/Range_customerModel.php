<?php
namespace App\Models;
use CodeIgniter\Model;

class Range_customerModel extends Model{
    
    protected $table      = 'range_customer';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['customer_id', 'range_id', 'date', 'points' , 'period_id'];
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

    public function get_all(){
        $obj_result =  $this->db->query("SELECT range_customer.id, customers.name, customers.lastname, customers.code, ranges.id AS range_id,  ranges.name AS range_name, ranges.img, range_customer.points, range_customer.date FROM range_customer
                                        JOIN customers ON customers.id = range_customer.customer_id
                                        JOIN ranges ON ranges.id = range_customer.range_id
                                        ORDER by range_customer.id DESC");
        return $obj_result->getResult();
    }

    public function get_data_by_periodo($customer_id, $begin_date, $end_date){
        $obj_result =  $this->db->query("SELECT range_customer.id, range_customer.customer_id,range_customer.range_id
                                        FROM range_customer
                                        WHERE range_customer.customer_id = $customer_id AND range_customer.date >= '$begin_date 00:00:00' AND range_customer.date <= '$end_date 23:59:59'
                                        ORDER BY range_customer.id DESC");
        return $obj_result->getRow();
    }

    public function get_all_data_by_period($begin_date, $end_date){
        $obj_result =  $this->db->query("SELECT range_customer.customer_id, MAX(range_customer.range_id) as max_range, customers.membership_id, customers.active
                                        FROM range_customer
                                        JOIN customers
                                        ON range_customer.customer_id = customers.id
                                        WHERE range_customer.date >= '$begin_date' AND range_customer.date <= '$end_date'
                                        GROUP BY range_customer.customer_id
                                        ORDER BY range_customer.id DESC");

        return $obj_result->getResult();
    }

    public function get_range_by_customer($customer_id, $range_id, $period_id){
        $obj_result =  $this->db->query("SELECT range_customer.id, range_customer.customer_id,range_customer.range_id
                                        FROM range_customer
                                        WHERE range_customer.customer_id = $customer_id AND range_customer.period_id <= '$period_id' AND range_customer.range_id = $range_id
                                        ORDER BY range_customer.id DESC");
        return $obj_result->getRow();
    }

    public function insertar($data){
        $obj_comments = $this->db->table($this->table);
        $obj_comments->insert($data);
        return $this->db->insertId();
    }

    public function eliminar($id){
        return $this->db->query("DELETE FROM $this->table WHERE id = $id");
    }
}