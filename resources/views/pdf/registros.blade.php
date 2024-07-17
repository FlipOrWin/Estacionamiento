<!DOCTYPE html>
<html>
<head>
    <title>Registros</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Registros de Estacionamiento</h1>
    <table>
        <thead>
            <tr>
                <th>Placa</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Tipo</th>
                <th>Pago</th>
                <th>Duración</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros as $registro)
                <tr>
                    <td>{{ $registro->placa }}</td>
                    <td>{{ $registro->entrada }}</td>
                    <td>{{ $registro->salida }}</td>
                    <td>{{ $registro->tipo }}</td>
                    <td>{{ $registro->pago }}</td>
                    <td>{{ $registro->duracion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>