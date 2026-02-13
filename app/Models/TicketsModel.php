<?php

namespace App\Models;

use CodeIgniter\Model;



class TicketsModel extends Model{

    

    protected $table      = 'tickets';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'concept_ticket_id', 'customer_id', 'content', 'response', 'date', 'img', 'active'];

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


    public function get_ticket_all_customer($id){

        $obj_result =  $this->db->query("SELECT `tickets`.`id`, `tickets`.`concept_ticket_id`, `concept_tickets`.`title`, `tickets`.`response`, `tickets`.`date`, `tickets`.`content`, `tickets`.`active` 

                                        FROM (`tickets`) 

                                        JOIN `concept_tickets` ON `tickets`.`concept_ticket_id` = `concept_tickets`.`id` 

                                        WHERE `customer_id` = $id ORDER BY `tickets`.`id` DESC");

        return $obj_result->getResult();

    }



    public function get_data(){

        $obj_result =  $this->db->query("SELECT `tickets`.`id`, `tickets`.`concept_ticket_id`, `concept_tickets`.`title`, `customers`.`code`, `customers`.`name`, `customers`.`lastname`, `tickets`.`img`, `tickets`.`response`, `tickets`.`date`, `tickets`.`content`, `tickets`.`active` 

                                        FROM (`tickets`) 

                                        JOIN `concept_tickets` ON `tickets`.`concept_ticket_id` = `concept_tickets`.`id` 

                                        JOIN `customers` ON `tickets`.`customer_id` = `customers`.`id` 

                                        ORDER BY `tickets`.`id` DESC");

        return $obj_result->getResult();

    }

    

    public function get_data_by_id($id){

        $obj_result =  $this->db->query("SELECT `tickets`.`id`, `tickets`.`concept_ticket_id`, `concept_tickets`.`title`, `customers`.`name`, `customers`.`code`, `customers`.`lastname`, `tickets`.`img`, `tickets`.`response`, `tickets`.`date`, `tickets`.`content`, `tickets`.`active` 

                                        FROM (`tickets`) 

                                        JOIN `concept_tickets` ON `tickets`.`concept_ticket_id` = `concept_tickets`.`id` 

                                        JOIN `customers` ON `tickets`.`customer_id` = `customers`.`id` 

                                        WHERE `tickets`.`id` = $id");

        return $obj_result->getRow();

    }



    public function insertar($data){

        $obj_ticket = $this->db->table('tickets');

        $obj_ticket->insert($data);

        return $this->db->insertId();

    }



    public function eliminar($id){

        return $this->db->query("DELETE FROM tickets WHERE id = $id");

    }

}