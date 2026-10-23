<?php require appRoot . '/views/includes/head.php'; ?>
<?php require appRoot . '/views/includes/header.php'; ?>

<main class="storage-page">
    <div class="container">
        <div class="page-heading">
            <div>
                <p class="eyebrow">En equipo</p>
                <h1>Compartidos conmigo</h1>
            </div>
        </div>

        <!-- ruta donde estoy parada -->
        <nav class="breadcrumb-line" aria-label="Ruta de navegación">
            <a href="<?php echo urlRoot; ?>/elements/shared">Compartidos conmigo</a>
            <?php foreach ($data['ruta'] as $c): ?>
                / <a href="<?php echo urlRoot; ?>/elements/shared/<?php echo $c->id; ?>"><?php echo htmlspecialchars($c->nombre); ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="table-responsive storage-table-wrap">
        <table class="table table-hover align-middle storage-table">
            <thead>
                <tr>
                    <th>Clase</th>
                    <th>Nombre</th>
                    <th>Comentario</th>
                    <th>Tipo</th>
                    <th>Peso (MB)</th>
                    <th>Fecha</th>
                    <th>Compartido por</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($data['elementos']) == 0): ?>
                    <tr>
                        <td colspan="7">No hay nada para mostrar</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($data['elementos'] as $e): ?>
                    <tr>
                        <?php if ($e->es_carpeta == 1): ?>
                            <td>Carpeta</td>
                            <td>
                                <a href="<?php echo urlRoot; ?>/elements/shared/<?php echo $e->id; ?>">
                                    <?php echo htmlspecialchars($e->nombre); ?>
                                </a>
                            </td>
                            <td></td>
                            <td>-</td>
                            <td>-</td>
                        <?php else: ?>
                            <td>Archivo</td>
                            <td>
                                <?php if (mimePantalla($e->tipo) != ''): ?>
                                    <a href="<?php echo urlRoot; ?>/elements/open/<?php echo $e->id; ?>" target="_blank">
                                        <?php echo htmlspecialchars($e->nombre); ?>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo urlRoot; ?>/elements/open/<?php echo $e->id; ?>">
                                        <?php echo htmlspecialchars($e->nombre); ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($e->comentario); ?></td>
                            <td><?php echo tipoDocumento($e->tipo); ?></td>
                            <td><?php echo round($e->peso / 1048576, 2); ?></td>
                        <?php endif; ?>
                        <td><?php echo $e->fecha; ?></td>
                        <td><?php echo htmlspecialchars($e->propietario); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</main>

<?php require appRoot . '/views/includes/foot.php'; ?>