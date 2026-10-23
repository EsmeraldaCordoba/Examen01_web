<?php require appRoot . '/views/includes/head.php'; ?>
<?php require appRoot . '/views/includes/header.php'; ?>

<main class="home-page">
    <div class="container">
        <section class="home-hero">
            <div class="hero-copy">
                <p class="eyebrow">Un espacio para tus archivos</p>
                <h1>Tus archivos.<br>Sin vueltas.</h1>
                <?php if (isLoggedIn()): ?>
                    <p class="hero-description">Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?>. Entra a tus carpetas y sigue donde lo dejaste.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="<?php echo urlRoot; ?>/elements/index">Ir a mis carpetas</a>
                        <a class="hero-secondary-link" href="<?php echo urlRoot; ?>/elements/shared">Ver archivos compartidos</a>
                    </div>
                <?php else: ?>
                    <p class="hero-description">Guarda tus documentos, ordénalos en carpetas y compártelos cuando haga falta.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="<?php echo urlRoot; ?>/users/register">Crear una cuenta</a>
                        <a class="hero-secondary-link" href="<?php echo urlRoot; ?>/users/login">Ya tengo cuenta</a>
                    </div>
                <?php endif; ?>
            </div>

            <p class="hero-aside">Documentos, carpetas y archivos compartidos.<br><span>Todo en un mismo lugar.</span></p>
        </section>

        <section class="home-details" aria-label="Qué puedes hacer con MyBox">
            <div>
                <h2>Guarda</h2>
                <p>Sube tus archivos y consúltalos cuando los necesites.</p>
            </div>
            <div>
                <h2>Organiza</h2>
                <p>Agrupa tus documentos en carpetas a tu manera.</p>
            </div>
            <div>
                <h2>Comparte</h2>
                <p>Da acceso a tus archivos cuando quieras.</p>
            </div>
        </section>
    </div>
</main>

<?php require appRoot . '/views/includes/foot.php'; ?>