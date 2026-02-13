<?php
namespace App\Controllers;
use App\Models\User_adminModel;

class B_user extends BaseController
{   
    public function list()
    {
        $session = session();
        $db = \Config\Database::connect();
        $id = $session->get('id');
        $request= \Config\Services::request();
        $page = $request->getPostGet('page');
        $table = $db->table('users');
        $table->select('*');
        $table->orderBy('users.user_id', 'DESC');
        $table->limit(5, $page);
        $query = $table->get();
        $result = $query->getResult();

        if(count($result) > 0)
        {
            $data = array(
                'status' => true,
                'data' => $result
            );
            return json_encode($data);
        }
        else
        {
            $data['status'] = false;
            return $data;
        }
    }
    public function register()
    {
        $session = session();
        $db = \Config\Database::connect();
        $id = $session->get('id');
        $user_adminModel=new User_adminModel($db);
		$request= \Config\Services::request();
		$data=array(
            'password'=>$request->getPostGet('password'),
            'first_name'=>$request->getPostGet('first_name'),
            'last_name'=>$request->getPostGet('last_name'),
            'email'=>$request->getPostGet('email'),
            'privilage'=>$request->getPostGet('privilage'),
            'active'=>$request->getPostGet('active'),
            'status_value'=>$request->getPostGet('status_value'),
            'created_by'=>$request->getPostGet('created_by'),
            'updated_by'=>$request->getPostGet('updated_by'),
		);
        
		if($user_adminModel->save($data)===false){
            $data['status'] = false;
            return $data;
		}else{
            $data['status'] = true;
            return $data;
        }
    }
    public function update()
    {
        $session = session();
        $db = \Config\Database::connect();
        $id = $session->get('id');
        $user_adminModel=new User_adminModel($db);
		$request= \Config\Services::request();
        $bonus_id = $request->getPostGet('bonus_id');
		$data=array(
            'password'=>$request->getPostGet('password'),
            'first_name'=>$request->getPostGet('first_name'),
            'last_name'=>$request->getPostGet('last_name'),
            'email'=>$request->getPostGet('email'),
            'privilage'=>$request->getPostGet('privilage'),
            'active'=>$request->getPostGet('active'),
            'status_value'=>$request->getPostGet('status_value'),
            'created_by'=>$request->getPostGet('created_by'),
            'updated_by'=>$request->getPostGet('updated_by'),
		);
        $response = $user_adminModel->update($bonus_id, $data);
        if($response){
            $data['status'] = true;
            return $data;
		}else{
            $data['status'] = false;
            return $data;
        }
    }
    public function delete()
    {
        $session = session();
        $db = \Config\Database::connect();
        $id = $session->get('id');
        $user_adminModel=new User_adminModel($db);
		$request= \Config\Services::request();
        $bonus_id = $request->getPostGet('user_id');
        $response = $user_adminModel->delete($bonus_id);
        if($response){
            $data['status'] = true;
            return $data;
		}else{
            $data['status'] = false;
            return $data;
        }
    }
}
