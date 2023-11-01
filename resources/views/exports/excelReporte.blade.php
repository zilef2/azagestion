<table>
    <thead>
        <tr>
            <th>Periodo: {{ $fecha }}</th>
        </tr>
        <tr>
            <th>Prestador</th>
            <th>Fecha de ejecución</th>
            <th>OC/OS</th>
            <th>Nombre Empresa</th>

            <th>Tarea</th>
            <th>Clasificación</th>
            <th>Pendiente por aprobacion</th>
            <th>Horas ejecutadas</th>

            <th>Horas Solicitadas</th>
            <th>Horas Aprobadas</th>
            <th>Banco de horas</th>

            <th>factura1</th>
            <th>factura2</th>
            <th>factura3</th>
            <th>factura4</th>

            <th>Municipio</th>
            <th>Requiere transporte (SI, NO)</th>
            <th>Observaciones </th>
            <th>Justificación </th>
        </tr>
    </thead>

    <tbody>
        @foreach($reportes as $item)
            <tr>
                <td>{{ $item->UsuarioName }}</td>
                <td>{{ $item->fecha_ejecucion }}</td>
                <td>{{ $item->ordenCodigo }}</td>
                <td>{{ $item->empresa2 }}</td>

                <td>{{ $item->tarea }}</td>
                <td>{{ $item->clasif }}</td>
                <td>{{ $item->aprobado == 2 ? 'Si' : 'No' }}</td>
                <td>{{ $item->horas }}</td>

                <td>{{ $item->horasaprobadas }}</td>
                <td>{{ $item->horasaprobadasAsigna }}</td>
                <td>{{ $item->bancohoras === 1 ? 'Si' : 'No' }}</td>

                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>

                <td>{{ $item->munici }}</td>
                <td>{{ ($item->requiere_transporte == 1 ? 'Si' : 'No') }}</td>
                <td>{{ $item->observaciones }}</td>
                <td>{{ $item->justificacion }}</td>
            </tr>
        @endforeach
        <tr>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>

            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>{{ $total0 }}</td>

            <td>  </td>
            <td>  </td>
            <td>  </td>
            
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
        </tr> 
    </tbody>
</table>
