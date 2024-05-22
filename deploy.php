<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/JJGT-002/BorsaDeTreball-Backend.git');

add('shared_files', ['database/database.sqlite', '.env']);
add('shared_dirs', ['bootstrap/cache', 'storage']);
add('writable_dirs', ['bootstrap/cache', 'storage']);

// Hosts

host('44.199.122.46')
    ->set('remote_user', 'borsadetreball-back-deploy')
    ->set('identity_file', '~/.ssh/id_rsa')
    ->set('deploy_path', '~/var/www')
    ->set('keep_releases', 3);

task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php8.3-fpm restart');
});

after('deploy', 'reload:php-fpm');
// Hooks

after('deploy:failed', 'deploy:unlock');
