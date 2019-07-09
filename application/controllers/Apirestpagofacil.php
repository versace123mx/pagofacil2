<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Apirestpagofacil extends \Restserver\Libraries\REST_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Escuela_model');
    }

    public static function validaNumero($id){
    	$regex="/^[[:digit:]]+$/";
      	if(!preg_match($regex,$id)){
        	return false;
    	}
    	return true;
    }

	public function test_get()
    {
    	$array=array('Hola','Mundo','Codeigniter');
    	$this->response($array);
	}

    public function user_get()
    {
    	$id = $this->input->get('idusuario');
      	if(!isset($id) || empty($id) || !self::validaNumero($id)){
        	return "El id es un digito";
    	} else {
        	$r  = $this->Escuela_model->read($id);
        	$this->response($r);
        }
    }

	/*Metodo para insertar un registro*/
    public function user_post()
    {

    	$data = array(
    	'idmateria' => $this->input->post('idmateria'),
    	'idusuario' => $this->input->post('idusuario'),
        'calificacion' => $this->input->post('calificacion')
         );
    	if(!empty($data['idmateria']) && !empty($data['idusuario']) && !empty($data['calificacion'])){
    		$regex="/^[[:digit:]]+$/";
      		if(preg_match($regex,$data['idmateria']) && preg_match($regex,$data['idusuario']) ){
				$r = $this->Escuela_model->insert($data);
        		$this->response($r);
    		}else{
    			return "Parametros invalidos,intentalo nuevamente";
    		}
    	}else{
			return "Parametros invalidos,intentalo nuevamente";
    	}
         
    }

    /*Metodo para actualizar un registro*/
    public function user_put()
    {
        $data = array(
       	'idcalificacion' => $this->input->get('idcalificacion'),
        'calificacion' => $this->input->get('calificacion')
        );
        
        if(!empty($data['idcalificacion']) && !empty($data['calificacion'])){
    		$regex="/^[[:digit:]]+$/";
    		if(preg_match($regex,$data['idcalificacion'])){
				$r = $this->Escuela_model->update($data);
        		$this->response($r);
    		}else{
				return "Parametros invalidos,intentalo nuevamente";
    		}	
    	}
	}


    /*Metodo para eliminar un registro*/
    public function user_delete()
    {
        $id = $this->input->get('idcalificacion');
        if(!empty($id)){
    		$regex="/^[[:digit:]]+$/";
    		if(preg_match($regex,$id)){
        		$r = $this->Escuela_model->delete($id);
        		$this->response($r); 
    		}
		}
    }
}
