<form method='post'  action="<?php echo core\URL::generar($datos['controlador_clase'].'/validar_'.$datos['controlador_metodo']); ?>" >
    
    
	
	<input id='id' name='id' type='hidden' value='<?php echo \core\Array_Datos::values('id', $datos);?>' />
	Nombre: <input id='nombre' name='nombre' type='text' size='100'  maxlength='100' value='<?php echo \core\Array_Datos::values('nombre', $datos);?>'/>
	<?php echo \core\HTML_Tag::span_error('nombre', $datos); ?>
	<br />
        Apellidos:<input id="apellidos" name="apellidos" type='text' size='100' maxlength='100' value='<?php echo \core\Array_Datos::values ( 'apellidos', $datos);?>' />
        <?php echo \core\HTML_Tag::span_error('apellidos', $datos);?>
        <br />
        Destino:<input id='destino' name='destino' type='text' size='100'  maxlength='100' value='<?php echo \core\Array_Datos::values('destino', $datos);?>'/>
	<?php echo \core\HTML_Tag::span_error('destino', $datos); ?>
        <br />
        Precio:<input id='precio'  name='precio' type='text' size='15' maxlength="15" value='<?php echo \core\Array_Datos::values('precio', $datos);?>' />
        <br />
        <?php echo \core\HTML_Tag::span_error('precio', $datos); ?>
        <br />
        Fecha de compra :<input id='fecha' name='fecha' type="text" size="50" maxlength="50" value="<?php echo \core\Array_Datos::values('fecha_de_compra', $datos);?>" />
	<br />
         <?php echo \core\HTML_Tag::span_error('errores_validacion', $datos); ?>
	
	<input type='submit' value='Enviar'/>
	<input type='reset' value='Limpiar'>
        <button type='button' onclick="location.assign('<?php echo \core\URL::generar($datos['controlador_clase'])?>')">Cancelar</button>
</form>
        