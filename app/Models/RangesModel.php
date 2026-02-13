<?php

namespace App\Models;

use CodeIgniter\Model;



class RangesModel extends Model{

    

    protected $table      = 'ranges';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useSoftDeletes = true;

    protected $allowedFields = [

        'name', 

        'points', 

        'description', 

        'img', 

        'active', 

        'created_by', 

        'updated_by'

    ];



    protected $useTimestamps = false;

    protected $createdField  = 'created_at';

    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];

    protected $validationMessages = [];

    protected $skipValidation     = true;


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

        $obj_kit =  $this->db->query("SELECT `ranges`.`id`, `ranges`.`name`, `ranges`.`points`, `ranges`.`description`, `ranges`.`img` , `ranges`.`active` 

                                        FROM (`ranges`) 

                                        WHERE ranges.id > 0 AND ranges.active = '1' ORDER BY `id` ASC");

        return $obj_kit->getResult();

    }



    public function get_all_data(){

        $obj_kit =  $this->db->query("SELECT `ranges`.`id`, `ranges`.`name`, `ranges`.`points`, `ranges`.`img` 

                                    FROM (`ranges`) 

                                    ORDER BY `id` ASC");

        return $obj_kit->getResult();

    }



    public function get_all_crud(){

        $obj_kit =  $this->db->query("SELECT * FROM (`ranges`)");

        return $obj_kit->getResult();

    }



    public function get_all_by_id($id){

        $obj_kit =  $this->db->query("SELECT * FROM (`ranges`) WHERE id = $id");

        return $obj_kit->getRow();

    }



    public function get_range_by_customer(){

        $obj_kit =  $this->db->query("SELECT customer.customer_id, customer.first_name, customer.last_name, customer.username,customer.active, ranges.range_id, ranges.name, ranges.point_grupal FROM (`customer`)

                                    JOIN ranges

                                    ON customer.range_id = ranges.range_id

                                    WHERE customer.range_id > 0");

        return $obj_kit->getResult();

    }



    public function get_range_next($id){

        $obj_kit =  $this->db->query("SELECT `ranges`.`id`, `ranges`.`name`, `ranges`.`img`, `ranges`.`points` as point, 

                                    (select name FROM ranges WHERE points > point LIMIT 1) as next_range_name,

                                    (SELECT count(*) FROM unilevels JOIN customers ON unilevels.customer_id = customers.id WHERE customers.active = '1' AND node LIKE '%,$id,%') as total_team_active, 

                                    (select points FROM ranges WHERE points > point LIMIT 1) as next_range_point 

                                    FROM (`customers`) JOIN `ranges` ON `customers`.`range_id` = `ranges`.`id` 

                                    WHERE `customers`.`id` = $id");

        return $obj_kit->getRow();

    }



    public function insertar($data){

        $obj_comments = $this->db->table('ranges');

        $obj_comments->insert($data);

        return $this->db->insertId();

    }



    public function eliminar($id){

        return $this->db->query("DELETE FROM ranges WHERE id = $id");

    }

    

}