<?php require appRoot . '/views/includes/head.php'; ?>
<?php require appRoot . '/views/includes/header.php'; ?>

<main class="row">
    <div class="col-md-8 offset-md-2 text-center">
        <h1><?php echo $data['titulo']; ?></h1>

        <?php if (isLoggedIn()): ?>
            <p>Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?>. Ya iniciaste sesión.</p>
        <?php else: ?>
            <p>Para usar el sitio debe ingresar o registrarse.</p>
        <?php endif; ?>
    </div>
</main>

<?php require appRoot . '/views/includes/foot.php'; ?>