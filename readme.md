Assuming this is all set up correctly, all that should be necessary is editing
the .env file to use the appropriate values to connect to the database (and
use a separate cache driver if that is required - I went with memcached, as it
made the most sense for the use case). Then it's as simple as
'php artisan migrate:refresh --seed', run from the root folder.
