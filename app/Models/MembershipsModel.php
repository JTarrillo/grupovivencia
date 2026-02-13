<?php

namespace App\Models;

use CodeIgniter\Model;

class MembershipsModel extends Model
{

    protected $table      = 'memberships';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['id', 'name', 'slug', 'img', 'qty',  'unit_cost', 'price', 'contable', 'public_price', 'point', 'sale', 'description', 'active', 'created_at', 'updated_at'];
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
        // Si el select contiene subconsultas, usar $this->db->query()
        if (isset($data["select"]) && strpos($data["select"], "SELECT") !== false) {
            $sql = "SELECT " . $data["select"] . " FROM memberships WHERE " . $data["where"];
            if (isset($data["order"]) && $data["order"] != "") {
                $sql .= " ORDER BY " . $data["order"];
            }
            if (isset($data["limit"]) && $data["limit"] != "") {
                $sql .= " LIMIT " . $data["limit"];
            }
            $query = $this->db->query($sql);
            if ($query === false) {
                log_message('error', 'Error en la consulta SQL en search: ' . $sql);
                return [];
            }
            return $query->getResult();
        } else {
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
            if ($query === false) {
                log_message('error', 'Error en la consulta SQL en search: ' . json_encode($data));
                return [];
            }
            return $query->getResult();
        }
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
    

    public function get_all()
    {
        $obj_kit =  $this->db->query("select * from $this->table ORDER BY price ASC");
        if ($obj_kit !== false) {
            return $obj_kit->getResult();
        } else {
            return [];
        }
    }

    public function get_all_membership()
    {
        $obj_kit =  $this->db->query("SELECT * FROM $this->table WHERE `active` = '1' ORDER BY price ASC");
        if ($obj_kit !== false) {
            return $obj_kit->getResult();
        } else {
            return [];
        }
    }

    public function get_all_countable()
    {
        $obj_kit =  $this->db->query("SELECT * FROM $this->table WHERE `active` = '1' and `contable` = '1' ORDER BY price ASC");
        if ($obj_kit !== false) {
            return $obj_kit->getResult();
        } else {
            return [];
        }
    }

    public function get_new_countable()
    {
        $obj_kit =  $this->db->query("SELECT * FROM $this->table WHERE `active` = '1' and `contable` = '1' ORDER BY id DESC LIMIT 4");
        if ($obj_kit !== false) {
            return $obj_kit->getResult();
        } else {
            return [];
        }
    }

    public function get_all_by_id($id)
    {
        $obj_kit =  $this->db->query("SELECT * from $this->table WHERE id = $id");
        return $obj_kit->getRow();
    }

    public function get_data_by_name($name)
    {
        $obj_kit =  $this->db->query("SELECT * from $this->table WHERE name like '%$name%'");
        return $obj_kit->getRow();
    }

    public function get_data_slug($slug)
    {
        $obj_kit =  $this->db->query("SELECT * from $this->table WHERE slug = '$slug'");
        return $obj_kit->getRow();
    }

    public function get_data_related($slug)
    {
        $obj_kit =  $this->db->query("SELECT * from $this->table WHERE slug <> '$slug' and active = '1' and `contable` = '1' 
                                      ORDER BY price ASC");
        if ($obj_kit !== false) {
            return $obj_kit->getResult();
        } else {
            return [];
        }
    }

    public function get_data_countable_adm($contable)
    {
        $obj_kit =  $this->db->query("SELECT * from $this->table 
                                      WHERE `contable` = '$contable' and id <> 14
                                      ORDER BY price ASC");
        return $obj_kit->getResult();
    }

    public function get_data_countable($contable)
    {
        $obj_kit =  $this->db->query("SELECT id from $this->table 
                                      WHERE active = '1' and `contable` = '$contable' 
                                      ORDER BY price ASC");
        return $obj_kit->getResult();
    }

    public function get_data_countable_mayor($membership_id)
    {
        $obj_kit =  $this->db->query("SELECT * from memberships
                                        WHERE memberships.id > $membership_id and active = '1' and `contable` = '0' and `slug` != 'membresia'
                                        ORDER BY price ASC");
        return $obj_kit->getResult();
    }

    public function get_all_product_stock()
    {
        $sql = "SELECT 
            memberships.id AS id_2, 
            memberships.name, 
            memberships.img, 
            memberships.price, 
            memberships.point,
            memberships.unit_cost, 
            memberships.description,
            memberships.contable, 
            memberships.sale, 
            memberships.active,
            IFNULL((SELECT SUM(qty) FROM incoming WHERE incoming.membership_id = id_2), 0) AS total_incoming,
            IFNULL((SELECT SUM(qty) FROM outgoing WHERE outgoing.membership_id = id_2), 0) AS total_outgoing,
            (SELECT total_incoming - total_outgoing) AS balance
        FROM memberships 
        WHERE memberships.contable = '1';";
        $obj_kit = $this->db->query($sql);
        if ($obj_kit === false) {
            // Mostrar error SQL (solo para desarrollo, quitar en producción)
            log_message('error', 'Error en la consulta SQL en get_all_product_stock: ' . $sql);
            return [];
        }
        return $obj_kit->getResult();
    }

    public function get_membership()
    {
        $obj_kit =  $this->db->query("SELECT memberships.id AS id_2, memberships.name, memberships.img, memberships.price, memberships.point,memberships.unit_cost, memberships.description,memberships.contable, memberships.sale, memberships.active,
                                    IFNULL((SELECT SUM(qty) FROM incoming WHERE membership_id = id_2 AND incoming.active = '1'), 0) AS total_incoming,
                                    IFNULL((SELECT SUM(qty) FROM outgoing WHERE membership_id = id_2), 0) AS total_outgoing,
                                    (SELECT total_incoming - total_outgoing) AS balance
                                    FROM memberships 
                                    WHERE memberships.slug = 'membresia'
                                    ");
        return $obj_kit->getRow();
    }

    public function get_membership_by_id($membership_id)
    {
        $obj_kit =  $this->db->query("SELECT * FROM memberships WHERE memberships.id = $membership_id");
        return $obj_kit->getRow();
    }

    public function get_all_product_stock_export($where)
    {
        $obj_kit =  $this->db->query("SELECT memberships.id AS id_2, memberships.name, 
                                    IFNULL((SELECT SUM(qty) FROM incoming WHERE membership_id = id_2 $where), 0) AS total_incoming,
                                    IFNULL((SELECT SUM(qty) FROM outgoing WHERE membership_id = id_2 $where), 0) AS total_outgoing,
                                    (SELECT total_incoming - total_outgoing) AS balance
                                    FROM memberships 
                                    WHERE memberships.contable = '1' AND memberships.active = '1'
                                    ");
        return $obj_kit->getResult();
    }

    public function insertar($data)
    {
        $obj_comments = $this->db->table($this->table);
        $obj_comments->insert($data);
        return $this->db->insertId();
    }

    public function eliminar($id)
    {
        return $this->db->query("DELETE FROM $this->table WHERE id = $id");
    }
}