<?php require appRoot . '/views/includes/head.php'; ?>
<?php require appRoot . '/views/includes/header.php'; ?>

<main class="auth-page">
    <div class="card auth-card">
        <div class="card-header">
            <p class="eyebrow">Qué bueno tenerte de vuelta</p>
            <h1>Ingresar a MyBox</h1>
        </div>
        <div class="card-body">
            <?php if ($data['error'] != ''): ?>
                <div class="alert alert-danger"><?php echo $data['error']; ?></div>
            <?php endif; ?>

            <form action="<?php echo urlRoot; ?>/users/login" method="post">
                <div class="mb-3">
                    <label for="login-usuario" class="form-label">Usuario</label>
                    <input id="login-usuario" type="text" name="txtUsua" maxlength="15" value="<?php echo htmlspecialchars($data['usuario']); ?>" class="form-control" autocomplete="username" required>
                </div>
                <div class="mb-4">
                    <label for="login-contra" class="form-label">Contraseña</label>
                    <input id="login-contra" type="password" name="txtContra" maxlength="15" class="form-control" autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
            <p class="auth-footnote">¿Aún no tienes cuenta? <a href="<?php echo urlRoot; ?>/users/register">Regístrate aquí</a></p>
        </div>
    </div>
</main>

<?php require appRoot . '/views/includes/foot.php'; ?>