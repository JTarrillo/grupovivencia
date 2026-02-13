<?php
namespace App\Models;
use CodeIgniter\Model;

class CustomerModel extends Model{
        /**
         * Devuelve los patrocinadores activos (IDs únicos en sponsor_id de unilevels)
         * @return array
         */
        public function getActiveSponsors()
        {
            $db = \Config\Database::connect();
            $sponsorIds = $db->table('unilevels')
                ->select('sponsor_id')
                ->distinct()
                ->where('sponsor_id IS NOT NULL')
                ->get()
                ->getResultArray();
            $ids = array_column($sponsorIds, 'sponsor_id');
            if (empty($ids)) return [];
            return $this->whereIn('id', $ids)
                        ->where('active', 1)
                        ->findAll();
        }
    
    protected $table      = 'customers';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'id',
        'range_id',
        'username',
        'code',
        'country_id',
        'membership_id',
        'password',
        'name',
        'lastname',
        'co_name',
        'co_dni',
        'address',
        'mother_last',
        'phone',
        'dni',
        'civil_status', // <-- agregado
        'passport',
        'temporal',
        'email',
        'wallet',
        'pin',
        'kyc',
        'ads',
        'date',
        'date_active',
        'pay',
        'avatar',
        'ruc',
        'company_name',
        'account_deductions',
        'address_company',
        'tipo_comprobante',
        'active',
        'adm',
        'tipo_agente',
        'actived_at',
        'fecha_renovacion',
        'estado_renovacion',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $useTimestamps = false;

    // begin extend model                                

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

        /**
    * Verifica si el agente externo tiene inscripción anual vigente
    * @param int $customer_id
    * @return bool
    */
        public function isInscripcionVigente($customer_id)
        {
        $data = $this->find($customer_id);
        if (!$data || ($data['tipo_agente'] ?? '') !== 'externo') {
        return true; // No aplica para internos o no existe
        }
        $fecha_renovacion = $data['fecha_renovacion'] ?? null;
        $estado_renovacion = $data['estado_renovacion'] ?? null;
        if (!$fecha_renovacion || $estado_renovacion !== 'vigente') {
        return false;
        }
        // Vigencia: menos de 1 año desde la fecha de renovación
        $fechaLimite = date('Y-m-d', strtotime($fecha_renovacion . ' +1 year'));
        return (date('Y-m-d') <= $fechaLimite); } 

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



    public function get_search_by_id($id){
        $obj_result =  $this->db->query("SELECT *  FROM customers WHERE customers.id = '$id'");
        return $obj_result->getRow();
    }

    public function get_search_by_username($code){
        $obj_result =  $this->db->query("SELECT * FROM customers WHERE customers.code = '$code'");
        return $obj_result->getRow();
    }

    public function get_search_by_name($name) {
        $obj_result =  $this->db->query("SELECT * FROM customers WHERE customers.name = '$name'");
        return $obj_result->getRow();
    }

    public function get_search_by_dni($dni){
        $obj_result =  $this->db->query("SELECT * FROM customers WHERE customers.dni = '$dni'");
        return $obj_result->getRow();
    }

    

    public function get_all_data($id){
    $obj_result =  $this->db->query("SELECT `customers`.`id`, `customers`.`code`, `customers`.`dni`, `customers`.`active`, `customers`.`avatar`, `customers`.`tipo_agente`, `ranges`.`id` AS range_id, `ranges`.`img` as range_img, `ranges`.`name`, memberships.name as membership_name, memberships.id as membership_id, memberships.img as membership_img,
                    (SELECT COUNT(*) FROM unilevels WHERE node LIKE '%,$id' OR node LIKE '%,$id,%') as total_team,
                    (SELECT COUNT(*) FROM unilevels JOIN customers ON unilevels.customer_id = customers.id WHERE customers.active = '1' AND (node LIKE '%,$id' OR node LIKE '%,$id,%')) as total_team_active,
                    (select count(*) FROM unilevels WHERE `unilevels`.`sponsor_id` = $id) as total_referred
                    FROM (customers) 
                    JOIN `ranges` ON `customers`.`range_id` = `ranges`.`id` 
                    JOIN `memberships` ON `customers`.`membership_id` = `memberships`.`id` 
                    WHERE `customers`.`id` = $id");
        return $obj_result->getRow();
    }

    public function get_data_button_search(){
        $obj_result =  $this->db->query("SELECT `customers`.`id`,`customers`.`dni` , `customers`.`code` , `customers`.`name`,`customers`.`lastname`
                                        FROM (customers) 
                                        WHERE `customers`.`id` <> 1
                                        ORDER BY `customers`.`name` ASC");
        return $obj_result->getResult();
    }

    public function get_data_username($username){
        $obj_result =  $this->db->query("SELECT * FROM (`customers`) 
                                        WHERE customers.username = '$username'");
        return $obj_result->getRow();
    }

    public function get_data_code($code){
        $obj_result =  $this->db->query("SELECT * FROM (`customers`) 
                                        WHERE customers.code = '$code'");
        return $obj_result->getRow();
    }

    public function get_data_by_id($id){
        $obj_result =  $this->db->query("SELECT * FROM (`customers`) 
                                        WHERE customers.id = $id");
        return $obj_result->getRow();
    }

    public function get_data_customer($id){
        $obj_result =  $this->db->query("SELECT customers.*, `bank`.id AS bank_id, `customer_bank`.id AS customer_bank_id, `customer_bank`.number , `customer_bank`.cci
                                        FROM (`customers`) 
                                        LEFT JOIN `customer_bank` ON customers.id = `customer_bank`.customer_id
                                        LEFT JOIN `bank` ON bank.id = `customer_bank`.bank_id
                                        WHERE customers.id = $id");
        return $obj_result->getRow();
    }

    public function get_data_customer_sponsor($id){
        $obj_result =  $this->db->query("SELECT unilevels.id as unilevel_id, customers.id AS customer_id, customers.name, customers.code, customers.lastname 
                                        FROM unilevels 
                                        JOIN customers ON unilevels.sponsor_id = customers.id
                                        WHERE unilevels.customer_id = $id");
        return $obj_result->getRow();
    }


    public function get_data_customer_perfil($id){
        $obj_result =  $this->db->query("SELECT `customers`.`id`, `customers`.`code`,`customers`.`ruc`, `customers`.`address`, `customers`.`code`, `customers`.`co_name`, `customers`.`co_dni`, `customers`.`tipo_comprobante`,`customers`.`avatar`,`customers`.`avatar`, `customers`.`email`, `customers`.`name`, `customers`.`lastname`, `customers`.`created_at`, `customers`.`phone`, `customers`.`dni`,`customers`.`actived_at`, `customers`.`active`, `countries`.`id` as country_id, `countries`.`nombre` as pais, `countries`.`id_wsp`, `countries`.`img` 
                                        FROM (`customers`) 
                                        JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 
                                        WHERE `customers`.`id` = $id and countries.id_idioma = 7");
        return $obj_result->getRow();
    }
    
    public function get_data_customer_range($id, $first_month_day, $last_month_day){
        $obj_result =  $this->db->query("SELECT `ranges`.`id` as range_id, `ranges`.`img`, `ranges`.`name` as range_name, `customers`.`id`, `customers`.`id` AS customer_id,`customers`.`avatar`, `customers`.`code`,`customers`.`email`, `customers`.`name`, `customers`.`lastname`,`countries`.`nombre` as pais,
                                        (SELECT sum(points) FROM points  WHERE customer_id = $id AND points.date >= '$first_month_day' AND points.date <= '$last_month_day' and active = '1') as total_point,
                                        (SELECT SUM(points) FROM invoices WHERE customer_id = $id AND invoices.date >= '$first_month_day 00:00:00' AND  invoices.date <= '$last_month_day 23:59:59' AND invoices.active = '2') as personal_point    
                                        FROM (`customers`) 
                                        JOIN `ranges` ON `customers`.`range_id` = `ranges`.`id` 
                                        JOIN `countries` ON `countries`.`id` = `customers`.`country_id` 
                                        WHERE `customers`.`id` = $id and countries.id_idioma = 7");
        return $obj_result->getRow();
    }
    
    public function get_all_customer_inactive(){
        $obj_result =  $this->db->query("SELECT `first_name`, `last_name`, `dni`, `customer_id` 
                                        FROM (`customer`) 
                                        WHERE `active` = 0");
        return $obj_result->getResult();
    }

    public function get_customer_by_kit(){
    $obj_result =  $this->db->query("SELECT `customers`.`id`, `customers`.`dni`, `customers`.`code`, `customers`.`ruc`,  `customers`.`name`, `customers`.`email`, `customers`.`lastname`, `customers`.`active`, `customers`.`civil_status`, `customers`.`tipo_agente`, countries.img, ranges.name as `range`
                    FROM (`customers`) 
                    JOIN ranges ON customers.range_id = ranges.id
                    JOIN countries ON customers.country_id = countries.id
                    WHERE countries.id_idioma = 7");
        return $obj_result->getResult();
    }

    public function get_customer_register($dni){
        $obj_result =  $this->db->query("SELECT `customers`.`id`, `customers`.`name`, `customers`.`lastname`, `customers`.`dni` FROM (`customers`) 
                                        WHERE `dni` = '$dni'");
        return $obj_result->getRow();
    }

    public function get_customer_active(){
        $obj_result =  $this->db->query("SELECT `customers`.`id`, `customers`.`active`, `customers`.`date_active` 
                                        FROM (`customers`) 
                                        WHERE `customers`.`id` NOT IN (1) AND customers.active = '1'");
        return $obj_result->getResult();
    }   
    
    public function get_customer_active_all(){
        $obj_result =  $this->db->query("SELECT `customers`.`id`, `customers`.`active`, `customers`.`range_id`, `customers`.`membership_id`, `customers`.`date_active`
                                        FROM (`customers`) 
                                        WHERE customers.active = '1' AND id <> 1");
        return $obj_result->getResult();
    } 
    
    public function get_customer_not_in_active($customer_ids){
        $obj_result =  $this->db->query("SELECT `customers`.`id` 
                                        FROM (`customers`) 
                                        WHERE `customers`.`id` NOT IN ($customer_ids) AND customers.active = '1'");
        return $obj_result->getResult();
    }    

    public function get_customer_by_export($where){
        $obj_result =  $this->db->query("SELECT `customers`.`id` AS id_customer, `customers`.`name`, `customers`.`lastname`,`customers`.`code`, `customers`.`dni`, `customers`.`email`, `customers`.`active`,ranges.name AS range_name, countries.nombre, countries.img,
                                        (SELECT CONCAT(customers.name ,' ', customers.lastname) FROM unilevels JOIN customers ON unilevels.sponsor_id = customers.id WHERE unilevels.customer_id = id_customer) AS sponsor_name
                                        FROM (`customers`) 
                                        JOIN ranges ON customers.range_id = ranges.id
                                        JOIN countries ON customers.country_id = countries.id
                                        WHERE $where");
        return $obj_result->getResult();
    }    
   

    public function get_customer_crone_range($first_previus_day, $last_previus_day){
        $obj_result =  $this->db->query("SELECT `customers`.`id`,`customers`.`range_id`,`customers`.`active`, SUM(`points`.`points`) AS points
                                        FROM (`customers`) 
                                        JOIN `points` ON `points`.`customer_id` = `customers`.`id` 
                                        WHERE `points`.`date` >= '$first_previus_day 00:00:00' AND `points`.`date` <= '$last_previus_day 23:59:59' AND `customers`.`active` = '1'
                                        GROUP BY `customers`.`id`
                                        ORDER BY `customers`.`id` DESC");
        return $obj_result->getResult();
    }

    public function get_customer_crone_range_id($customer_id, $first_previus_day, $last_previus_day){
        $obj_result =  $this->db->query("SELECT `customers`.`id`,`customers`.`range_id`,`customers`.`active`, SUM(`points`.`points`) AS points
                                        FROM (`customers`) 
                                        JOIN `points` ON `points`.`customer_id` = `customers`.`id` 
                                        WHERE `customers`.`id` = $customer_id AND `points`.`date` >= '$first_previus_day 00:00:00' AND `points`.`date` <= '$last_previus_day 23:59:59' AND `customers`.`active` = '1'
                                        GROUP BY `customers`.`id`
                                        ORDER BY `customers`.`id` DESC");
        return $obj_result->getResult();
    }

    



    public function comisiones_by_system(){
        $obj_result =  $this->db->query("SELECT `commissions`.`id`, `customers`.`id` AS customer_id, `customers`.`code`, `customers`.`name`, `customers`.`lastname`, `commissions`.`amount`, `commissions`.`date`, `commissions`.`created_at`,`commissions`.`active`, `bonuses`.`id` AS bonus_id 
                                        FROM (`customers`) 
                                        JOIN `commissions` ON `customers`.`id` = `commissions`.`customer_id` 
                                        JOIN `bonuses` ON `commissions`.`bonus_id` = `bonuses`.`id` 
                                        WHERE `bonuses`.`id` = 3 and `commissions`.`system_discount` = 1");
        return $obj_result->getResult();
    }

    public function comisiones_by_system_id($id){
        $obj_result =  $this->db->query("SELECT `commissions`.`id`, `customers`.`id` AS customer_id, `customers`.`code`, `customers`.`name`, `customers`.`lastname`, `customers`.`dni`, `commissions`.`amount`, `commissions`.`date`, `commissions`.`active`, `bonuses`.`id` AS bonus_id 
                                        FROM (`customers`) 
                                        JOIN `commissions` ON `customers`.`id` = `commissions`.`customer_id` 
                                        JOIN `bonuses` ON `commissions`.`bonus_id` = `bonuses`.`id` 
                                        WHERE commissions.id = $id");
        return $obj_result->getRow();
    }

    public function comisiones_by_discount(){
        $obj_result =  $this->db->query("SELECT `commissions`.`commissions_id`, `customer`.`customer_id`, `customer`.`code`, `customer`.`first_name`, `customer`.`last_name`, `commissions`.`amount`, `commissions`.`date`, `commissions`.`active`, `bonus`.`bonus_id` 
                                        FROM (`customer`) 
                                        JOIN `commissions` ON `customer`.`customer_id` = `commissions`.`customer_id` 
                                        JOIN `bonus` ON `commissions`.`bonus_id` = `bonus`.`bonus_id` 
                                        WHERE commissions.discount_system = 1");
        return $obj_result->getResult();
    }

  
    public function get_point_ranges_by_customer_by_id($id){
        $obj_result =  $this->db->query("SELECT `points_binary`.`id`, `customers`.`id` as customer_id,`customers`.`code`, `customers`.`name`, `customers`.`lastname`, `customers`.`dni`, `points_binary`.`left`, `points_binary`.`right`, `points_binary`.`date`, `points_binary`.`active` 
                                        FROM (`customers`) 
                                        JOIN `points_binary` 
                                        ON `points_binary`.`customer_id` = `customers`.`id` 
                                        WHERE `points_binary`.`id` = $id and points_binary.range = '1'");
        return $obj_result->getRow();
    }


    public function get_all_panel($year, $first_month, $today, $ene, $feb, $mar, $abr ,$may, $jun, $jul, $ago, $set, $oct, $nov, $dic){
        $obj_result =  $this->db->query("SELECT sum(amount) as total_invest,
                                    (select count(*) from customers WHERE id <> 1) as total_customer, 
                                    (select count(*) from customers where active = 1) as total_customer_active, 
                                    (select count(*) from suggestions) as total_suggestions, 
                                    (select sum(amount) from pays where active = 2) as total_pagos, 
                                    (select sum(amount) from invoices where date >= '$year-01-01 00:00:00' and date < '$ene 23:59:59' and invoices.active = '2') as total_ene, 
                                    (select sum(amount) from invoices where date >= '$year-02-01 00:00:00' and date < '$feb 23:59:59' and invoices.active = '2') as total_feb, 
                                    (select sum(amount) from invoices where date >= '$year-03-01 00:00:00' and date < '$mar 23:59:59' and invoices.active = '2') as total_mar, 
                                    (select sum(amount) from invoices where date >= '$year-04-01 00:00:00' and date < '$abr 23:59:59' and invoices.active = '2') as total_abr, 
                                    (select sum(amount) from invoices where date >= '$year-05-01 00:00:00' and date < '$may 23:59:59' and invoices.active = '2') as total_may, 
                                    (select sum(amount) from invoices where date >= '$year-06-01 00:00:00' and date < '$jun 23:59:59' and invoices.active = '2') as total_jun, 
                                    (select sum(amount) from invoices where date >= '$year-07-01 00:00:00' and date < '$jul 23:59:59' and invoices.active = '2') as total_jul,
                                    (select sum(amount) from invoices where date >= '$year-08-01 00:00:00' and date < '$ago 23:59:59' and invoices.active = '2') as total_ago, 
                                    (select sum(amount) from invoices where date >= '$year-09-01 00:00:00' and date < '$set 23:59:59' and invoices.active = '2') as total_set, 
                                    (select sum(amount) from invoices where date >= '$year-10-01 00:00:00' and date < '$oct 23:59:59' and invoices.active = '2') as total_oct, 
                                    (select sum(amount) from invoices where date >= '$year-11-01 00:00:00' and date < '$nov 23:59:59' and invoices.active = '2') as total_nov, 
                                    (select sum(amount) from invoices where date >= '$year-12-01 00:00:00' and date < '$dic 23:59:59' and invoices.active = '2') as total_dic, 
                                    (select count(*) from tickets where active = '1' or active = '2') as total_ticket_pending,
                                    (select sum(amount) from invoices where active = '1') as total_invoice_pending,
                                    (select sum(amount) from invoices where active = '2' and invoices.date >= '$today 00:00:00' and invoices.date <= '$today 23:59:59') as sale_today,
                                    (select count(*) from invoices where active = '2' and invoices.delivery = '1') as pending_delivery,
                                    (select count(*) from invoices where active = '1' and payment = '3') as total_invoice_compra_tienda,
                                    (select count(*) from kycs where active = '1') as total_kyc_pending,
                                    (select count(*) from comments where active = '1') as total_comments_pending,
                                    (select count(*) from pays where active = '1') as total_pay_pending,
                                    (select count(*) from range_customer WHERE date >= '$first_month') as total_new_range
                                    FROM (`invoices`) 
                                    WHERE invoices.active = '2'");
            if ($obj_result === false) {
                log_message('error', 'Error en la consulta SQL en CustomerModel->get_all_panel');
                return null;
            }
            return $obj_result->getRow();
    }
    
    public function get_customer_by_membership_id($id){
        $obj_result =  $this->db->query("SELECT `customers`.`id`,`customers`.`code`,`customers`.`phone`,`customers`.`avatar` as img,`customers`.`dni`,`customers`.`pay`,`customers`.`name`, `customers`.`email`,`customers`.`avatar`, `customers`.`lastname`, `customers`.`membership_id`, `customers`.`created_at`, `customers`.`active`, `countries`.`nombre` as pais,`countries`.`img`,
                                        (select sponsor_id from unilevels WHERE customer_id = $id) as sponsor_id 
                                        FROM (`customers`) 
                                        JOIN `countries` ON `countries`.`id` = `customers`.`country_id` 
                                        WHERE `customers`.`id` = $id AND countries.id_idioma = 7");
        return $obj_result->getRow();
    }

    public function get_customer_unilevel($node){
        $obj_result =  $this->db->query("SELECT customers.id , customers.range_id, customers.active FROM customers
                                        WHERE id IN ($node)
                                        ORDER BY customers.id DESC
                                        LIMIT 10
                                        ");
        return $obj_result->getResult();
    }

    public function get_customer_active_unilevel($node){
        $obj_result =  $this->db->query("SELECT customers.id, customers.range_id, customers.active FROM customers
                                        WHERE customers.active = '1' AND id IN ($node)
                                        ORDER BY customers.id DESC
                                        LIMIT 10
                                        ");
        return $obj_result->getResult();
    }
    

    public function get_customer_unilevel_in_id($node){
        $obj_result =  $this->db->query("SELECT customers.id, customers.range_id, customers.active, customers.membership_id  FROM customers
                                        WHERE id IN ($node)
                                        ORDER BY customers.id DESC
                                        LIMIT 10
                                        ");
        return $obj_result->getResult();
    }

    public function get_customer_data_unilevel_in_id($node){
        $obj_result =  $this->db->query("SELECT customers.id, customers.range_id, customers.active, customers.membership_id  FROM customers
                                        WHERE id IN ($node)
                                        ORDER BY customers.id DESC
                                        ");
        return $obj_result->getResult();
    }

    //get total directs by sponsor
    public function get_directs_by_sponsor($id) {
        $obj_result =  $this->db->query("SELECT u.customer_id
                                    FROM unilevels as u
                                    WHERE u.sponsor_id = $id AND 1 = 
                                    (SELECT active FROM customers as c WHERE c.id = u.customer_id)");

        return $obj_result->getResult();
    }

    public function get_point_by_direct($customer_id) {
        $obj_result = $this->db->query("SELECT SUM(points) as points FROM invoices WHERE customer_id = $customer_id");

        return $obj_result->getRow();
    }

    public function validate_min_points_direct($obj_directos, $points, $max_points) {
        $cant_directs = count($obj_directos);
        $min_point = $points / $cant_directs;
        $total_point = 0;
        $validate = false;
        foreach ($obj_directos as $row => $value) {
            $customer_id = $value->customer_id;
            $point_by_direct = $this->get_point_by_direct($customer_id);
            if ($point_by_direct->points >= $max_points) {
                $total_point += $max_points;
            } else {
                $total_point += $point_by_direct->points;
            }
        }

        if ($total_point >= $points) {
            $validate = true;
        }

        return $validate;
    }

    //validate new range
    public function validate_new_range($sponsor_id, $range, $customer_id = null, $invoice_id = null, $key = null, $membership_id = null) 
    {
        $Customer = new CustomerModel();
        //set date period
        //get dat 1 -31
        $day = date("j");
        $year = date("Y");
        $month = date("m");
        if($day >= '1' && $day <= '15'){
            $first_month_day = first_month_day($month,$year);
            $last_month_day = "$year-$month-15";    
        }else{
            $first_month_day = "$year-$month-16" ;
            $last_month_day = last_month_day($month,$year);    
        }
        
        //unilevel
        $Unilevel = new UnilevelsModel();
        $obj_group_points = $Unilevel->get_data_by_customer($sponsor_id, $first_month_day, $last_month_day); 
        $obj_directos = $this->get_directs_by_sponsor($sponsor_id);

        if ($range == "1") {
            if (count($obj_directos) >= 2) {
                $validate_min_points = $this->validate_min_points_direct($obj_directos, 80, 300);
                if ($validate_min_points) {
                    if ($obj_group_points->point_grupal >= "80") {
                        $new_range = $range + 1;
                        $Customer->update_range_by_customer($sponsor_id, $new_range);
                        $this->insert_customer_range($sponsor_id, $new_range);
                    }
                }
            }
        }

        if ($range == "2") {
            if (count($obj_directos) >= 2) {
                $validate_min_points = $this->validate_min_points_direct($obj_directos, 1600, 800);
                if ($validate_min_points) {
                    if ($obj_group_points->point_grupal >= "1600") {
                        $new_range = $range + 1;
                        $Customer->update_range_by_customer($sponsor_id, $new_range);
                        $amount = 100;
                        $this->get_comission_first_time($sponsor_id, $key, $invoice_id, $customer_id, $amount, $new_range, $membership_id);
                        $this->insert_customer_range($sponsor_id, $new_range);
                    }
                }
            }
        }

        if ($range == "3") {
            if (count($obj_directos) >= 2) {
                $validate_min_points = $this->validate_min_points_direct($obj_directos, 4000, 2000);
                if ($validate_min_points) {
                    if ($obj_group_points->point_grupal >= "4000") {
                        $new_range = $range + 1;
                        $Customer->update_range_by_customer($sponsor_id, $new_range);
                        $amount = 250;
                        $this->get_comission_first_time($sponsor_id, $key, $invoice_id, $customer_id, $amount, $new_range, $membership_id);
                        $this->insert_customer_range($sponsor_id, $new_range);
                    }
                }
            }
        }

        if ($range == "4") {
            if (count($obj_directos) >= 2) {
                $validate_min_points = $this->validate_min_points_direct($obj_directos, 10000, 5000);
                if ($validate_min_points) {
                    if ($obj_group_points->point_grupal >= "10000") {
                        $new_range = $range + 1;
                        $Customer->update_range_by_customer($sponsor_id, $new_range);
                        $amount = 500;
                        $this->get_comission_first_time($sponsor_id, $key, $invoice_id, $customer_id, $amount, $new_range, $membership_id);
                        $this->insert_customer_range($sponsor_id, $new_range);
                    } 
                }
            }
        }

        if ($range == "5") {
            if (count($obj_directos) >= 3) {
                $validate_min_points = $this->validate_min_points_direct($obj_directos, 18000, 6000);
                if ($validate_min_points) {
                    if ($obj_group_points->point_grupal >= 18000) {
                        $new_range = $range + 1;
                        $Customer->update_range_by_customer($sponsor_id, $new_range);
                        $amount = 1000;
                        $this->get_comission_first_time($sponsor_id, $key, $invoice_id, $customer_id, $amount, $new_range, $membership_id);
                        $this->insert_customer_range($sponsor_id, $new_range);
                    }
                }
            }
        }

        if ($range == "6") {
            if (count($obj_directos) >= "3") {
                $validate_min_points = $this->validate_min_points_direct($obj_directos, 30000, 10000);
                if ($validate_min_points) {
                    if ($obj_group_points->point_grupal >= 30000) {
                        $new_range = $range + 1;
                        $Customer->update_range_by_customer($sponsor_id, $new_range);
                        $amount = 2000;
                        $this->get_comission_first_time($sponsor_id, $key, $invoice_id, $customer_id, $amount, $new_range, $membership_id);
                        $this->insert_customer_range($sponsor_id, $new_range);
                    }
                }
            }
        }

        if ($range == "7") {
            if (count($obj_directos) >= "4") {
                $validate_min_points = $this->validate_min_points_direct($obj_directos, 50000, 12500);
                if ($validate_min_points) {
                    if ($obj_group_points->point_grupal >= 50000) {
                        $new_range = $range + 1;
                        $Customer->update_range_by_customer($sponsor_id, $new_range);
                        $amount = 4000;
                        $this->get_comission_first_time($sponsor_id, $key, $invoice_id, $customer_id, $amount, $new_range, $membership_id);
                        $this->insert_customer_range($sponsor_id, $new_range);
                    }
                }
            }
        }

    }

    public function insert_customer_range($sponsor_id, $new_range) {
        $RangeCustomer = new Range_customerModel();
        $Period = new PeriodModel();
        $obj_period = $Period->get_last();

        $params = [
            'customer_id' => $sponsor_id,
            'range_id' => $new_range,
            'date' => date('Y-m-d'),
            'period_id' => $obj_period->id
        ];

        $RangeCustomer->insert($params);
    }

    public function get_data_customer_pin($id, $pin){
        $obj_result =  $this->db->query("SELECT * FROM (`customers`) WHERE `id` = $id AND pin = '$pin'");
        return $obj_result->getResult();
    }

    public function get_data_customer_email_pin($id, $pin){
        $obj_result =  $this->db->query("SELECT * FROM (`customers`) WHERE `customer_id` = '$id' AND pin = '$pin'");
        return $obj_result->getNumRows();
    }
    
    public function update_all_range(){
        $obj_result =  $this->db->query("UPDATE customers SET range_id = 1");
        return $obj_result;
    }

    public function update_range_by_customer($id, $range_id){
        $obj_result =  $this->db->query("UPDATE customers SET range_id = $range_id WHERE id = $id");
        return $obj_result;
    }

    public function validate_comission_first_time($sponsor_id, $amount) {
        $obj_result =  $this->db->query("SELECT * FROM commissions WHERE customer_id = $sponsor_id AND bonus_id = 9 AND amount = $amount");
        return $obj_result;
    }

    public function get_comission_first_time($sponsor_id, $key, $invoice_id, $customer_id, $amount, $range, $membership_id) {
        $Commissions = new CommissionsModel();
        $RangePeriod = new Range_customerModel();
        //commission for range plata first time
        // validacion_perido si obtuvo la comision
        $validate = $RangePeriod->get_range_by_customer($sponsor_id, $range, 1);

        if ($validate) {
            return;
        } 
        
        if ($membership_id >= "3") {
            $param = array(
                'customer_id' => $sponsor_id,
                'level' => $key,
                'invoice_id' => $invoice_id,
                'bonus_id' => 9,
                'arrive_id' => $customer_id,
                'date' => date("Y-m-d H:i:s"),
                'amount' => $amount,
                'active' => '1',
                'created_at' => date("Y-m-d H:i:s")
            );
    
            $Commissions->insertar($param);
        }
        
    }

    public function insertar($data){
        $query = $this->db->table('customers');
        $query->insert($data);
        return $this->db->insertId();
    }

    public function eliminar($id){
        return $this->db->query("DELETE FROM $this->table WHERE id = $id");
    }
}