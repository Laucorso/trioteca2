<div>
    <div class="container">
        <h1>Crear Nuevo Cliente</h1>
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Nombre del cliente">
            </div>
            
            <div class="mb-3">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone" name="phone" required placeholder="Teléfono del cliente">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Email del cliente">
            </div>

            <button type="submit" class="btn btn-primary">Crear Cliente</button>
            <!--<a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancelar</a>-->
        </form>
    </div>
</div>
