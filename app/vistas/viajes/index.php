<div>
	<h1>Lista de viajes</h1>
	
	<table border='1'>
		<thead>
			<tr>
				<th>nombre</th>
				<th>apellidos</th>
				<th>destino</th>
                                <th>precio</th>
                                
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($datos['filas'] as $fila)
			{
				echo "
					<tr>
						<td>{$fila['nombre']}</td>
						<td>{$fila['apellidos']}</td>
                                                 <td>{$fila['destino']}</td>
                                                <td>{$fila['precio']}</td>
						<td>
					".\core\HTML_Tag::a_boton("boton", array("viajes", "form_modificar", $fila['id']), "modificar")
//							<a class='boton' href='?menu={$datos['controlador_clase']}&submenu=form_modificar&id={$fila['id']}' >modificar</a>
					.\core\HTML_Tag::a_boton("boton", array("viajes", "form_borrar", $fila['id']), "borrar").
//							<a class='boton' href='?menu={$datos['controlador_clase']}&submenu=form_borrar&id={$fila['id']}' >borrar</a>
						"</td>
					</tr>
					";
			}
			echo "
				<tr>
					<td colspan='2'></td>
						<td>"
			.\core\HTML_Tag::a_boton("boton", array("viajes", "form_insertar"), "insertar").
					"</td>
				</tr>
			";
			?>
		</tbody>
	</table>
</div>
