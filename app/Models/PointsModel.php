<?php
namespace App\Models;
use CodeIgniter\Model;

class PointsModel extends Model{
    
    protected $table      = 'points';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id', 
        'customer_id', 
        'invoice_id', 
        'departure_id', 
        'points', 
        'date', 
        'system', 
        'range', 
        'active'
    ];

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

    public function get_all_by_customer($date_start, $date_end){
        $obj_data =  $this->db->query("SELECT `points_binary`.`id`, `customer`.`customer_id`, `customer`.`username`, `customer`.`first_name`, `customer`.`last_name`, `points_binary`.`left`, `points_binary`.`right`, `points_binary`.`date`, `points_binary`.`system`, `points_binary`.`status` 
                                      FROM (`customer`) 
                                      JOIN `points_binary` ON `points_binary`.`customer_id` = `customer`.`customer_id` 
                                      WHERE `points_binary`.`date` >= '$date_start' and points_binary.date <= '$date_end'");
        return $obj_data->getResult();
    }

    public function get_all_by_customer_date($customer_id, $date_start, $date_end){
        $obj_data =  $this->db->query("SELECT  SUM(`points`.`points`) AS points
                                        FROM (`points`) 
                                        WHERE `points`.customer_id = $customer_id AND `points`.`date` >= '$date_start' AND `points`.`date` <= '$date_end'");
        return $obj_data->getResult();
    }

    public function get_all_by_customer_by_id($id){
        $obj_data =  $this->db->query("SELECT `points_binary`.`id`, `customer`.`customer_id`, `customer`.`username`, `customer`.`first_name`, `customer`.`last_name`, `points_binary`.`left`, `points_binary`.`right`, `points_binary`.`date`, `points_binary`.`system`, `points_binary`.`status` 
                                     FROM (`customer`) 
                                     JOIN `points_binary` 
                                     ON `points_binary`.`customer_id` = `customer`.`customer_id` 
                                     WHERE `points_binary`.`id` = $id");
        return $obj_data->getResult();
    }

    public function get_all_by_customer_by_id_date($id, $date_start, $date_end){
        $obj_data =  $this->db->query("SELECT `points_binary`.`id`, `points_binary`.`left`, `points_binary`.`right`, `points_binary`.`date`, `points_binary`.`system`, `points_binary`.`status`, `customer`.`first_name`, `customer`.`last_name`, `customer`.`username`
                                     FROM (`points_binary`) 
                                     LEFT JOIN `customer` ON `points_binary`.`departure_id` = `customer`.`customer_id` 
                                     WHERE `points_binary`.`date` >= '$date_start' and points_binary.date <= '$date_end' and `points_binary`.`customer_id` = $id
                                     ORDER BY `points_binary`.`id` DESC");
        return $obj_data->getResult();
    }

    public function get_left_right_by_customer($id){
        $obj_data =  $this->db->query("SELECT sum(points_binary.left) as total_left, 
                                     (select sum(points_binary.right) from points_binary where customer_id = $id AND points_binary.`range` IS NULL) as total_right 
                                     FROM (`points_binary`) WHERE `customer_id` = $id AND points_binary.`range` IS NULL");
        return $obj_data->getResult();
    }

    public function get_left_right_by_customer_date($id, $first_previus_day, $last_previus_day){
        $obj_data =  $this->db->query("SELECT sum(points_binary.left) as total_left, 
                                     (select sum(points_binary.right) from points_binary where `points_binary`.`date` >= '$first_previus_day' and points_binary.date <= '$last_previus_day' and customer_id = $id) as total_right 
                                     FROM (`points_binary`) WHERE `points_binary`.`date` >= '$first_previus_day' and points_binary.date <= '$last_previus_day' and `customer_id` = $id");
        return $obj_data->getResult();
    }

    public function get_point_by_customer_ranges($customer_id, $first_month_day, $last_month_day){
        $obj_data =  $this->db->query("SELECT SUM(points_binary.left) as total_point_left, 
                                        (select sum(points_binary.right) FROM points_binary WHERE `points_binary`.`date` >= '$first_month_day' AND `points_binary`.`date` < '$last_month_day' AND customer_id = $customer_id and status = 1) as total_point_right 
                                        FROM (`points_binary`) 
                                        WHERE `points_binary`.`date` >= '$first_month_day' AND `points_binary`.`date` < '$last_month_day' AND `customer_id` = $customer_id and status = 1");
        return $obj_data->getResultArray();
    }

    public function insertar($data){ 
        $obj_comments = $this->db->table('points');
        $obj_comments->insert($data);
        return $this->db->insertId();
    }

    public function eliminar($id){
        return $this->db->query("DELETE FROM points WHERE id = $id");
    }
}