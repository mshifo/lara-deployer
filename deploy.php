<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/mshifo/lara-deployer.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('melshafaey.com')
    ->set('remote_user', 'ubuntu')
    ->setIdentityFile('/home/mahmoud/Downloads/MyDevServerKey.pem')
    ->set('deploy_path', '/var/www/html/deployer');

//Tasks
task('deploy:prepare');
task('deploy:lock');
task('deploy:release');
task('deploy:update_code');
task('deploy:shared');
task('deploy:vendors');
task('deploy:writable');

task('artisan:storage:link');
task('artisan:view:clear');
task('artisan:cache:clear');
task('artisan:config:cache');
task('artisan:optimize');
task('deploy:symlink');
task('deploy:unlock');
task('deploy:cleanup');


//Hooks
after('deploy:failed', 'deploy:unlock');
