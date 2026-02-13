<?php

namespace App\Controllers;
use App\Models\AdsModel;

class D_anuncios extends BaseController
{   
    public function index()
    {
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        //get data point binary
        $Ads = new AdsModel();
        $obj_ads = $Ads->get_all();
        //send
        $data = array(
            'obj_ads' => $obj_ads,
            'session_name' => $session_name
        );
        return view('admin/anuncios/list', $data);
    }
    
    public function load($id=false){
        //get data session
        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];
        $Ads = new AdsModel();
        $obj_ads = null;
        //verify id
        if ($id != false){
            //get data bonus by bonus
            $obj_ads = $Ads->get_all_by_id($id);
          }
        //send
        $data = array(
            'obj_ads' => $obj_ads,
            'session_name' => $session_name
        );
        return view('admin/anuncios/load', $data);
    }

    public function validacion(){
        //ACTIVE CUSTOMER NORMALY
        if ($this->request->isAJAX()) {
            $Ads = new AdsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            $title = $res['title'];
            $img2 = $res['img2'];
            $img = $this->request->getFile('img');
            $content = $res['content'];
            $active = $res['active'];
            //set path
            $estructura = './anun/'.$id;
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
                $img->move('./anun/' . $id , $newName);
                $img = $img->getName();
            }else{
                $img = $img2;
            }
            //verify ID
            if($id != ""){
                //update table point_binary  
                $param = array(
                    'title' => $title,
                    'content' => $content,
                    'img' => $img,
                    'active' => $active,
                    );          
                $result = $Ads->update($id, $param);
            }else{
                $param = array(
                    'title' => $title,
                    'content' => $content,
                    'date' => date("Y-m-d H:i:s"),
                    'img' => $img,
                    'active' => $active,
                    );          
                $result = $Ads->insertar($param);
            }
            //verify 
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
            $Ads = new AdsModel();
            //get data post
            $res = service('request')->getPost();
            $id = $res['id'];
            //verify                     
            if($id != null){
                $result = $Ads->eliminar($id);
                if(!is_null($result)){
                    $data['status'] = true;
                    $data['message'] = DELETED;
                }else{
                    $data['status'] = false;
                    $data['message'] = ERROR;
                }     
            }else{
                $data['status'] = false;
                $data['message'] = ERROR;
            }
            echo json_encode($data); 
            exit();
        }
    }
}
