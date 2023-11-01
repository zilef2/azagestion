<table>
    <tbody>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
    </tr>
    @foreach($empresa as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->nombre }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
