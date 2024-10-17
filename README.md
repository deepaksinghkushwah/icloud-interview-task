php artisan queue:work --queue=<jobname>

For individual job
---------------------
php artisan queue:work --queue=importProcess --timeout=0

php artisan queue:retry all