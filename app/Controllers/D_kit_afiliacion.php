<?php

namespace App\Controllers;
use App\Models\MembershipsModel;

class D_kit_afiliacion extends BaseController
{   
    public function index()
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get kit affiliation
        $Membership = new MembershipsModel();
        $params = array(
            "select" => "*",
            "where" => "`contable` = '0'",
            "order" => "price ASC",
        );
        $obj_membership = $Membership->search($params);
        //send
        $data = array(
            'obj_membership' => $obj_membership,
            'session_name' => $session_name
        );
        return view('admin/kit_afiliacion/list', $data);
    }
    
    public function load($id=false){
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        $obj_membership = null;
        //verify id
        if ($id != false){
            //get data bonus by bonus
            $Membership = new MembershipsModel();
            $obj_membership = $Membership->get_all_by_id($id);
          }
        //send
        $data = array(
            'obj_membership' => $obj_membership,
            'session_name' => $session_name
        );
        return view('admin/kit_afiliacion/load', $data);
    }

    public function validacion(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            //get data session
            $Membership = new MembershipsModel();
            //get data post
            $res = service('request')->getPost();
            $name = $res['name'];
            $slug = slugify($name);
            $membership_id = $res['membership_id'];
            $img = $this->request->getFile('img');
            $img_temp = $res['img_temp'];
            //verify
            if($membership_id != ""){
                //upload img
                if($img != ""){
                    //validation
                    $validationRule = [
                        'img' => [
                            'label' => 'Image File',
                            'rules' => 'uploaded[userfile]'
                                . '|is_image[userfile]'
                                . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                                . '|max_size[userfile,100]'
                                . '|max_dims[userfile,1024,768]',
                        ],
                    ];
                    if (! $this->validate($validationRule)) {
                        $data['status'] = false;
                    }
                    if ($img->isValid() && ! $img->hasMoved()) {
                        $newName = $img->getRandomName();
                        $img->move('./membresias/' . $membership_id , $newName);
                    }
                }else{
                    $newName = $img_temp;
                }
                //update membership
                $param = array(
                    'name' => $name,
                    'slug' => $slug,
                    'price' => $res['price'],
                    'point' => $res['point'],
                    'img' => $newName,
                    'description' => $res['description'],
                    'active' => $res['active'],
                );
                $result = $Membership->update($membership_id, $param);
            }else{
                //insert table
                $param = array(
                    'name' => $name,
                    'slug' => $slug,
                    'price' => $res['price'],
                    'point' => $res['point'],
                    'description' => $res['description'],
                    'active' => $res['active'],
                );
                $id = $Membership->insertar($param);
                //set path
                $estructura = './membresias/'.$id;
                //create file
                if(!is_dir($estructura)){
                    mkdir($estructura, 0777, true);
                }
                //upload imagen 1
                //validation
                $validationRule = [
                    'img' => [
                        'label' => 'Image File',
                        'rules' => 'uploaded[userfile]'
                            . '|is_image[userfile]'
                            . '|mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                            . '|max_size[userfile,100]'
                            . '|max_dims[userfile,1024,768]',
                    ],
                ];
                
                if (! $this->validate($validationRule)) {
                    $data['status'] = false;
                }
        
                if ($img->isValid() && ! $img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('./membresias/' . $id , $newName);
                }else{
                    $newName = null;
                }
                //update table courses
                $param = array(
                    'img' => $newName,
                    );          
                $result = $Membership->update($id, $param);
            }
            if(!is_null($result)){
                $data['status'] = true;
                $data['message'] = SAVED;
            }else{
                $data['status'] = false;
                $data['message'] = ERROR;
            }
            echo json_encode($data); 
            exit();
        }
    }

    public function eliminar(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Membership = new MembershipsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];

            var_dump($id);
            die();

            //verify                     
            if($id != null){
                $result = $Membership->eliminar($id);
                if(!is_null($result)){
                    $data['status'] = true;
                    $data['message'] = DELETED;
                }else{
                    $data['status'] = false;
                    $data['message'] = ERROR;
                }     
            }else{
                $data['status'] = false;
            }
            echo json_encode($data); 
            exit();
        }
    }

    
}
