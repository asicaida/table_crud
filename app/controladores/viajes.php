<?php
namespace controladores;

class viajes extends \core\Controlador {

	
	
	/**
	 * Presenta una <table> con las filas de la tabla con igual nombre que la clase.
	 * @param array $datos
	 */
    public function index(array $datos=array()){
                   $clausulas['ordey_by']='nombre';
                   $datos["filas"]= \modelos\Datos_SQL::table("viajes")->select( $clausulas );
                   $datos['view_content']= \core\Vista::generar(__FUNCTION__, $datos);
                   $http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
                   \core\HTTP_Respuesta::enviar($http_body);
    }
    
    
    
    
	
		
	
	public function form_insertar(array $datos=array()) {
		
		$clausulas['order_by'] = " nombre ";
		$datos['viajes'] = \modelos\Datos_SQL::table("viajes")->select($clausulas);
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}

	public function validar_form_insertar(array $datos=array())
	{	
		$validaciones=array(
			 "nombre" =>"errores_requerido && errores_texto"
                        ,"apellidos"=>"errores_requerido  && errores_texto"
                        ,"destino"=>"errores_requerido  && errores_texto"
			, "precio" => "errores_precio && errores_requerido"
			
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos))
            $datos["errores"]["errores_validacion"]="Corrige los errores.";
		else {
			$datos['values']['precio'] = \core\Conversiones::decimal_coma_a_punto($datos['values']['precio']);
			if ( ! $validacion = \modelos\Datos_SQL::table("viajes")->insert($datos["values"])) // Devuelve true o false
				$datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
		}
		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			$this->cargar_controlador('viajes', 'form_insertar',$datos);
		else
		{
			// Se ha grabado la modificación. Devolvemos el control al la situacion anterior a la petición del form_modificar
			$datos = array("alerta" => "Se han grabado correctamente los detalles");
			// Definir el controlador que responderá después de la inserción
			$this->cargar_controlador('viajes', 'index',$datos);		
		}
	}

	
	
	public function form_modificar(array $datos=array()) {
		
		if ( ! count($datos)) { // Si no es un reenvío desde una validación fallida
			$validaciones=array(
				"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/viajes/id"
			);
			if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
				$datos['mensaje'] = 'Datos erróneos para identificar el artículo a modificar';
				$datos['url_continuar'] = \core\URL::generar("viajes");
				
				$this->cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$clausulas['where'] = " id = {$datos['values']['id']} ";
				if ( ! $filas = \modelos\Datos_SQL::table("viajes")->select($clausulas)) {
					$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
					$this->cargar_controlador('mensajes', 'mensaje', $datos);
					return;
				}
				else {
					$datos['values'] = $filas[0];
					$datos['values']['precio'] = \core\Conversiones::decimal_punto_a_coma_y_miles($datos['values']['precio']);
					
					$clausulas = array('order_by' => " nombre ");
					$datos['viajes'] = \modelos\Datos_SQL::table("viajes")->select( $clausulas);
				}
			}
		}
		
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
		\core\HTTP_Respuesta::enviar($http_body);
	}

	public function validar_form_modificar(array $datos=array()) {	
		
		$validaciones=array(
			 "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/viajes/id"
			, "nombre" =>"errores_requerido && errores_texto && errores_unicidad_modificar:id,nombre/viajes/nombre,id"
                        , "apellidos" =>"errores_requerido && errores_texto && errores_unicidad_modificar:id,nombre/viajes/nombre,id"
			, "precio" => "errores_precio"
			, "destino" => "errores_requerido"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			//print_r($datos);
            $datos["errores"]["errores_validacion"] = "Corrige los errores.";
		}
		else {
			$datos['values']['precio'] = \core\Conversiones::decimal_coma_a_punto($datos['values']['precio']);
			
                       
			if ( ! $validacion = \modelos\Datos_SQL::table("viajes")->update($datos["values"])) // Devuelve true o false
				$datos["errores"]["errores_validacion"]="No se han podido grabar los datos en la bd.";
		}
		if ( ! $validacion) //Devolvemos el formulario para que lo intente corregir de nuevo
			$this->cargar_controlador('viajes', 'form_modificar',$datos);
		else
		{
			$datos = array("alerta" => "Se han modificado correctamente.");
			// Definir el controlador que responderá después de la inserción
			$this->cargar_controlador('viajes', 'index',$datos);		
		}
	}

	
	
	public function form_borrar(array $datos=array()) {
		
		$validaciones=array(
			"id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/viajes/id"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el artículo a borrar';
			$datos['url_continuar'] = \core\URL::http('?menu=viajes');
			$this->cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else {
			$clausulas['where'] = " id = {$datos['values']['id']} ";
			if ( ! $filas = \modelos\Datos_SQL::table("viajes")->select( $clausulas)) {
				$datos['mensaje'] = 'Error al recuperar la fila de la base de datos';
				$this->cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else {
				$datos['values'] = $filas[0];
				$datos['values']['precio'] = \core\Conversiones::decimal_a_punto($datos['values']['precio']);
				$clausulas = array('order_by' => " nombre ");
				$datos['viajes'] = \modelos\Datos_SQL::select( $clausulas, 'viajes');
			}
		}
		$datos['view_content'] = \core\Vista::generar(__FUNCTION__, $datos);
		$http_body = \core\Vista_Plantilla::generar('plantilla_principal', $datos);
		\core\HTTP_Respuesta::enviar($http_body);
	}

	
	
	
	
	
	
	
	
	
	
	public function validar_form_borrar(array $datos=array()) {	
		$validaciones=array(
			 "id" => "errores_requerido && errores_numero_entero_positivo && errores_referencia:id/viajes/id"
		);
		if ( ! $validacion = ! \core\Validaciones::errores_validacion_request($validaciones, $datos)) {
			$datos['mensaje'] = 'Datos erróneos para identificar el artículo a borrar';
			$datos['url_continuar'] = \core\URL::http('?menu=viajes');
			$this->cargar_controlador('mensajes', 'mensaje', $datos);
			return;
		}
		else
		{
			if ( ! $validacion = \modelos\Datos_SQL::delete($datos["values"], 'viajes')) {// Devuelve true o false
				$datos['mensaje'] = 'Error al borrar en la bd';
				$datos['url_continuar'] = \core\URL::http('?menu=viajes');
				$this->cargar_controlador('mensajes', 'mensaje', $datos);
				return;
			}
			else
			{
			$datos = array("alerta" => "Se borrado correctamente.");
			$this->cargar_controlador('viajes', 'index',$datos);		
			}
		}
	}
	
	
	public function listado_pdf(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select( $clausulas , 'viajes');		
		
		$datos['html_para_pdf'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		require_once(PATH_APP."lib/php/dompdf/dompdf_config.inc.php");

		$html =
		  '<html><body>'.
		  '<p>Put your html here, or generate it with your favourite '.
		  'templating system.</p>'.
		  '</body></html>';

		$dompdf = new \DOMPDF();
		$dompdf->load_html($datos['html_para_pdf']);
		$dompdf->render();
		$dompdf->stream("sample.pdf", array("Attachment" => 0));
		
		// \core\HTTP_Respuesta::set_mime_type('application/pdf');
		// \core\HTTP_Respuesta::enviar($datos, 'plantilla_pdf');
		
	}
	

	/**
	 * Genera una respuesta json con un array que contiene objetos, siendo cada objeto una fila.
	 * @param array $datos
	 */
	public function listado_js(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select($clausulas, 'viajes');
				
		$datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		\core\HTTP_Respuesta::set_mime_type('text/json');
		$http_body = \core\Vista_Plantilla::generar('plantilla_json', $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	/**
	 * Genera una respuesta json con un array que contiene objetos, siendo cada objeto una fila.
	 * @param array $datos
	 */
	public function listado_js_array(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select( $clausulas, 'viajes');
				
		$datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		\core\HTTP_Respuesta::set_mime_type('text/json');
		$http_body = \core\Vista_Plantilla::generar('plantilla_json', $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
	/**
	 * Genera una respuesta xml.
	 * 
	 * @param array $datos
	 */
	public function listado_xml(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($_datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$_datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select( $clausulas, 'viajes');
				
		$datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		\core\HTTP_Respuesta::set_mime_type('text/xml');
		\core\HTTP_Respuesta::enviar('plantilla_xml', $datos);
		
	}
	
	
	
	
	/**
	 * Genera una respuesta excel.
	 * @param array $datos
	 */
	public function listado_xls(array $datos=array()) {
		
		$validaciones = array(
			"nombre" => "errores_texto"
		);
		\core\Validaciones::errores_validacion_request($validaciones, $datos);
		if (isset($_datos['values']['nombre'])) 
			$clausulas['where'] = " nombre like '%{$_datos['values']['nombre']}%'";
		$clausulas['order_by'] = 'nombre';
		$datos['filas'] = \modelos\Datos_SQL::select($clausulas, 'viajes');
				
		$datos['contenido_principal'] = \core\Vista::generar(__FUNCTION__, $datos);
		
		\core\HTTP_Respuesta::set_mime_type('application/excel');
		$http_body = \core\Vista_Plantilla::generar('plantilla_xls', $datos);
		\core\HTTP_Respuesta::enviar($http_body);
		
	}
	
	
} // Fin de la clase