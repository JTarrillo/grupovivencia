<?php

namespace App\Models;

use CodeIgniter\Model;



class RechargeModel extends Model{

    

    protected $table      = 'recharge';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'customer_id', 'amount', 'transfer_id' , 'date', 'active'];

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

        $obj_result =  $this->db->query("SELECT `invoices`.`invoice_id`, `invoices`.`date`, `invoices`.`img`, `invoices`.`financy`, `customer`.`customer_id`, `customer`.`username`, `customer`.`first_name`, `customer`.`last_name`, `kit`.`kit_id`, `kit`.`price`, `kit`.`name`, `invoices`.`active` FROM (`invoices`) JOIN `kit` ON `invoices`.`kit_id` = `kit`.`kit_id` JOIN `customer` ON `invoices`.`customer_id` = `customer`.`customer_id` WHERE `invoices`.`type` = 1 and invoices.status_value = 1 ORDER BY `invoices`.`invoice_id` ASC");

        return $obj_result->getResult();

    }



    public function get_data_by_id($id){

        $obj_result =  $this->db->query("SELECT recharge.id,recharge.transfer_id, customers.id AS customer_id, customers.username,customers.name, customers.lastname, amount, recharge.date, recharge.active

                                        FROM recharge 

                                        JOIN customers ON recharge.customer_id = customers.id 

                                        WHERE recharge.id = $id");

        return $obj_result->getRow();

    }



    public function get_data_customer_id($id){

        $obj_result =  $this->db->query("SELECT recharge.id, customers.id AS customer_id, customers.name, customers.lastname, amount, recharge.date, recharge.active

                                        FROM recharge 

                                        JOIN customers ON recharge.customer_id = customers.id 

                                        WHERE customer_id = $id 

                                        ORDER BY recharge.id DESC");

        return $obj_result->getResult();

    }



    public function get_data_pending(){

        $obj_result =  $this->db->query("SELECT recharge.id, customers.id AS customer_id, customers.name, customers.email, customers.username, customers.lastname, amount, recharge.date, recharge.active, recharge.transfer_id, `countries`.`nombre` as pais,`countries`.`img`

                                        FROM recharge 

                                        JOIN customers ON recharge.customer_id = customers.id 

                                        JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 

                                        WHERE recharge.active = '1' and `countries`.`id_idioma` = 7");

        return $obj_result->getResult();

    }

    

    public function get_data_completed(){

        $obj_result =  $this->db->query("SELECT recharge.id, customers.id AS customer_id, customers.name, customers.username, customers.lastname, amount, recharge.date, recharge.active, recharge.transfer_id, `countries`.`nombre` as pais,`countries`.`img`

                                        FROM recharge 

                                        JOIN customers ON recharge.customer_id = customers.id 

                                        JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 

                                        WHERE `countries`.`id_idioma` = 7 and recharge.active = '2' or recharge.active = '3' and `countries`.`id_idioma` = 7");

        return $obj_result->getResult();

    }



    

    public function insertar($data){

        $obj_comments = $this->db->table('recharge');

        $obj_comments->insert($data);

        return $this->db->insertId();

    }



    public function eliminar($id){

        return $this->db->query("DELETE FROM recharge WHERE id = $id");

    }

}