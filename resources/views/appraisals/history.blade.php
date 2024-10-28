<div>
    <h1>Historial de Tasaciones</h1>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Acción</th>
                <th>Cambio</th>
                <th>Usuario</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($audits as $audit)
                <tr>
                    <td>{{ $audit['created_at'] }}</td>
                    <td>{{ $audit['event'] }}</td>
                    <td>{{ json_encode($audit['old_values']) }} → {{ json_encode($audit['new_values']) }}</td>
                    <td>{{ $audit['user_id'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
