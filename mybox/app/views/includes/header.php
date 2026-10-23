<header class="site-header">
    <nav class="navbar navbar-expand-lg site-navbar">
        <div class="container">
            <a class="navbar-brand site-brand" href="<?php echo urlRoot; ?>/pages/index">
                MyBox<span class="brand-period">.</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Abrir menú">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo urlRoot; ?>/pages/index">Inicio</a>
                    </li>
                    <?php if (isLoggedIn()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo urlRoot; ?>/elements/index">Carpetas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo urlRoot; ?>/elements/shared">Compartidos conmigo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-account" href="<?php echo urlRoot; ?>/users/logout">Salir</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo urlRoot; ?>/users/login">Ingresar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-account" href="<?php echo urlRoot; ?>/users/register">Registrarse</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>