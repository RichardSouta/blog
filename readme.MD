# Blog app deployment #
To deploy this application follow these steps:
## Manual deployment ##
1. go to your prepared server with your favorite web server (apache2, nginx)
2. do one of these where you want your application to live:
- download `https://github.com/RichardSouta/blog/archive/master.zip` and unwrap it
- setup git and run `git clone https://github.com/RichardSouta/blog.git`
3. run `export SYMFONY_ENV=prod`
4. run `composer install --no-dev`
5. fill in all parameters (none can be null or empty)
 