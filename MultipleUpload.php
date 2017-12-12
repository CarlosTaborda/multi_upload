<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MultipleUpload {
    /**
    * Carlos Felipe Aguirre Taborda GL STUDIOS S.A.S 2017-10-03 09:55:34
    * @param $campo
    * @param $path
    * @param $extenciones        
    * @return $informacion array con la informacion de los archivos subidos 
    * Descripción: 
    */
    public function uploadMultiple( $campo, $path, $extenciones ){
        $filecount=count($_FILES[ $campo ]['name']);
        // For para subir cada uno de los documentos
        for($i=0; $i<$filecount; $i++){
            // Configuracion de la subida del archivo
            $_FILES['mediaelement']['name']=$_FILES[ $campo ]['name'][$i];
            $_FILES['mediaelement']['type']=$_FILES[ $campo ]['type'][$i];
            $_FILES['mediaelement']['tmp_name']=$_FILES[ $campo ]['tmp_name'][$i];
            $_FILES['mediaelement']['error']=$_FILES[ $campo ]['error'][$i];
            $_FILES['mediaelement']['size']=$_FILES[ $campo ]['size'][$i];

            $config['upload_path']= $path;
            $nombreArchivo = uniqid();
            $config['file_name'] = $nombreArchivo;
            $config['allowed_types']=$extenciones;

            if(!is_dir($config['upload_path'])){
                mkdir($config['upload_path'], 0775);
            }
            $CI =& get_instance();
            

            $CI->load->library('upload');
            $CI->upload->initialize($config);
            // Subir del archivo
            if( $CI->upload->do_upload('mediaelement')){
                $informacion[$i]['info'] = $CI->upload->data();
                $informacion[$i]['path'] = $informacion[$i]['info']['full_path']; 
                $informacion[$i]['name'] = $_FILES[ $campo ]['name'][$i];
            }
            else{
                //var_dump( $CI->upload->display_errors());
                return false;
            }
            
        }
        return $informacion;
    }
}