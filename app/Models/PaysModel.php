<?php
namespace App\Models;
use CodeIgniter\Model;

class PaysModel extends Model{
    
    protected $table      = 'pays';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id',
                                'customer_id', 
                                'date',  
                                'date_pay',  
                                'hash_id',  
                                'amount',  
                                'discount',  
                                'bank',  
                                'number',  
                                'cci',  
                                'total',  
                                'active'
                                ];
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
            $obj_kit =  $this->db->query("select * from pays");
            return $obj_kit->getResult();
    }

    public function get_search_by_id($id){
        $obj_result =  $this->db->query("SELECT pays.date, pays.amount, pays.id, pays.created_at, pays.discount, pays.active, customers.pay , customers.name, customers.lastname, customers.code
                                        FROM pays 
                                        JOIN customers
                                        ON pays.customer_id = customers.id
                                        WHERE pays.customer_id = $id
                                        ORDER BY pays.id DESC");
        return $obj_result->getResult();
    }

    public function comision_disponible($id){
        $obj_data =  $this->db->query("SELECT sum(amount) as total_comissions,
                                       (SELECT sum(amount) FROM commissions WHERE customer_id = $id and bonus_id <> 3) as total_disponible
                                       FROM commissions
                                       WHERE customer_id = $id and active = 1 and bonus_id <> 9 and bonus_id <> 3");
        return $obj_data->getRow();
    }

    public function get_data_by_customer(){
        $obj_data =  $this->db->query("SELECT `pays`.`id`, `pays`.`date`, `pays`.`amount`, `pays`.`discount`, `pays`.`total`, `pays`.`active`, `customers`.`id` AS customer_id, `customers`.`name`, `customers`.`code`, `customers`.`lastname` 
                                        FROM (`pays`) JOIN `customers` ON `pays`.`customer_id` = `customers`.`id` 
                                        ORDER BY `pays`.`id` DESC");
        return $obj_data->getResult();
    }

    public function get_pay($id){
        $db = \Config\Database::connect();
        $builder = $db->table('pays');
        $builder->select('pays.*, customers.name, customers.lastname, customers.dni, customers.code');
        $builder->join('customers', 'customers.id = pays.customer_id');
        $builder->where('pays.id', $id);
        $query = $builder->get();
        return $query->getRow();
    }

    public function get_data_by_customer_id($id){
        $obj_data =  $this->db->query("SELECT `pays`.`id`, `pays`.`amount`, `pays`.`discount`, `pays`.`total`, `pays`.`date`,`pays`.`hash_id`,`pays`.`active`, `pays`.`customer_id` AS customer_id, `customers`.`name`, `customers`.`lastname`, `customers`.`code` 
                                        FROM (`pays`) 
                                        JOIN `customers` ON `pays`.`customer_id` = `customers`.`id` 
                                        WHERE `pays`.`id` = $id");
        return $obj_data->getRow();
    }

    public function get_crud_pay(){
        $obj_data =  $this->db->query("SELECT `pays`.`id`, `pays`.`date`,`pays`.`date_pay`, `pays`.`amount`,`pays`.`bank`,`pays`.`number`, `pays`.`cci`,`pays`.`discount`, `pays`.`total`, `pays`.`hash_id`, `pays`.`active`, `customers`.`id` AS customer_id, `customers`.`code`, `customers`.`name`, `customers`.`email`, `countries`.`nombre` as pais,`countries`.`img`, `customers`.`lastname` 
                                        FROM (`pays`) 
                                        JOIN `customers` ON `pays`.`customer_id` = `customers`.`id` 
                                        JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 
                                        WHERE `countries`.`id_idioma` = 7 ORDER BY `pays`.`id` DESC");
        return $obj_data->getResult();
    }

    public function get_pending_pay(){
        $obj_data =  $this->db->query("SELECT sum(amount) as pending_total_pay FROM (`pays`) WHERE `active` = '1'");
        return $obj_data->getResult();
    }

    public function get_data_by_export($where){
        $obj_data =  $this->db->query("SELECT `pays`.`id`, `pays`.`date`,`pays`.`date_pay`, `pays`.`amount`,`pays`.`bank`,`pays`.`number`, `pays`.`cci`,`pays`.`discount`, `pays`.`total`, `pays`.`hash_id`, `pays`.`active`, `customers`.`id` AS customer_id, `customers`.`name`, `customers`.`code`, `customers`.`email`, `countries`.`nombre` as pais,`countries`.`img`, `customers`.`lastname` 
                                        FROM (`pays`) 
                                        JOIN `customers` ON `pays`.`customer_id` = `customers`.`id` 
                                        JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 
                                        WHERE $where");
        return $obj_data->getResult();
    }


    public function insertar($data){
        $query = $this->db->table('pays');
        $query->insert($data);
        return $this->db->insertId();
    }

    public function eliminar($id){
        return $this->db->query("DELETE FROM pays WHERE id = $id");
    }

    public function update_status_pay(){
        $id = $_POST['id'];
        $active = $_POST['active'];

        $db = \Config\Database::connect();
        $builder = $db->table('pays');
        $builder->where('id', $id);
        $builder->update(['active' => $active]);
    }
}