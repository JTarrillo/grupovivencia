<?php

namespace App\Controllers;

use App\Models\InvoicesModel;
use App\Models\CommissionsModel;
use App\Models\MembershipsModel;
use App\Models\CustomerModel;
use App\Models\UnilevelsModel;
use App\Models\Range_customerModel;
use App\Models\CalificationModel;
use App\Models\PeriodModel;
use App\Controllers\D_activaciones;
use App\Libraries\Evox;


class Crone extends BaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        $session = \Config\Services::session();
        $language = \Config\Services::language();
        $language->setLocale($session->lang);
        helper('global');
    }

    //reconsumo inactivos   
    public function index()
    {
        $Customer = new CustomerModel();
        //get all active customers
        $obj_customer = $Customer->get_customer_active_all();
        //save period ranges
        $this->save_range($obj_customer);

        echo "✔️ Rangos guardados correctamente<br/>";

        //update table customer active = '0'
        foreach ($obj_customer as $key => $value) {
            //update customer
            $param = array(
                'range_id' => '1',
                'active' => '0'
            );
            $Customer->update($value->id, $param);
        }
        echo "✔️ Reconsumos ejecutado correctamente<br/>";

        //update period
        $this->update_period();

        echo "✔️ Cierre correctamente<br/>";
        die();
    }

    public function save_range($obj_customer) { //object

        $Range_customer = new Range_customerModel();
        //call library Evox
        $evox = new Evox(); 
        //get current period 
        $period = $evox->get_period();

        foreach ($obj_customer as $key => $value) {

            //range_id = 1 (Socio) default
            if($value->range_id > 1){
                //save last rank obtained in the period
                $param = array(
                    'customer_id' => $value->id,
                    'range_id' => $value->range_id,
                    'date' => date("Y-m-d H:i:s"),
                    'period_id' => $period->id
                );  
                $Range_customer->insertar($param);
            }
        }
    }

    public function update_period() {
        //Do the beginning of each period from the 1st to the 16th of each month
        $Period = new PeriodModel();
        $year = date("y");
        $month = date("m");
        $day = date("d");

        switch ($month) {
            case "1":
                $begin = "$year-01-01";
                $end = last_month_day_actual();
                break;
            case "2":
                $begin = "$year-02-01";
                $end = last_month_day_actual();
                break;
            case "3":
                $begin = "$year-03-01";
                $end = last_month_day_actual();
                break;
            case "4":
                $begin = "$year-04-01";
                $end = last_month_day_actual();
                break;
            case "5":
                $begin = "$year-05-01";
                $end = last_month_day_actual();
                break;
            case "6":
                $begin = "$year-06-01";
                $end = last_month_day_actual();
                break;
            case "7":
                $begin = "$year-07-01";
                $end = last_month_day_actual();
                break;
            case "8":
                $begin = "$year-08-01";
                $end = last_month_day_actual();
                break;
            case "9":
                $begin = "$year-09-01";
                $end = last_month_day_actual();
                break;
            case "10":
                $begin = "$year-10-01";
                $end = last_month_day_actual();
                break;
            case "11":
                $begin = "$year-11-01";
                $end = last_month_day_actual();
                break;
            case "12":
                $begin = "$year-12-01";
                $end = last_month_day_actual();
                break;
        }
        //set code
        $code = $year."".$month;
        $obj_periodo = $Period->get_all_by_code($code);
        if($obj_periodo == 0){
            //enter new record in period table
            $param = array(
                'code' => $code,
                'begin' => $begin,
                'end' => $end,
                'created_at' => date("Y-m-d H:i:s")
            ); 
            $Period->insertar($param);
        }
        echo "✔️ Periodo actualizado correctamente <br/>";
        
    }

    public function sitemap()
    {
        $date = date("Y-m-d");
        //get products active
        $Memberships = new MembershipsModel();
        $obj_memberships = $Memberships->get_all_membership();
        $codigo = '<?xml version="1.0" encoding="UTF-8"?>
		<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
			xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
			';
        $codigo .= '<url>';
        $codigo .= '<loc>' . site_url() . '</loc>';
        $codigo .= '<lastmod>' . $date . 'T19:18:39+00:00</lastmod>';
        $codigo .= '<changefreq>weekly</changefreq>
				<priority>1.00</priority>';
        $codigo .= '</url>';
        $codigo .= '<url>';
        $codigo .= '<loc>' . site_url() . 'nosotros' . '</loc>';
        $codigo .= '<lastmod>' . $date . 'T19:18:39+00:00</lastmod>';
        $codigo .= '<changefreq>weekly</changefreq>
				<priority>0.80</priority>';
        $codigo .= '</url>';
        $codigo .= '<url>';
        $codigo .= '<loc>' . site_url() . 'productos' . '</loc>';
        $codigo .= '<lastmod>' . $date . 'T19:18:39+00:00</lastmod>';
        $codigo .= '<changefreq>weekly</changefreq>
				<priority>0.80</priority>';
        $codigo .= '</url>';
        foreach ($obj_memberships as $value) {
            $codigo .= '<url>';
            $codigo .= '<loc>' . site_url() . 'productos/' . $value->slug . '</loc>';
            $codigo .= '<lastmod>' . $date . 'T19:18:39+00:00</lastmod>';
            $codigo .= '<changefreq>weekly</changefreq>
                    <priority>0.60</priority>';
            $codigo .= '</url>';
        }
        $codigo .= '<url>';
        $codigo .= '<loc>' . site_url() . 'contacto' . '</loc>';
        $codigo .= '<lastmod>' . $date . 'T19:18:39+00:00</lastmod>';
        $codigo .= '<changefreq>weekly</changefreq>
				<priority>0.60</priority>';
        $codigo .= '</url>';
        $codigo .= '<url>';
        $codigo .= '<loc>' . site_url() . 'iniciar-sesion' . '</loc>';
        $codigo .= '<lastmod>' . $date . 'T19:18:39+00:00</lastmod>';
        $codigo .= '<changefreq>weekly</changefreq>
				<priority>0.50</priority>';
        $codigo .= '</url>';
        $codigo .= '<url>';
        $codigo .= '<loc>' . site_url() . 'preguntas-frecuentes' . '</loc>';
        $codigo .= '<lastmod>' . $date . 'T19:18:39+00:00</lastmod>';
        $codigo .= '<changefreq>weekly</changefreq>
				<priority>0.40</priority>';
        $codigo .= '</url>';
        $codigo .= '<url>';
        $codigo .= '<loc>' . site_url() . 'terminos-y-condiciones' . '</loc>';
        $codigo .= '<changefreq>weekly</changefreq>
				<priority>0.40</priority>';
        $codigo .= '</url>';
        $codigo .= '<url>';
        $codigo .= '<loc>' . site_url() . 'politica-de-privacidad' . '</loc>';
        $codigo .= '<changefreq>weekly</changefreq>
				<priority>0.40</priority>';
        $codigo .= '</url>';
        $codigo .= '</urlset>';
        $path = "sitemap.xml";
        $modo = "w+";

        if ($fp = fopen($path, $modo)) {
            fwrite($fp, $codigo);
            echo "<script>alert('SiteMap con Exito')</script>";
        } else {
            echo "<script>alert('Error')</script>";
        }
    }
}