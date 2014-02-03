<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace modelos;


class viajes extends \core\sgbd\bd{
    
    public static $tabla='viajes';
    
        public static function create_table (){
               $consulta ="
                      create table" .self::$tabla."
                          (id integer auto_increment 
                            , nombre varchar (100) not null
                            ,apellidos varchar (100)not null
                            ,destino varchar(100) not null
                            ,fecha_de_compra timestamp default current_timestamp()
                            ,precio decimal (10,2) not null
                            ,primary key (id))
                            engine = innodb;
                            ";
               return self::execute ($consulta) ;
        } 
        
        public static function insertar(array &$fila ) {
		
		
		$validacion = true;
		if ( ! isset($fila['values']['nombre']) or ! is_string($fila['values']['nombre'])) {
			$validacion = false;
			$fila['errores']['nombre'] = "Esta columna no puede esta vacía y debe ser un string.";
		}
		if ( ! isset($fila['values']['apellidos']) ) {
			$fila['values']['apellidos'] = "Esta columna no puede esta vacía y debe ser un string.";
                        $validacion = false;
		}
		elseif ( ! is_string($fila['values']['destino'])) {
			$validacion = false;
			$fila['errores']['destino'] = "Esta columna debe ser un string.";
		}
                elseif ( ! is_string($fila['values']['precio'])) {
			$validacion = false;
			$fila['errores']['precio'] = "Esta columna debe ser un numero decimal.";
		}
		
		if ($validacion) {
		
			return self::insertar_fila($fila['values'], self::$tabla);
		}
		else {
			return false;
		}
	}
        
        public static function borrar(array &$fila ) {
		
		
		$validacion = true;
		if ( ! isset($fila['values']['id']))  {
			$validacion = false;
			throw new \Exception(".....");
		}
		
		
		if ($validacion) {
		
			$consulta = "
				delete from ".self::$tabla."
					where nombre = '{$fila['values']['nimbre']}' or id = {$fila['values']['id']}
				;		
			";

			return self::ejecutar_consulta($consulta);
		}
		else {
			return false;
		}
	}
}

?>