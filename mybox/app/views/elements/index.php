<?php require appRoot . '/views/includes/head.php'; ?>
<?php require appRoot . '/views/includes/header.php'; ?>

<main class="row">
    <div class="col-md-10 offset-md-1">
        <h3>Mis carpetas</h3>

        <!-- ruta donde estoy parada -->
        <nav>
            <a href="<?php echo urlRoot; ?>/elements/index">Inicio</a>
            <?php foreach ($data['ruta'] as $c): ?>
                / <a href="<?php echo urlRoot; ?>/elements/index/<?php echo $c->id; ?>"><?php echo htmlspecialchars($c->nombre); ?></a>
            <?php endforeach; ?>
        </nav>
        <br>

        <?php if ($data['error'] != ''): ?>
            <div class="alert alert-danger"><?php echo $data['error']; ?></div>
        <?php endif; ?>

        <!-- crear carpeta -->
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

        <!-- lista de archivos y carpetas -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Clase</th>
                    <th>Nombre</th>
                    <th>Comentario</th>
                    <th>Tipo</th>
                    <th>Peso (MB)</th>
                    <th>Fecha</th>
                    <th>Compartido</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($data['elementos']) == 0): ?>
                    <tr>
                        <td colspan="7">Esta carpeta está vacía</td>
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
                            <td><?php echo htmlspecialchars($e->nombre); ?></td>
                            <td><?php echo htmlspecialchars($e->comentario); ?></td>
                            <td><?php echo tipoDocumento($e->tipo); ?></td>
                            <td><?php echo round($e->peso / 1048576, 2); ?></td>
                        <?php endif; ?>
                        <td><?php echo $e->fecha; ?></td>
                        <td><?php if ($e->compartido > 0) { echo 'Sí'; } else { echo 'No'; } ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require appRoot . '/views/includes/foot.php'; ?>