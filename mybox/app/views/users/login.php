<?php require appRoot . '/views/includes/head.php'; ?>
<?php require appRoot . '/views/includes/header.php'; ?>

<main class="row">
    <div class="card logueo">
        <div class="card-header">
            <strong>Autenticación de Usuarios</strong>
        </div>
        <div class="card-body">
            <?php if ($data['error'] != ''): ?>
                <div class="alert alert-danger"><?php echo $data['error']; ?></div>
            <?php endif; ?>

            <form action="<?php echo urlRoot; ?>/users/login" method="post">
                <fieldset>
                    <label>Usuario:</label>
                    <input type="text" name="txtUsua" size="22" maxlength="15" value="<?php echo htmlspecialchars($data['usuario']); ?>" required /><br>
                    <label>Contraseña:</label>
                    <input type="password" name="txtContra" size="22" maxlength="15" required />
                </fieldset>
                <br>
                <input type="submit" value="Aceptar" />
            </form>
            <br>
            <a href="<?php echo urlRoot; ?>/users/register">Registrarse Aquí</a>
        </div>
    </div>
</main>

<?php require appRoot . '/views/includes/foot.php'; ?>