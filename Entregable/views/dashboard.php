<?php $title = "Dashboard"; ?>
<?php include __DIR__ . '/layout/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            <p class="lead">Bienvenido al Sistema de Gestión de Proyectos de TecnoSoluciones S.A.</p>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>Clientes</h4>
                            <h2><?php 
                                $cliente = new Cliente();
                                echo count($cliente->obtenerTodos());
                            ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-3x"></i>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>clientes" class="btn btn-outline-light btn-sm mt-2">Ver Clientes</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>Proyectos</h4>
                            <h2><?php 
                                $proyecto = new Proyecto();
                                echo count($proyecto->obtenerTodos());
                            ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-project-diagram fa-3x"></i>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>proyectos" class="btn btn-outline-light btn-sm mt-2">Ver Proyectos</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>En Progreso</h4>
                            <h2><?php 
                                $proyecto = new Proyecto();
                                $proyectos = $proyecto->obtenerTodos();
                                echo count(array_filter($proyectos, function($p) { return $p['estado'] == 'en_progreso'; }));
                            ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>Completados</h4>
                            <h2><?php 
                                $proyecto = new Proyecto();
                                $proyectos = $proyecto->obtenerTodos();
                                echo count(array_filter($proyectos, function($p) { return $p['estado'] == 'completado'; }));
                            ?></h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-tasks"></i> Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?php echo BASE_URL; ?>clientes/crear" class="btn btn-outline-primary">
                            <i class="fas fa-user-plus"></i> Nuevo Cliente
                        </a>
                        <a href="<?php echo BASE_URL; ?>proyectos/crear" class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> Nuevo Proyecto
                        </a>
                        <a href="<?php echo BASE_URL; ?>reportes/clientes" class="btn btn-outline-info">
                            <i class="fas fa-file-pdf"></i> Reporte de Clientes
                        </a>
                        <a href="<?php echo BASE_URL; ?>reportes/proyectos" class="btn btn-outline-warning">
                            <i class="fas fa-file-pdf"></i> Reporte de Proyectos
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-pie"></i> Estado de Proyectos</h5>
                </div>
                <div class="card-body">
                    <?php 
                    $proyecto = new Proyecto();
                    $proyectos = $proyecto->obtenerTodos();
                    $estados = array_count_values(array_column($proyectos, 'estado'));
                    ?>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h3 class="text-primary"><?php echo $estados['planificacion'] ?? 0; ?></h3>
                                <small>Planificación</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-success"><?php echo $estados['en_progreso'] ?? 0; ?></h3>
                            <small>En Progreso</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h3 class="text-warning"><?php echo $estados['completado'] ?? 0; ?></h3>
                                <small>Completados</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-danger"><?php echo $estados['cancelado'] ?? 0; ?></h3>
                            <small>Cancelados</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layout/footer.php'; ?>