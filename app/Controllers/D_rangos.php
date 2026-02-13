<?php



namespace App\Controllers;

use App\Models\RangesModel;

use App\Models\Range_customerModel;

use App\Models\CommissionsModel;



class D_rangos extends BaseController

{   

    public function index()

    {

        //get data session

        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];

        //get data point binary

        $Ranges = new RangesModel();

        $obj_ranges = $Ranges->get_all_crud();

        //send

        $data = array(

            'obj_ranges' => $obj_ranges,

            'session_name' => $session_name

        );

        return view('admin/rangos/list', $data);

    }



    public function new_ranges()

    {

        //get data session

        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];

        //get first day on month

        $date = first_month_day(date("m"), date("Y"));

        //get data point binary

        $Range_customer = new Range_customerModel();

        $obj_ranges = $Range_customer->get_all();

        //send

        $data = array(

            'obj_ranges' => $obj_ranges,

            'date' => $date,

            'session_name' => $session_name

        );

        return view('admin/rangos/new_ranges', $data);

    }

    

    public function load($id=false){

        //get data session

        $session_name = $_SESSION['first_name']." ".$_SESSION['last_name'];

        $Ranges = new RangesModel();

        $obj_ranges = null;

        //verify id

        if ($id != false){

            //get data bonus by bonus

            $obj_ranges = $Ranges->get_all_by_id($id);

          }

        //send

        $data = array(

            'obj_ranges' => $obj_ranges,

            'session_name' => $session_name

        );

        return view('admin/rangos/load', $data);

    }



    public function validacion(){

        //ACTIVE CUSTOMER NORMALY

        if ($this->request->isAJAX()) {

            $Ranges = new RangesModel();

            //get data post

            $res = service('request')->getPost();

            $range_id = $res['range_id'];

            $name = $res['name'];

            $points = $res['points'];

            $description = $res['description'];

            $img = $this->request->getFile('img');

            $img_temp = $res['img_temp'];

            $active = $res['active'];

            //verify ID

            if($range_id != ""){

                //set path

                $estructura = './rangos/'.$range_id;

                //create file

                if(!is_dir($estructura)){

                    mkdir($estructura, 0777, true);

                }

                if($img != ""){

                    //upload imagen

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

                    $image = \Config\Services::image()

                        ->withFile($img)

                        ->resize(200, 200, true, 'height')

                        ->save(FCPATH ."/rangos/$range_id/". $newName);

                        $img->move(WRITEPATH . "/rangos/$range_id");

                    //get name

                        $img = $newName;

                    }else{

                        $img = $img_temp;

                    }

                }else{

                    $img = $img_temp;

                }

                //update table point_binary  

                $param = array(

                    'name' => $name,

                    'points' => $points,

                    'img' => $img,

                    'description' => $description,

                    'active' => $active,

                    );          

                $result = $Ranges->update($range_id, $param);

            }else{

                //insert

                $param = array(

                    'name' => $name,

                    'points' => $points,

                    'description' => $description,

                    'active' => $active,

                    );          

                $id = $Ranges->insertar($param);

                //set path

                $estructura = './rangos/'.$id;

                //create file

                if(!is_dir($estructura)){

                    mkdir($estructura, 0777, true);

                }

                if($img != ""){

                    //upload imagen

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

                    $image = \Config\Services::image()

                        ->withFile($img)

                        ->resize(200, 200, true, 'height')

                        ->save(FCPATH ."/rangos/$id/". $newName);

                        $img->move(WRITEPATH . "/rangos/$id");

                        //get name

                        $img = $newName;

                    }

                    //update table ranges

                    $param = array(

                        'img' => $img,

                        );          

                    $result = $Ranges->update($id, $param);

                }

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

            $Ranges = new RangesModel();

            //get data post

            $res = service('request')->getPost();

            $id = $res['id'];

            //verify                     

            if($id != null){

                $result = $Ranges->eliminar($id);

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

