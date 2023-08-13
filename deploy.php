<?php

namespace Deployer;

require 'recipe/laravel.php';

// Config
set('application', 'my-laravel-app');
// Define some shared files and directories
set('shared_files', ['.env']);
set('shared_dirs', ['storage']);
// Define some writable directories
set('writable_dirs', ['bootstrap/cache', 'storage']);
set('allow_anonymous_stats', false);
set('releases_path', '/var/www/html/deployer/releases');
set('current_path', '/var/www/html/deployer/current');
// Set SSH multiplexing to speed up deployments
set('ssh_multiplexing', true);

// Server details
host('melshafaey.com')
    ->set('remote_user', 'ubuntu')
    ->setIdentityFile('/home/mahmoud/Downloads/MyDevServerKey.pem')
    ->set('deploy_path', '/var/www/html/deployer');

// Build task
task('build', function () {
    runLocally('./build.sh');
});

task('deploy:upload', function () {
    // copy over code into release folder
    upload(__DIR__ . '/build/project.zip', '{{releases_path}}/{{release_name}}');
    run('cd {{releases_path}}/{{release_name}} && unzip -o project.zip');

    // Set permissions on release folder
    //run('chmod -R g+w {{releases_path}}/{{release_name}}');
});

task('deploy:update_code', function () {
    // Get latest release name
    $currentRelease = run('ls -t {{releases_path}} | head -n 1');
    // Create current symlink
    run("ln -sfn {{releases_path}}/$currentRelease {{current_path}}");
});

task('deploy:symlink', function () {
    run("cd {{deploy_path}} && rm -rf release"); // Remove release link.
});

// Hooks
before('deploy:setup', 'build');
before('deploy:update_code', 'deploy:upload');
after('deploy:failed', 'deploy:unlock');
