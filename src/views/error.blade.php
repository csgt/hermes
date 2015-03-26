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
	<p>Mensaje generado automaticamente</p>
	<table cellspacing="5" cellpadding="5">
		<tr>
			<th>Código</th>
			<td>{{ $codigo }}</td>
			<th>Fecha</th>
			<td>{{ date('d-m-Y') }}</td>
		</tr>
		<tr>
			<th>URL</th>
			<td colspan="3">{{ $url }}</td>
		</tr>
		<tr>
			<th>Excepción</th>
			<td colspan="3">{{ $exception }}</td>
		</tr>
	</table>
</body>
</html>