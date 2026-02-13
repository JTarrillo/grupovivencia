<?php

namespace App\Models;

use CodeIgniter\Model;



class KycModel extends Model{

    

    protected $table      = 'kycs';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'customer_id', 'date', 'anverso', 'reverso','active'];

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

        $obj_result =  $this->db->query("SELECT * FROM (`kyc`)");

        return $obj_result->getResult();

    }



    public function verify_customer_id_kyc($id){

        $obj_result =  $this->db->query("SELECT id FROM kycs

                                         WHERE customer_id = $id");

        //get only 1 row

        return $obj_result->getRow();

    }



    public function get_by_id($id){

        $obj_result =  $this->db->query("SELECT *  FROM kycs

                                         WHERE id = $id");

        return $obj_result->getResult();

    }



    public function get_customer_kyc(){

        $obj_result =  $this->db->query("SELECT `customers`.`id`,`kycs`.`id` as kyc_id, `customers`.`username`, `customers`.`name`, `customers`.`lastname`, `customers`.`email`, `customers`.`dni`, `customers`.`phone`, `customers`.`kyc`, `kycs`.`anverso`, `kycs`.`reverso`, `kycs`.`date`,  `countries`.`nombre` as pais,`countries`.`img` 

                                        FROM (`customers`)   

                                        JOIN `kycs` ON `kycs`.`customer_id` = `customers`.`id` 

                                        JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 

                                        WHERE `customers`.`kyc` = '1' and `countries`.`id_idioma` = 7");

        return $obj_result->getResult();

    }

    

    public function get_customer_kyc_verify(){

        $obj_result =  $this->db->query("SELECT `customers`.`id`,`kycs`.`id` as kyc_id, `customers`.`username`, `customers`.`name`, `customers`.`lastname`, `customers`.`email`, `customers`.`dni`, `customers`.`phone`, `customers`.`kyc`, `kycs`.`anverso`, `kycs`.`reverso`, `kycs`.`date`,   `countries`.`nombre` as pais,`countries`.`img`

                                            FROM (`customers`) 

                                            JOIN `kycs` ON `kycs`.`customer_id` = `customers`.`id` 

                                            JOIN `countries` ON `customers`.`country_id` = `countries`.`id` 

                                            WHERE `customers`.`kyc` = '2' and `countries`.`id_idioma` = 7");

        return $obj_result->getResult();

    }



    public function insertar($data){

        $obj_comments = $this->db->table('kycs');

        $obj_comments->insert($data);

        return $this->db->insertId();

    }

}