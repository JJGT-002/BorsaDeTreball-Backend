<?php
namespace Deployer;

require 'recipe/laravel.php';

// Configuración
set('repository', 'https://github.com/BorsaDeTreball-ProyectoFinal/BorsaDeTreball-Backend.git');

add('shared_files', ['.env', 'docker-compose.yml']);
add('shared_dirs', ['storage', 'public/uploads']);
add('writable_dirs', ['bootstrap/cache', 'storage']);

// Hosts
host('18.211.111.52')
    ->set('remote_user', 'ubuntu')
    ->set('identityFile', '/home/batoi/Escritorio/DDAW-KEY-PROJECTEG1.pem')
    ->set('deploy_path', '/var/www/BolsaTrabajoBatoi/html/');

// Hooks
after('deploy:failed', 'deploy:unlock');

// Tarea para subir el archivo .env
task('upload:env', function () {
    upload('.env.production', '{{deploy_path}}/shared/.env');
})->desc('Environment setup');

// Tarea para recargar PHP-FPM
task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php8.2-fpm restart');
});
// Inclusión en el ciclo de despliegue
after('deploy', 'reload:php-fpm');
