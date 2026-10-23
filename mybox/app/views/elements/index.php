<?php require appRoot . '/views/includes/head.php'; ?>
<?php require appRoot . '/views/includes/header.php'; ?>

<main class="storage-page">
    <div class="container">
        <div class="page-heading">
            <div>
                <p class="eyebrow">Tu espacio</p>
                <h1>Mis carpetas</h1>
            </div>
        </div>

        <!-- ruta donde estoy parada -->
        <nav class="breadcrumb-line" aria-label="Ruta de navegación">
            <a href="<?php echo urlRoot; ?>/elements/index">Inicio</a>
            <?php foreach ($data['ruta'] as $c): ?>
                / <a href="<?php echo urlRoot; ?>/elements/index/<?php echo $c->id; ?>"><?php echo htmlspecialchars($c->nombre); ?></a>
            <?php endforeach; ?>
        </nav>
        <?php if ($data['error'] != ''): ?>
            <div class="alert alert-danger"><?php echo $data['error']; ?></div>
        <?php endif; ?>

        <?php if ($data['ok'] != ''): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($data['ok']); ?></div>
        <?php endif; ?>

        <!-- crear carpeta -->
        <div class="storage-tools">
        <form action="<?php echo urlRoot; ?>/elements/createFolder/<?php echo $data['idCarpeta']; ?>" method="post" class="row g-2 mb-3">
            <div class="col-auto">
                <input type="text" name="txtNombre" class="form-control" placeholder="Nombre de la carpeta" maxlength="100" required>
            </div>
            <div class="col-auto">
                <input type="submit" value="Crear carpeta" class="btn btn-primary">
            </div>
        </form>

        <!-- subir archivo -->
        <form action="<?php echo urlRoot; ?>/elements/upload/<?php echo $data['idCarpeta']; ?>" method="post" enctype="multipart/form-data" class="row g-2 mb-3">
            <div class="col-auto">
                <input type="file" name="archivo" class="form-control" required>
            </div>
            <div class="col-auto">
                <input type="text" name="txtComentario" class="form-control" placeholder="Comentario (máx. 50)" maxlength="50">
            </div>
            <div class="col-auto">
                <input type="submit" value="Subir archivo" class="btn btn-success">
            </div>
        </form>
        </div>

        <!-- lista de archivos y carpetas -->
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
                    <th>Compartido</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($data['elementos']) == 0): ?>
                    <tr>
                        <td colspan="8">Esta carpeta está vacía</td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($data['elementos'] as $e): ?>
                    <tr>
                        <?php if ($e->es_carpeta == 1): ?>
                            <td>Carpeta</td>
                            <td>
                                <a href="<?php echo urlRoot; ?>/elements/index/<?php echo $e->id; ?>">
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
                        <td>
                            <?php if ($e->compartido > 0) {
                                echo 'Sí (' . htmlspecialchars($e->compartido_con) . ')';
                            } else {
                                echo 'No';
                            } ?>
                        </td>
                        <td>
                            <!-- compartir con otro usuario -->
                            <form action="<?php echo urlRoot; ?>/elements/share/<?php echo $e->id; ?>" method="post" class="d-flex mb-1">
                                <input type="text" name="txtUsuario" class="form-control form-control-sm" placeholder="usuario" maxlength="15" required>
                                <input type="submit" value="Compartir" class="btn btn-outline-primary btn-sm">
                            </form>

                            <!-- borrar -->
                            <?php if ($e->es_carpeta == 1) {
                                $mensaje = '¿Borrar la carpeta y todo lo que tiene adentro?';
                            } else {
                                $mensaje = '¿Borrar este archivo?';
                            } ?>
                            <form action="<?php echo urlRoot; ?>/elements/delete/<?php echo $e->id; ?>" method="post" onsubmit="return confirm('<?php echo $mensaje; ?>');">
                                <input type="submit" value="Borrar" class="btn btn-danger btn-sm">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
</main>

<?php require appRoot . '/views/includes/foot.php'; ?>