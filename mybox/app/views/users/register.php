<?php require appRoot . '/views/includes/head.php'; ?>
<?php require appRoot . '/views/includes/header.php'; ?>

<main class="auth-page">
    <div class="card auth-card auth-card-wide">
        <div class="card-header">
            <p class="eyebrow">Un espacio propio para tus archivos</p>
            <h1>Crea tu cuenta</h1>
        </div>
        <div class="card-body">
            <?php if ($data['error'] != ''): ?>
                <div class="alert alert-danger"><?php echo $data['error']; ?></div>
            <?php endif; ?>

            <form action="<?php echo urlRoot; ?>/users/register" method="post">
                <div class="mb-3">
                    <label for="register-usuario" class="form-label">Usuario</label>
                    <input id="register-usuario" type="text" name="txtUsua" maxlength="15" value="<?php echo htmlspecialchars($data['usuario']); ?>" class="form-control" autocomplete="username" required>
                </div>
                <div class="mb-3">
                    <label for="register-contra" class="form-label">Contraseña</label>
                    <input id="register-contra" type="password" name="txtContra" maxlength="15" class="form-control" autocomplete="new-password" required>
                </div>
                <div class="mb-3">
                    <label for="register-nombre" class="form-label">Nombre completo</label>
                    <input id="register-nombre" type="text" name="txtNomb" maxlength="30" value="<?php echo htmlspecialchars($data['nombre']); ?>" class="form-control" autocomplete="name" required>
                </div>
                <div class="mb-4">
                    <label for="register-email" class="form-label">Correo electrónico</label>
                    <input id="register-email" type="text" name="txtEmail" maxlength="50" value="<?php echo htmlspecialchars($data['email']); ?>" class="form-control" autocomplete="email" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Crear cuenta</button>
            </form>
            <p class="auth-footnote">¿Ya tienes cuenta? <a href="<?php echo urlRoot; ?>/users/login">Ingresa aquí</a></p>
        </div>
    </div>
</main>

<?php require appRoot . '/views/includes/foot.php'; ?>