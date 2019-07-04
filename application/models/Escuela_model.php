<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Escuela_model extends CI_Model
{
  


  public function __construct(){
    $this->load->database();
  }

  public function read($id){
    $iduser = $id;
    if(empty($iduser)){
        $iduser=0;
    }
   
    $cadena='%d-%c-%Y';
       $query = $this->db->query('
        select ta.id_t_usuarios,ta.nombre,ta.ap_paterno,tm.nombre as materia,tc.calificacion,tc.id_t_calificaciones as idCalificacion,
        date_format(tc.fecha_registro,"'.$cadena.'") as fecha_registros
        from t_alumnos as ta 
        inner join t_calificaciones as tc on ta.id_t_usuarios=tc.id_t_usuarios
        inner join t_materias as tm on tc.id_t_materias= tm.id_t_materias
        where ta.id_t_usuarios = "'.$iduser.'" and tm.activo=1 and ta.activo=1');
       
        $cadSQL = $query->result_array();

        $sumCalificacion=0;
        $numElementos = count($cadSQL);
        if($numElementos > 0){
          foreach ($cadSQL as $key) {
            $sumCalificacion += $key['calificacion'];
          }
          $promedio=$sumCalificacion/$numElementos;
          $cadSQL['promedio']=$promedio;
        }

       
       if(!empty($cadSQL)){
        return $cadSQL;
       }else{
        return "no hay datos a mostrar, verifica el id";
       }

   }

   public function insert($data){
       $this->id_t_materias  = $data['idmateria'];
       $this->id_t_usuarios = $data['idusuario'];
       $this->calificacion  = $data['calificacion'];
       $this->fecha_registro = date("Y-m-d");
       if($this->db->insert('t_calificaciones',$this))
       {    
           $arreglo = array("success" => "ok","msg" => "calificacion registrada");
           return $arreglo;
       }
         else
       {
           return "Error has occured";
       }
   }

   public function update($data){
       $id  = $data['idcalificacion'];
       $this->calificacion  = $data['calificacion'];
       $result = $this->db->update('t_calificaciones',$this,array('id_t_calificaciones' => $id));
       if(!empty($result))
       {
        $arreglo = array("success" => "ok","msg" => "calificacion actualizada");
           return $arreglo;
       }
       else
       {
           return "Error has occurred";
       }
   }

   public function delete($id){
       $idcalificacion  = $id;
       $this->activo=0;
       $result = $this->db->query('delete from t_calificaciones where id_t_calificaciones = "'.$id.'"');
       if($result)
       {
            $arreglo = array("success" => "ok","msg" => "calificacion eliminada");
           return $arreglo;
       }
       else
       {
           return "Error has occurred";
       }
   }
}