<header class="row">
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?php echo urlRoot; ?>/pages/index">
                    <strong>MyBOX</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
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
                                <a class="nav-link" href="<?php echo urlRoot; ?>/users/logout">Salir</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo urlRoot; ?>/users/login">Ingresar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo urlRoot; ?>/users/register">Registrarse</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>