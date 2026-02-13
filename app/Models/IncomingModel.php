<?php

namespace App\Models;

use CodeIgniter\Model;

class IncomingModel extends Model
{

    protected $table      = 'incoming';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = ['membership_id', 'supplier_id', 'store_id', 'user_id',  'qty', 'date', 'unit_cost', 'total_cost', 'active', 'created_at', 'updated_at'];
    protected $useTimestamps = false;


    // begin extends model

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



    public function get_all($first_day, $last_day)
    {
        $obj_result =  $this->db->query("SELECT incoming.id, incoming.date, incoming.unit_cost, memberships.name AS membership, suppliers.name AS supplier,store.id as store_id ,store.name as store, incoming.qty, incoming.total_cost, incoming.active, CONCAT(users.name ,' ', users.lastname) AS user
                                        FROM incoming
                                        JOIN memberships ON incoming.membership_id = memberships.id
                                        JOIN store ON incoming.store_id = store.id
                                        JOIN suppliers ON incoming.supplier_id = suppliers.id
                                        JOIN users ON incoming.user_id = users.id
                                        WHERE incoming.date >= '$first_day' and incoming.date <= '$last_day'");
        return $obj_result->getResult();
    }

    public function get_incoming_by_export($where)
    {
        $obj_result =  $this->db->query("SELECT incoming.id, incoming.date,incoming.unit_cost, memberships.name AS membership, suppliers.name AS supplier,store.id as store_id ,store.name as store, incoming.qty, incoming.total_cost, incoming.active, CONCAT(users.name ,' ', users.lastname) AS user
                                        FROM incoming
                                        JOIN memberships ON incoming.membership_id = memberships.id
                                        JOIN store ON incoming.store_id = store.id
                                        JOIN suppliers ON incoming.supplier_id = suppliers.id
                                        JOIN users ON incoming.user_id = users.id
                                        WHERE $where");
        return $obj_result->getResult();
    }

    public function get_by_id($id)
    {
        $obj_result =  $this->db->query("SELECT * FROM $this->table WHERE id = $id");
        return $obj_result->getRow();
    }

    public function get_kardex($first_day, $last_day)
    {
        $obj_result =  $this->db->query("SELECT * FROM (
                                            SELECT CONCAT('ENT00', incoming.id) AS id, memberships.name AS membership, store.name AS store, incoming.qty, incoming.unit_cost, incoming.total_cost, incoming.date , 'Entrada' AS concept 
                                            FROM incoming
                                            JOIN memberships ON incoming.membership_id = memberships.id
                                            JOIN store ON incoming.store_id = store.id
                                            WHERE NOT EXISTS (SELECT 1 FROM transfer WHERE store_arrive_id = incoming.id)
                                            UNION 
                                            SELECT CONCAT('SAL00', outgoing.id) AS id, memberships.name AS membership, store.name AS store, outgoing.qty, outgoing.unit_cost, outgoing.total_cost, outgoing.date , 'Salida' AS concept 
                                            FROM outgoing
                                            JOIN memberships ON outgoing.membership_id = memberships.id
                                            JOIN store ON outgoing.store_id = store.id
                                            WHERE NOT EXISTS (SELECT 1 FROM transfer WHERE store_leave_id = outgoing.id)
                                            UNION 
                                            SELECT CONCAT('TRA00', a1.id) AS id, m.name, CONCAT('De: ', s.name,' ', ' A: ', s2.name) AS store , a1.qty,a1.unit_cost,a1.total_costo, a1.date, 'Traspaso' AS concept
                                            FROM transfer AS a1
                                            JOIN outgoing AS c1 ON a1.store_leave_id = c1.id
                                            JOIN incoming AS c2 ON a1.store_arrive_id = c2.id
                                            JOIN store AS s ON c1.store_id = s.id
                                            JOIN store AS s2 ON c2.store_id = s2.id
                                            JOIN users AS u ON a1.user_id = u.id
                                            JOIN memberships AS m ON c1.membership_id = m.id
                                            ORDER BY DATE ASC) AS t 
                                            WHERE DATE >= '$first_day' and DATE < '$last_day'
                                            ORDER BY DATE ASC");
        return $obj_result->getResult();
    }

    public function get_kardex_by_export($where)
    {
        $obj_result =  $this->db->query("SELECT * FROM (
                                            SELECT CONCAT('ENT00', incoming.id) AS id, memberships.id AS membership_id, memberships.name AS membership, store.name AS store, incoming.qty, incoming.unit_cost, incoming.total_cost, incoming.date , 'Entrada' AS concept
                                            FROM incoming
                                            JOIN memberships ON incoming.membership_id = memberships.id
                                            JOIN store ON incoming.store_id = store.id
                                            WHERE incoming.active = '1'
                                            UNION 
                                            SELECT CONCAT('SAL00', outgoing.id) AS id, memberships.id AS membership_id, memberships.name AS membership, store.name AS store, outgoing.qty, outgoing.unit_cost, outgoing.total_cost, outgoing.date , 'Salida' AS concept 
                                            FROM outgoing
                                            JOIN memberships ON outgoing.membership_id = memberships.id
                                            JOIN store ON outgoing.store_id = store.id
                                            UNION 
                                            SELECT CONCAT('TRA00', a1.id) AS id, m.id AS membership_id, m.name, CONCAT('De: ', s.name,' ', ' A: ', s2.name) AS store , a1.qty,a1.unit_cost,a1.total_costo, a1.date, 'Traspaso' AS concept
                                            FROM transfer AS a1
                                            JOIN incoming AS c1 ON a1.store_leave_id = c1.id
                                            JOIN incoming AS c2 ON a1.store_arrive_id = c2.id
                                            JOIN store AS s ON c1.store_id = s.id
                                            JOIN store AS s2 ON c2.store_id = s2.id
                                            JOIN users AS u ON a1.user_id = u.id
                                            JOIN memberships AS m ON c1.membership_id = m.id
                                            ORDER BY DATE ASC
                                            ) AS t WHERE $where");
        return $obj_result->getResult();
    }



    public function get_max_membership_store($membership_id, $store_id)
    {
        $obj_result =  $this->db->query("SELECT SUM(qty) AS total_incoming, incoming.unit_cost,
                                        IFNULL((SELECT SUM(qty) FROM outgoing WHERE membership_id = $membership_id AND store_id = $store_id), 0) AS total_ourgoing
                                        FROM incoming
                                        WHERE membership_id = $membership_id AND store_id = $store_id");
        return $obj_result->getRow();
    }

    public function insertar($data)
    {
        $query = $this->db->table($this->table);
        $query->insert($data);
        return $this->db->insertId();
    }

    public function eliminar($id)
    {
        return $this->db->query("DELETE FROM $this->table WHERE id = $id");
    }
}
