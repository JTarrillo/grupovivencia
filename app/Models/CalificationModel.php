<?php
namespace App\Models;
use CodeIgniter\Model;

class CalificationModel extends Model{
    
    protected $table      = 'calification';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id','customer_id', 'range_id', 'personal_point', 'group_point', 'amount' , 'date', 'created_at'];
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
        $obj_result =  $this->db->query("SELECT incoming.id, incoming.date, incoming.unit_cost, memberships.name AS membership, suppliers.name AS supplier,store.id as store_id ,store.name as store, incoming.qty, incoming.total_cost, incoming.active, CONCAT(users.name ,' ', users.lastname) AS user
                                        FROM incoming
                                        JOIN memberships ON incoming.membership_id = memberships.id
                                        JOIN store ON incoming.store_id = store.id
                                        JOIN suppliers ON incoming.supplier_id = suppliers.id
                                        JOIN users ON incoming.user_id = users.id
                                        WHERE incoming.date >= '$first_day' and incoming.date < '$last_day'");
        return $obj_result->getResult();
    }

    public function get_calification_by_period_id($id, $first_day, $last_day){
        $obj_result =  $this->db->query("SELECT calification.id, calification.personal_point, calification.group_point, customers.name, customers.lastname, customers.username, calification.range_id, calification.date,ranges.id AS range_id, ranges.name AS range_name, ranges.img
                                        FROM calification
                                        JOIN customers ON calification.customer_id = customers.id
                                        JOIN ranges ON calification.range_id = ranges.id
                                        WHERE customer_id = $id AND calification.date BETWEEN '$first_day 00:00:00' AND '$last_day 23:59:59'");
        return $obj_result->getResult();
    }

    public function get_calification_by_period_travel($id, $first_day, $last_day){
        $obj_result =  $this->db->query("SELECT * FROM calification
                                         WHERE customer_id = $id AND DATE BETWEEN '$first_day 00:00:00' AND '$last_day 23:59:59'");

        return $obj_result->getNumRows();
    }

    //zafiro
    public function get_calification_by_international_travel($id, $first_day, $last_day){
        $obj_result =  $this->db->query("SELECT * FROM calification
                                         WHERE customer_id = $id AND DATE >= '$first_day 00:00:00' AND DATE <= '$last_day 23:59:59' AND range_id >= 5");
        return $obj_result->getNumRows();
    }

    public function get_calification_by_period_car($id, $first_day, $last_day){
        $obj_result =  $this->db->query("SELECT * FROM calification
                                         WHERE customer_id = $id AND DATE >= '$first_day 00:00:00' AND DATE <= '$last_day 23:59:59' AND range_id >= 6");
        return $obj_result->getNumRows();
    }

    public function get_calification_by_house_star($id, $first_day, $last_day){
        $obj_result =  $this->db->query("SELECT * FROM calification
                                         WHERE customer_id = $id AND DATE >= '$first_day 00:00:00' AND DATE <= '$last_day 23:59:59' AND range_id >= 9");
        return $obj_result->getNumRows();
    }

    public function get_calification_by_period_car_cash($id, $first_day, $last_day){
        $obj_result =  $this->db->query("SELECT sum(amount) as amount FROM calification
                                         WHERE customer_id = $id AND DATE >= '$first_day 00:00:00' AND DATE <= '$last_day 23:59:59' AND range_id >= 6");
        return $obj_result->getRow();
    }

    public function get_calification_by_house($id, $first_day, $last_day){
        $obj_result =  $this->db->query("SELECT sum(amount) as amount FROM calification
                                         WHERE customer_id = $id AND DATE >= '$first_day 00:00:00' AND DATE <= '$last_day 23:59:59' AND range_id >= 9");
        return $obj_result->getRow();
    }

    public function get_all_calification_by_period($first_day, $last_day){
        $obj_result =  $this->db->query("SELECT calification.id, customers.id AS customer_id2, customers.name, customers.lastname, customers.code,
                                        (SELECT COUNT(*) FROM calification WHERE customer_id = customer_id2 AND calification.date BETWEEN '$first_day 00:00:00' AND '$last_day 23:59:59') AS total_travel,
                                        (SELECT COUNT(*) FROM calification WHERE customer_id = customer_id2 AND calification.date BETWEEN '$first_day 00:00:00' AND '$last_day 23:59:59' AND calification.range_id >= 6) AS total_car,
                                        (SELECT COUNT(*) FROM calification WHERE customer_id = customer_id2 AND calification.date BETWEEN '$first_day 00:00:00' AND '$last_day 23:59:59' AND calification.range_id >= 5) AS total_travel_international,
                                        (SELECT COUNT(*) FROM calification WHERE customer_id = customer_id2 AND calification.date BETWEEN '$first_day 00:00:00' AND '$last_day 23:59:59' AND calification.range_id >= 9) AS total_house
                                        FROM calification
                                        JOIN customers ON customers.id = calification.customer_id
                                        WHERE calification.date BETWEEN '$first_day 00:00:00' AND '$last_day 23:59:59'
                                        GROUP BY calification.customer_id");
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