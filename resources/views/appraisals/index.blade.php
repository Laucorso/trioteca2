<div>
    <h1>Lista de Tasaciones</h1>
    <br>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAppraisalModal">
        Nueva Tasación
    </button>

    <form action="{{ route('appraisals.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="client_name">Nombre del Cliente</label>
                <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Nombre del cliente" value="{{ request('client_name') }}">
            </div>

            <div class="col-md-3">
                <label for="date_from">Desde Fecha</label>
                <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>

            <div class="col-md-3">
                <label for="date_to">Hasta Fecha</label>
                <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>

            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div id="success-message" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Dirección de la Propiedad</th>
                <th>Precio de la Propiedad</th>
                <th>Estado</th>
                <th>Fecha de Creación</th>
                <th>Última Actualización</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($appraisals as $appraisal)
                <tr>
                    <td>{{ $appraisal->client->name ?? 'N/A' }}</td>
                    <td>{{ $appraisal->property_address }}</td>
                    <td>{{ $appraisal->property_price ? '€' . number_format($appraisal->property_price, 2) : 'No disponible' }}</td>
                    <select class="form-control status-selector" data-appraisal-id="{{ $appraisal['id'] }}">
                        @foreach(['Solicitado', 'En proceso', 'Tasación completada', 'Rechazado'] as $status)
                            <option value="{{ $status }}" {{ $appraisal->status == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    <td>
                        <a href="{{ route('appraisals.logs', $appraisal->id) }}" class="btn btn-primary">
                            Ver Logs
                        </a>
                    </td>
                    <!--<td>
                        <a href="{{ route('appraisals.logs', $appraisal->id) }}" class="btn btn-primary">
                            Eliminar
                        </a>
                    </td>-->
                    <td>{{ $appraisal->created_at->format('d-m-Y') }}</td>
                    <td>{{ $appraisal->updated_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No se encontraron tasaciones para los filtros aplicados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $appraisals->links() }} 
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createAppraisalModal" tabindex="-1" aria-labelledby="createAppraisalModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('appraisals.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createAppraisalModalLabel">Nueva Tasación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="client_id" class="form-label">Cliente</label>
                            <select class="form-control" id="client_id" name="client_id" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="property_address" class="form-label">Dirección de la Propiedad</label>
                            <input type="text" class="form-control" id="property_address" name="property_address" required>
                        </div>
                        <div class="mb-3">
                            <label for="property_price" class="form-label">Precio de la Vivienda</label>
                            <input type="number" class="form-control" id="property_price" name="property_price">
                        </div>
                        <div class="mb-3">
                            <label for="comments" class="form-label">Comentarios Adicionales</label>
                            <textarea class="form-control" id="comments" name="comments"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="next_appointment" class="form-label">Próxima Cita</label>
                            <input type="datetime-local" class="form-control" id="next_appointment" name="next_appointment">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Solicitar Tasación</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusSelectors = document.querySelectorAll('.status-selector');

        statusSelectors.forEach(selector => {
            selector.addEventListener('change', function () {
                const appraisalId = this.getAttribute('data-appraisal-id');
                const newStatus = this.value;

                fetch(`/appraisals/${appraisalId}/update`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Estado actualizado correctamente');
                    } else {
                        alert('Error al actualizar el estado');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al actualizar el estado');
                });
            });
        });
    });

    setTimeout(function() {
        var successMessage = document.getElementById('success-message');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 3000);
</script>
