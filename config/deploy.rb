# config valid only for current version of Capistrano
lock '3.4.0'

set :application, 'jorani'
set :repo_url, 'git url'
set :branch, "deployment"

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
# set :deploy_to, '/var/www/my_app_name'

#set :deploy_to, '/var/www/#{fetch(:application)}'
set :deploy_to, '/var/www/jorani'

# Default value for :scm is :git
# set :scm, :git
set :scm, :git
# Default value for :format is :pretty
# set :format, :pretty
set :format, :pretty
# Default value for :log_level is :debug
# set :log_level, :debug
set :user,              "deployer"
set :group,             "www-data"
set :webserver_user,    "www-data"
set :permission_method, :acl
set :use_sudo,          :false
set :copy_dir,          "/tmp/sftp"


# Default value for :pty is false
# set :pty, true
set :pty, true

# Default value for :linked_files is []
# set :linked_files, fetch(:linked_files, []).push('config/database.yml', 'config/secrets.yml')
set :linked_files, fetch(:linked_files, []).push('application/config/database.php')

# Default value for linked_dirs is []
# set :linked_dirs, fetch(:linked_dirs, []).push('log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'vendor/bundle', 'public/system')

# Default value for default_env is {}
#set :default_env, { path: "/opt/ruby/bin:$PATH" }

set :default_env, { path: "~/.rbenv/shims:~/.rbenv/bin:$PATH" }

# rails
set :rails_env, 'production'

# Default value for keep_releases is 5
# set :keep_releases, 5

set :keep_releases, 3


namespace :deploy do

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end
end

  desc 'Restart application'
  task :restart do
    on roles(:app), in: :sequence, wait: 5 do
      execute "sudo /etc/init.d/apache2 restart"  ## -> line you should add
    end
  end

after :deploy, :restart
