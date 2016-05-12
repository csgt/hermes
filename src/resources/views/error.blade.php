<!DOCTYPE html>
<html>
<body>
	<table cellspacing="5" cellpadding="5" border="1" width="100%" style="border-collapse: collapse;">
		<tr>
			<th align="left" width="25%">Código</th>
			<td width="25%">{{ $codigo }}</td>
			<th align="left" width="25%">Fecha</th>
			<td width="25%">{{ date('d-m-Y H:i') }}</td>
		</tr>
		<tr>
			<th align="left">URL</th>
			<td colspan="3">{{ $url }}</td>
		</tr>
		<tr>
			<th align="left">Mensaje</th>
			<td colspan="3">{{ $mensaje }}</td>
		</tr>
		<tr>
			<th align="left">Método</th>
			<td>{{ $request }}</td>
			<th align="left">IP</th>
			<td>{{ $ip }}</td>
		</tr>
		<tr>
			<th align="left">Usuario</th>
			<td>{{ $userid }}</td>
			<th align="left">Rol</th>
			<td>{{ $rolid }}</td>
		</tr>
		<tr>
			<th align="left">Línea</th>
			<td colspan="3">{{ $linea }}</td>
		</tr>
		<tr>
			<th align="left">User agent</th>
			<td colspan="3">{{ $useragent }}</td>
		</tr>
		<tr>
			<th align="left">Archivo</th>
			<td colspan="3">{{ $archivo }}</td>
		</tr>
		<tr>
			<th align="left">Vars</th>
			<td colspan="3">
				@foreach($vars as $key=>$var)
				  {{$key . ': ' . $var . '<br>'}}
				@endforeach
			</td>
		</tr>
	</table>
</body>
</html>