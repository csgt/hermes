<!DOCTYPE html>
<html>
<head>
	<title>Hermes</title>
	<style type="text/css">
		table, th, td {
		  border: 1px solid black;
		} 

		table {
    	border-collapse: collapse;
		}

		table, th, td {
		  border: 1px solid black;
		}

		table {
		  width: 100%;
		}

		th {
		  height: 30px;
		  text-align: left;
		  background-color: #d5d5d5;
		}


	</style>
</head>
<body>
	<table cellspacing="5" cellpadding="5">
		<tr>
			<th align="left">Código</th>
			<td>{{ $codigo }}</td>
			<th align="left">Fecha</th>
			<td>{{ date('d-m-Y H:i') }}</td>
		</tr>
		<tr>
			<th align="left">URL</th>
			<td colspan="3">{{ $url }}</td>
		</tr>
		<tr>
			<th align="left">Excepción</th>
			<td colspan="3">{{ $mensaje }}</td>
		</tr>
		<tr>
			<th align="left">IP</th>
			<td colspan="3">{{ $ip }}</td>
		</tr>
		<tr>
			<th align="left">User agent</th>
			<td colspan="3">{{ $useragent }}</td>
		</tr>
		<tr>
			<th align="left">Usuario Id</th>
			<td>{{ $userid }}</td>
			<th align="left">Rol Id</th>
			<td>{{ $rolid }}</td>
		</tr>
		<tr>
			<th align="left">Archivo</th>
			<td colspan="3">{{ $archivo }}</td>
		</tr>
		<tr>
			<th align="left">Línea</th>
			<td>{{ $linea }}</td>
			<th align="left">Method</th>
			<td>{{ $request }}</td>
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