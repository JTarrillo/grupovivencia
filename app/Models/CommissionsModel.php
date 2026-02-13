<?php
namespace App\Models;
use CodeIgniter\Model;

class CommissionsModel extends Model{
    
    protected $table      = 'commissions';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 
                                'invoice_id', 
                                'customer_id', 
                                'customer_standby', 
                                'customer_waiting', 
                                'level', 
                                'bonus_id', 
                                'arrive_id', 
                                'amount', 
                                'discount', 
                                'date', 
                                'system_discount', 
                                'active', 
                                'total', 
                                'created_at', 
                                'updated_at'];
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
            $obj_data =  $this->db->query("select * from commissions where status_value = 1 ORDER BY price ASC");
            return $obj_data->getResult();
    }

    public function get_commissions_by_id($id){
        $obj_data = $this->db->query("select * from commissions where customer_id = $id and commissions.status_value = 1 LIMIT 100");
        if ($obj_data === false) {
            return [];
        }
        return $obj_data->getResult();
    }

    public function get_commissions_by_id_bonus($id){
        $obj_data =  $this->db->query("SELECT commissions.commissions_id,commissions.amount, commissions.date, commissions.active, commissions.status_value, bonus.name as bonus 
                                    FROM commissions 
                                    JOIN bonus ON commissions.bonus_id = bonus.bonus_id 
                                    WHERE customer_id = $id and commissions.status_value = 1 
                                    ORDER BY commissions.commissions_id DESC
                                    LIMIT 100");
        return $obj_data->getResult();
    }

    public function get_comissions_standby($id, $begin, $end){
        $obj_data =  $this->db->query("SELECT * FROM commissions 
                                        WHERE commissions.customer_standby = $id
                                        AND DATE >= '$begin 00:00:00' AND DATE <= '$end 23:59:59'");
        return $obj_data->getResult();
    }

    public function get_comissions_bonus_lidership($id, $amount){
        $obj_data =  $this->db->query("SELECT * FROM commissions 
                                        WHERE customer_id = $id AND bonus_id = 7 AND commissions.amount = $amount
                                        ORDER BY commissions.id DESC");
        return $obj_data->getNumRows();
    }

    public function get_comissions_by_sale($invoice_id, $customer_id){
        $obj_data =  $this->db->query("SELECT * FROM commissions 
                                        WHERE commissions.invoice_id = $invoice_id AND customer_id < $customer_id
                                        ORDER BY commissions.id ASC
                                        ");
        return $obj_data->getResult();
    }
    
    public function get_all_by_date($date_start, $date_end){
        $obj_data =  $this->db->query("SELECT commissions.id,commissions.amount,commissions.invoice_id,commissions.level, commissions.date, commissions.active, c1.`name`, c1.`lastname`, c1.`code`, c1.`code`, bonuses.name as bonus, c2.`name` AS name_arrive, c2.`lastname` AS lastname_arrive, c2.`code` AS code_arrive
                                        FROM commissions
                                        JOIN customers AS c1 ON `commissions`.`customer_id` = c1.`id`
                                        JOIN bonuses ON commissions.bonus_id = bonuses.id 
                                        LEFT JOIN customers AS c2 ON `commissions`.`arrive_id` = c2.`id`
                                        WHERE `commissions`.`date` >= '$date_start' and commissions.date <= '$date_end 23:59:59' 
                                        ORDER BY `commissions`.`id` DESC");
        return $obj_data->getResult();
    }
    
    public function get_commissions_limit_30($id, $date_start, $date_end){ 
        $obj_data =  $this->db->query("SELECT 
                commissions.id,
                commissions.amount, 
                commissions.level, 
                commissions.date, 
                commissions.date_shop, 
                commissions.active,
                bonuses.name as tipo,
                c_agente.tipo_agente,
                c_sponsor.name as sponsor_name, c_sponsor.lastname as sponsor_lastname, c_sponsor.code as sponsor_code,
                commissions.bonus_id
            FROM commissions
            JOIN bonuses ON commissions.bonus_id = bonuses.id 
            LEFT JOIN customers AS c_agente ON commissions.customer_id = c_agente.id
            LEFT JOIN unilevels ON unilevels.customer_id = commissions.customer_id
            LEFT JOIN customers AS c_sponsor ON unilevels.sponsor_id = c_sponsor.id
            WHERE commissions.customer_id = $id 
            ORDER BY commissions.id DESC");
        return $obj_data ? $obj_data->getResult() : [];
    }

    public function get_commissions_limit_30_matching($id, $date_start, $date_end){
        $obj_data =  $this->db->query("SELECT `commissions`.`id`, sum(commissions.`amount`) AS amount, commissions.level, `commissions`.`date`,`customers`.`name`, `customers`.`lastname`,`customers`.`code`, `commissions`.`active`, `commissions`.`created_at`, `bonuses`.`name` as bonus 
                                        FROM (`commissions`) 
                                        JOIN `bonuses` 
                                        ON `commissions`.`bonus_id` = `bonuses`.`id`
                                        LEFT JOIN `customers` ON `commissions`.`arrive_id` = `customers`.`id`
                                        WHERE `commissions`.`customer_id` = $id AND bonuses.id = 6 and commissions.date >= '$date_start 00:00:00' and commissions.date <= '$date_end 23:59:59'
                                        GROUP BY code
                                        ORDER BY `commissions`.`id` DESC");
        return $obj_data->getResult();
    }

    public function get_commissions_by_ranges_date($id, $from, $to){
        $obj_data =  $this->db->query("SELECT commissions.id,commissions.amount, commissions.level, commissions.date, commissions.active,`customers`.`name`, `customers`.`lastname`,`customers`.`code`, bonuses.name as bonus
                                        FROM commissions
                                        JOIN bonuses ON commissions.bonus_id = bonuses.id 
                                        LEFT JOIN `customers` ON `commissions`.`arrive_id` = `customers`.`id`
                                        WHERE customer_id = $id and commissions.date >= '$from 00:00:00' and commissions.date <= '$to 23:59:59'  and bonuses.id <> 6
                                        ORDER BY commissions.id DESC");
        return $obj_data->getResult();
    }
    
    public function get_commissions_by_ranges_matching($id, $from, $to){
        $obj_data =  $this->db->query("SELECT `commissions`.`id`, sum(commissions.`amount`) AS amount, `commissions`.`date`,`customers`.`name`, `customers`.`lastname`,`customers`.`code`, `commissions`.`active`, `commissions`.`created_at`, `bonuses`.`name` as bonus 
                                        FROM (`commissions`) 
                                        JOIN `bonuses` 
                                        ON `commissions`.`bonus_id` = `bonuses`.`id`
                                        LEFT JOIN `customers` ON `commissions`.`arrive_id` = `customers`.`id`
                                        WHERE commissions.date >= '$from 00:00:00' and commissions.date <= '$to 23:59:59' and customer_id = $id and bonuses.id = 6
                                        GROUP BY code
                                        ORDER BY `commissions`.`id` DESC
                                        ");
        return $obj_data->getResult();
    }

    public function hide_matching_period($customer_id, $arrive_id, $from, $to ){
        $obj_data =  $this->db->query("UPDATE commissions SET customer_id = null, customer_waiting = $customer_id
                                        WHERE customer_id = $customer_id AND bonus_id = 6 AND arrive_id = $arrive_id
                                        and commissions.date >= '$from 00:00:00' and commissions.date <= '$to 23:59:59'");
        return $obj_data;
    }

    public function show_matching_period($customer_id, $arrive_id, $from, $to ){
        $obj_data =  $this->db->query("UPDATE commissions SET customer_id = $customer_id, customer_waiting = null
                                        WHERE customer_waiting = $customer_id AND bonus_id = 6 AND arrive_id = $arrive_id
                                        and commissions.date >= '$from 00:00:00' and commissions.date <= '$to 23:59:59'");
        return $obj_data;
    }

    public function delete_matching_period($customer_id, $arrive_id, $from, $to ){
        $obj_data =  $this->db->query("DELETE FROM commissions 
                                        WHERE customer_id = $customer_id AND bonus_id = 6 
                                        and commissions.date >= '$from 00:00:00' and commissions.date <= '$to 23:59:59' AND arrive_id = $arrive_id");
        return $obj_data;
    }

    public function get_commissions_by_id_bonus_envios($bonus_id, $customer_id){
        $obj_data =  $this->db->query("SELECT commissions.id,commissions.amount, commissions.date, commissions.active, commissions.arrive_id, commissions.status_value, bonus.name as bonus, customer.first_name,  customer.last_name, customer.code
                                    FROM commissions
                                    JOIN bonus ON commissions.bonus_id = bonus.bonus_id
                                    LEFT JOIN customer ON commissions.arrive_id = customer.customer_id
                                    WHERE commissions.bonus_id = $bonus_id and commissions.customer_id = $customer_id and commissions.status_value = 1 
                                    ORDER BY commissions.commissions_id DESC
                                    LIMIT 100");
        return $obj_data->getResult();
    }


    public function global_info($id, $begin, $end){
        $obj_data =  $this->db->query("SELECT sum(amount) as total, 
                                        (SELECT sum(amount) FROM commissions WHERE customer_id = $id AND commissions.date >= '$begin 00:00:00' and commissions.date <= '$end 23:59:59' and amount > 0) as total_disponible,
                                        (SELECT sum(amount) FROM commissions WHERE customer_id = $id AND commissions.date >= '$begin 00:00:00' and commissions.date <= '$end 23:59:59' and bonus_id = 1) as total_patrocinio, 
                                        (SELECT sum(amount) FROM commissions WHERE customer_id = $id AND commissions.date >= '$begin 00:00:00' and commissions.date <= '$end 23:59:59' and bonus_id = 7) as total_liderazgo,
                                        (SELECT sum(amount) FROM commissions WHERE customer_id = $id AND commissions.date >= '$begin 00:00:00' and commissions.date <= '$end 23:59:59' and bonus_id = 5) as total_residual_mlm,
                                        (SELECT sum(amount) FROM commissions WHERE customer_id = $id AND commissions.date >= '$begin 00:00:00' and commissions.date <= '$end 23:59:59' AND bonus_id = 6) as total_reconsumo_propio
                                        FROM commissions 
                                        WHERE customer_id = $id and active = '1'");
        return $obj_data->getRow();
    }

    public function commission_by_period($id, $begin, $end){
        $obj_data =  $this->db->query("SELECT sum(amount) as total_comissions,
                                    (SELECT code FROM period ORDER BY period.id DESC LIMIT 1) as code_period,
                                    (select sum(amount) FROM commissions WHERE customer_id = $id and commissions.date >= '$begin 00:00:00' and commissions.date <= '$end 23:59:59' and commissions.bonus_id <> 8) as total_periodo, 
                                    (select sum(amount) FROM commissions WHERE customer_id = $id and commissions.date < '$begin 00:00:00') as total_disponible,
                                    (select IFNULL(ABS(sum(amount)), 0) FROM commissions WHERE customer_id = $id and amount < 0 and commissions.date < '$begin 00:00:00') as total_discount,
                                    (select total_disponible - total_discount) as total
                                    FROM (`commissions`) 
                                    WHERE `customer_id` = $id and active = '1'");
        return $obj_data->getRow(); 
    }

    public function get_total_commission($id){
        $obj_data =  $this->db->query("SELECT sum(amount) as total_comissions, 
                                    (SELECT sum(amount) FROM commissions WHERE customer_id = $id) as total_disponible 
                                    FROM (`commissions`) 
                                    WHERE `customer_id` = $id and active = '1'");
        return $obj_data->getRow(); 
    }

    public function get_max_comissions(){
        $obj_data =  $this->db->query("SELECT `customer`.`customer_id`, sum(amount) as total_max, `customer`.`first_name`, `customer`.`last_name`, `paises`.`img` 
                                        FROM (`commissions`) 
                                        JOIN `customer` ON `customer`.`customer_id` = `commissions`.`customer_id` 
                                        JOIN `paises` ON `customer`.`country` = `paises`.`id` 
                                        WHERE `commissions`.`active` = 1 and customer.active = 1 and paises.id_idioma = 7 and commissions.customer_id <> 1 and commissions.bonus_id <> 9  GROUP BY `customer`.`customer_id` ORDER BY `total_max` DESC LIMIT 10");
        return $obj_data->getResult();
    }

    public function get_last_partner(){
        $obj_data =  $this->db->query("SELECT `customer`.`customer_id`, `customer`.`first_name`, `customer`.`last_name`, `customer`.`code`, `paises`.`img` 
                                        FROM (`customer`) 
                                        JOIN `paises` ON `customer`.`country` = `paises`.`id`
                                        WHERE paises.id_idioma = 7
                                        ORDER BY `customer`.`customer_id` DESC 
                                        LIMIT 10");
        return $obj_data->getResult();
    }

    
    
    public function get_comssions_by_customer($id){
        $obj_data =  $this->db->query("SELECT `commissions`.`id`, `commissions`.`customer_id`, `commissions`.`date`, `commissions`.`amount`, `commissions`.`bonus_id`, `commissions`.`active`, `customers`.`name`, `customers`.`lastname`, `customers`.`code` 
                                        FROM (`commissions`) 
                                        JOIN `customers` ON `commissions`.`customer_id` = `customers`.`id` 
                                        WHERE `commissions`.`id` = $id");
        return $obj_data->getRow();
    }

    public function get_comissions_bonus_leadership_customer_id($customer, $amount){
        $obj_data =  $this->db->query("SELECT * FROM commissions
                                        WHERE commissions.customer_id = $customer AND commissions.bonus_id = 7 AND commissions.amount = $amount");
        return $obj_data->getNumRows();
    }
    

    public function get_total_commission_by_customer($id){
        $obj_data =  $this->db->query("SELECT sum(amount) as total_comissions 
                                     FROM (`commissions`) WHERE `customer_id` = $id and active = 1 and bonus_id <> 9 and bonus_id <> 3");
        return $obj_data->getResult();
    }

    public function get_total_commission_by_customer_ranges($first_month_day, $last_month_day){
        $obj_data =  $this->db->query("SELECT `binary`.`binary_active`,`commissions`.`bonus_id`, `commissions`.`customer_id`, `commissions`.`commissions_id`, `customer`.`range_id` 
                                      FROM (`commissions`) 
                                      JOIN `customer` ON `customer`.`customer_id` = `commissions`.`customer_id` 
                                      JOIN `binary` ON `customer`.`customer_id` = `binary`.`customer_id` 
                                      WHERE `binary`.`binary_active` = 1 AND `commissions`.`date` >= '$first_month_day' AND `commissions`.`date` < '$last_month_day' AND `commissions`.`active` = 1 AND `commissions`.`bonus_id` <> 4 AND `commissions`.`bonus_id` <> 9 
                                      GROUP BY `commissions`.`customer_id`");
        return $obj_data->getResult();
    }

    public function get_customer_bonus_liderazgo(){
        $obj_data =  $this->db->query("SELECT commissions.commissions_id, customer.customer_id, customer.code, customer.first_name, customer.last_name, bonus.name, commissions.amount, commissions.date, commissions.active FROM commissions 
                                        JOIN customer ON commissions.customer_id = customer.customer_id
                                        JOIN bonus ON commissions.bonus_id = bonus.bonus_id
                                        WHERE commissions.bonus_id = 3
                                        ORDER BY commissions.date DESC");
        return $obj_data->getResult();
    }

    public function get_verification_unique_patrocinio($sponsor_id, $customer_id){
        $obj_result =  $this->db->query("SELECT * FROM commissions WHERE bonus_id = 1 and customer_id = $sponsor_id AND arrive_id = $customer_id");
        return $obj_result->getNumRows();
    }
    
    public function get_commission_data($id){
        $obj_data =  $this->db->query("SELECT `commissions`.`id`, `commissions`.`amount`, `commissions`.`date`,`customers`.`name`, `customers`.`lastname`,`customers`.`code`, `commissions`.`active`, `commissions`.`created_at`, `bonuses`.`name` as bonus 
                                        FROM (`commissions`) 
                                        JOIN `bonuses` 
                                        ON `commissions`.`bonus_id` = `bonuses`.`id`
                                        LEFT JOIN `customers` ON `commissions`.`arrive_id` = `customers`.`id`
                                        WHERE `commissions`.`customer_id` = $id ORDER BY `commissions`.`id` DESC LIMIT 100");
        return $obj_data->getResult();
    }

    public function insertar($data){
        $obj_data = $this->db->table('commissions');
        $obj_data->insert($data);
        return $this->db->insertId();
    }

    public function eliminar($id){
        return $this->db->query("DELETE FROM commissions WHERE id = $id");
    }

    /**
     * Obtiene comisiones inmobiliarias (relacionadas con lotes vendidos) para un usuario
     */
    public function get_inmobiliaria_commissions($customer_id) {
        $sql = "SELECT c.* FROM commissions c JOIN lots l ON c.customer_id = l.customer_id WHERE l.status = 'sold' AND c.active = 1 AND l.sale_date IS NOT NULL AND c.customer_id = ?";
        $query = $this->db->query($sql, [$customer_id]);
        return $query->getResult();
    }
}