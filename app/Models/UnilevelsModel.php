<?php
namespace App\Models;
use CodeIgniter\Model;

class UnilevelsModel extends Model{
    
    protected $table      = 'unilevels';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['id', 'customer_id', 'sponsor_id', 'node', 'active'];
    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


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
        return $query ? $query->getRow() : null;
    }

        /**
    * Obtiene el patrocinador directo (nivel 1) de un usuario
    * @param int $customer_id
    * @return int|null
    */
    public function get_sponsor_level_1($customer_id) {
    $row = $this->where('customer_id', $customer_id)->select('sponsor_id')->first();
    return $row ? $row['sponsor_id'] : null;
    }

    /**
    * Obtiene el patrocinador de nivel 2 de un usuario
    * @param int $customer_id
    * @return int|null
    */
    public function get_sponsor_level_2($customer_id) {
    $level1 = $this->get_sponsor_level_1($customer_id);
    if ($level1) {
    return $this->get_sponsor_level_1($level1);
    }
    return null;
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
        return $query ? $query->getResult() : [];
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

        $query = $builder->get($num_reg, $inicio);
        return $query ? $query->getRow() : null;
    }
    // end extend model  

    public function get_search_by_id($id){
        $obj_result =  $this->db->query("SELECT * FROM customer WHERE customer_id = $id and status_value = 1");
        return $obj_result ? $obj_result->getResult() : [];
    }

    public function get_by_sponsor_id_distint($sponsor_id, $customer_id){
        $obj_result =  $this->db->query("SELECT * FROM unilevels WHERE sponsor_id = $sponsor_id AND customer_id <> $customer_id");
        return $obj_result ? $obj_result->getResult() : [];
    }

    public function get_all_referred($id){
        $obj_result =  $this->db->query("SELECT `customers`.`id`, `customers`.`username`, `customers`.`name`, `customers`.`lastname`, `customers`.`email`, `customers`.`phone`, `customers`.`created_at`, `customers`.`active`
                        FROM (`unilevels`) 
                        JOIN `customers` ON `customers`.`id` = `unilevels`.`customer_id` 
                        WHERE unilevels.node LIKE '%,$id' OR node LIKE '%,$id,%' ORDER BY `unilevels`.`id` DESC");
        return $obj_result ? $obj_result->getResult() : [];
    }

    public function get_all_referred_by_membership($id){
        $obj_result =  $this->db->query("SELECT count(*) as total_membership,
                        (SELECT COUNT(*) FROM unilevels WHERE node LIKE '%,$id' OR node LIKE '%,$id,%') as total_team  
                        FROM (`unilevels`) 
                        JOIN `customers` ON `customers`.`id` = `unilevels`.`customer_id` 
                        WHERE `unilevels`.`sponsor_id` = $id");
        return $obj_result ? $obj_result->getRow() : null;
    } 

    public function get_data_by_customer($id, $begin_date, $end_date){
    $obj_result =  $this->db->query("SELECT `customers`.`id`, `customers`.`dni`, `customers`.`avatar`,`customers`.`email`, `customers`.`code`, `customers`.`name`, `customers`.`lastname`, `customers`.`range_id`, `customers`.`active`, `ranges`.`name` as range_name, `ranges`.`img` as range_img , `countries`.`img` as pais_img, `countries`.`nombre` as pais,
                    (SELECT SUM(points) as points FROM invoices WHERE customer_id = $id AND invoices.date >= '$begin_date 00:00:00' AND  invoices.date < '$end_date 23:59:59' AND invoices.active = '2' and invoices.membership_id = 1) as point_personal,
                    (SELECT  SUM(`points`.`points`) AS points FROM (`points`) WHERE `points`.customer_id = $id AND `points`.`date` >= '$begin_date' AND `points`.`date` <= '$end_date') as point_grupal
                    FROM (`customers`) 
                    JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 
                    JOIN `ranges` ON `customers`.`range_id` = `ranges`.`id` 
                    WHERE `customers`.`id` = $id and countries.id_idioma = 7");
    return $obj_result ? $obj_result->getRow() : null;
    }

    public function get_partners_by_level($id, $begin_date, $end_date){
    $obj_result =  $this->db->query("SELECT `customers`.`id` as customer_id2, `customers`.`dni`, `customers`.`code` ,`customers`.`email`, `customers`.`avatar`, `customers`.`name`, `customers`.`lastname`,`customers`.`created_at`, `customers`.`range_id`, `customers`.`active`, `ranges`.`name` as range_name,`ranges`.`img` as range_img, `countries`.`nombre` as pais_name, `countries`.`img` as pais_img,
                    (SELECT COUNT(*) FROM (`customers`)  JOIN `countries` ON `customers`.`country_id` = `countries`.`id`  JOIN `unilevels` ON `unilevels`.`customer_id` = `customers`.`id` JOIN `ranges` ON `customers`.`range_id` = `ranges`.`id`  WHERE `customers`.`active` = '1' AND `unilevels`.`sponsor_id` = $id and countries.id_idioma = 7 ORDER BY `unilevels`.`id` ASC) as total_active,
                    (SELECT SUM(points) as points FROM invoices WHERE customer_id = customer_id2 AND invoices.date >= '$begin_date 00:00:00' AND  invoices.date < '$end_date 23:59:59' AND invoices.active = '2' and invoices.membership_id = 1) as point_personal,
                    (SELECT  SUM(`points`.`points`) AS points FROM (`points`) WHERE `points`.customer_id = customer_id2 AND `points`.`date` >= '$begin_date 00:00:00' AND `points`.`date` <= '$end_date 23:59:59') as point_grupal  
                    FROM (`customers`) 
                    JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 
                    JOIN `unilevels` ON `unilevels`.`customer_id` = `customers`.`id`
                    JOIN `ranges` ON `customers`.`range_id` = `ranges`.`id` 
                    WHERE `unilevels`.`sponsor_id` = $id and countries.id_idioma = 7 
                    ORDER BY `unilevels`.`id` ASC");
    return $obj_result ? $obj_result->getResult() : [];
    }

    public function get_partners_in_level($id, $begin_date, $end_date){
        $obj_result =  $this->db->query("SELECT `customers`.`id` as customer_id2, `customers`.`code`, `customers`.`email`,`customers`.`created_at`, `customers`.`avatar`,`customers`.`name`, `customers`.`lastname`, `customers`.`range_id`, `unilevels`.`sponsor_id`, `customers`.`active`, `ranges`.`img` as range_img, `ranges`.`name` as range_name, `countries`.`img` as pais_img,
                                        (SELECT COUNT(*) FROM (`customers`)  JOIN `countries` ON `customers`.`country_id` = `countries`.`id`  JOIN `unilevels` ON `unilevels`.`customer_id` = `customers`.`id` JOIN `ranges` ON `customers`.`range_id` = `ranges`.`id`  WHERE `customers`.`active` = '1' AND `unilevels`.`sponsor_id` IN ($id) and countries.id_idioma = 7 ORDER BY `unilevels`.`id` ASC) as total_active,  
                                        (SELECT SUM(points) as points FROM invoices WHERE customer_id = customer_id2 AND invoices.date >= '$begin_date 00:00:00' AND  invoices.date < '$end_date 23:59:59' AND invoices.active = '2' and invoices.membership_id = 1) as point_personal,
                                        (SELECT  SUM(`points`.`points`) AS points FROM (`points`) WHERE `points`.customer_id = customer_id2 AND `points`.`date` >= '$begin_date 00:00:00' AND `points`.`date` <= '$end_date 23:59:59') as point_grupal  
                                        FROM (`customers`) 
                                        JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 
                                        JOIN `unilevels` ON `unilevels`.`customer_id` = `customers`.`id` 
                                        JOIN `ranges` ON `customers`.`range_id` = `ranges`.`id` 
                                        WHERE `unilevels`.`sponsor_id` IN ($id) and countries.id_idioma = 7 ORDER BY `unilevels`.`id` ASC");
        return $obj_result ? $obj_result->getResult() : [];
    }

    public function get_total_partners($id){
        $obj_result =  $this->db->query("SELECT count(`id`) as total FROM (`unilevels`) WHERE `node` like '%$id%'");
        return $obj_result ? $obj_result->getResult() : [];
    }

    public function get_downline_range($id, $range_id){
        $obj_result =  $this->db->query("SELECT unilevels.id FROM (`unilevels`) 
                                        JOIN customers ON unilevels.customer_id = customers.id
                                        WHERE `node` LIKE '%$id%' AND range_id >= $range_id and customers.active = '1'");
        return $obj_result ? $obj_result->getNumRows() : 0;
    }

    public function get_count_downline_by_ranges($id, $range_id_one, $range_id_two, $range_id_three){

        $obj_result =  $this->db->query("SELECT count(*) as total_one,
                                        (SELECT COUNT(*) FROM (`unilevels`) JOIN customers ON unilevels.customer_id = customers.id WHERE `node` LIKE '%,$id%' AND customers.range_id = $range_id_two) AS total_two,
                                        (SELECT COUNT(*) FROM (`unilevels`) JOIN customers ON unilevels.customer_id = customers.id WHERE `node` LIKE '%,$id%' AND customers.range_id = $range_id_three) AS total_three  
                                        FROM (`unilevels`)
                                        JOIN customers ON unilevels.customer_id = customers.id
                                        WHERE `node` LIKE '%,$id%' AND customers.range_id = $range_id_one");
        return $obj_result ? $obj_result->getRow() : null;
    }

    public function get_sponsor_by_range($id, $range_id){
        $obj_result =  $this->db->query("SELECT unilevels.id FROM (`unilevels`) 
                                        JOIN customers ON unilevels.customer_id = customers.id
                                        WHERE customers.active = '1' AND unilevels.sponsor_id = $id AND customers.range_id >= $range_id");
        return $obj_result ? $obj_result->getNumRows() : 0;
    }
    

    public function get_last_sponsor_7_day($date){
        $obj_result =  $this->db->query("SELECT sponsor_id 
                                        FROM unilevels 
                                        WHERE unilevels.created_at > '$date' 
                                        GROUP BY unilevels.sponsor_id");
        return $obj_result ? $obj_result->getResult() : [];
    }

    public function get_ident_by_customer($id){
        $obj_result =  $this->db->query("SELECT `node`FROM (`unilevels`) WHERE customer_id = $id");
        return $obj_result ? $obj_result->getRow() : null;
    }

    public function get_sponsor_range_id($id){
        $obj_result =  $this->db->query("SELECT sponsor_id, 
                                        (SELECT range_id FROM customers WHERE id = sponsor_id) AS range_id,	
                                        (SELECT active FROM customers WHERE id = sponsor_id) AS active		
                                        FROM (`unilevels`) 
                                        WHERE customer_id = $id");
        return $obj_result ? $obj_result->getRow() : null;
    }

    public function get_sponsor_id_by_customer_id($id){
        $obj_result =  $this->db->query("SELECT unilevels.sponsor_id FROM unilevels
                                        WHERE unilevels.customer_id = $id");
        return $obj_result ? $obj_result->getRow() : null;
    }

    public function insertar($data){
        $query = $this->db->table('unilevels');
        $query->insert($data);
        return $this->db->insertId();
    }
}