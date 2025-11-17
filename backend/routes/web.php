<?php

declare(strict_types=1);

// Rotas públicas (guest)
require __DIR__.'/web/guest.php';

// Rotas do usuário autenticado
require __DIR__.'/web/user.php';

// Rotas do admin
require __DIR__.'/web/admin.php';

// Rotas de autenticação
require __DIR__.'/auth.php';
