<?php require appRoot . '/views/includes/head.php'; ?>
<?php require appRoot . '/views/includes/header.php'; ?>

<main class="row">
    <div class="card datos3">
        <div class="card-header">
            <strong>Datos del nuevo usuario</strong>
        </div>
        <div class="card-body">
            <?php if ($data['error'] != ''): ?>
                <div class="alert alert-danger"><?php echo $data['error']; ?></div>
            <?php endif; ?>

            <form action="<?php echo urlRoot; ?>/users/register" method="post">
                <fieldset>
                    <label>Usuario:</label>
                    <input type="text" name="txtUsua" size="22" maxlength="15" value="<?php echo htmlspecialchars($data['usuario']); ?>" required /><br>
                    <label>Contraseña:</label>
                    <input type="password" name="txtContra" size="22" maxlength="15" required /><br>
                    <label>Nombre Completo:</label>
                    <input type="text" name="txtNomb" size="40" maxlength="30" value="<?php echo htmlspecialchars($data['nombre']); ?>" required /><br>
                    <label>Correo Electrónico:</label>
                    <input type="text" name="txtEmail" size="50" maxlength="50" value="<?php echo htmlspecialchars($data['email']); ?>" required /><br>
                </fieldset>
                <br>
                <input type="submit" value="Aceptar" />
            </form>
        </div>
    </div>
</main>

<?php require appRoot . '/views/includes/foot.php'; ?>