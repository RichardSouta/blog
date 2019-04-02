# Blog app deployment #
To deploy this application follow these steps:
## Manual deployment ##
1. go to your prepared server with your favorite web server (apache2, nginx), PHP (at least 7.3.3), yarn, composer and DB (preferably MySQL 5.7.25)
2. do one of these where you want your application to live and then chown directory to www-data:
- download `https://github.com/RichardSouta/blog/archive/master.zip` and unwrap it
- setup git and run `git clone https://github.com/RichardSouta/blog.git`
3. run `export SYMFONY_ENV=prod`
4. create database for app
5. run `composer install --no-dev`
6. fill in all parameters (none can be null or empty)
7. run `bin/console doctrine:schema:create`
8. run `bin/console assets:install --symlink`
9. run `bin/console fos:user:create` and fill all
10. run `bin/console fos:user:promote` and fill all (role must be ROLE_ADMIN)
11. modify your webserver to use directory with this app as a root
12. goto url/admin, login and create tags and blog posts

## Docker deployment ##
I strongly recommend to use docker instead of step 1 in manual deployment. You will use the same container for development, CI and all tests servers.
Notice: You won't be using a single container, but instead at least 3 containers and you will be using docker-compose as well.

## TODOs: ##
- write unit tests (at least for all routes) in PHPUnit
- focus on UX and SEO
- frontend as a single page in JS framework (preferably Vue.js)
- write frontend tests (for example in selenium)
- set CI (phpcs, phpstan, run all necessary scripts) and CD (both preferably in SemaphoreCI)
- use tags at git
- use git flow
- use doctrine migrations instead of doctrine schema command
- also fill some data in migrations