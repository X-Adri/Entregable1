<?php $title = "Gestión de Clientes"; ?>
<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1><i class="fas fa-users"></i> Gestión de Clientes</h1>
                <a href="<?php echo BASE_URL; ?>clientes/crear" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Cliente
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Empresa</th>
                                    <th>Teléfono</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($clientes) > 0): ?>
                                    <?php foreach ($clientes as $cliente): ?>
                                        <tr>
                                            <td><?php echo $cliente['id']; ?></td>
                                            <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                                            <td><?php echo htmlspecialchars($cliente['empresa']); ?></td>
                                            <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>clientes/editar/<?php echo $cliente['id']; ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button onclick="eliminarCliente(<?php echo $cliente['id']; ?>)" 
                                                        class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No hay clientes registrados</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function eliminarCliente(id) {
    if (confirm('¿Está seguro de que desea eliminar este cliente?')) {
        fetch('<?php echo BASE_URL; ?>clientes/eliminar/' + id, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar el cliente');
            }
        });
    }
}
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>