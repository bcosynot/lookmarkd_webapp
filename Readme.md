# How to setup


# Codebase

1. Clone the repository on your machine.
1. Make sure you have php and MySQL installed.
1. Install node and npm (https://docs.npmjs.com/getting-started/installing-node) if you don't already have them.
1. Run command `npm install`. This will install all the required dependencies.
1. Run `bower install`.
1. Run `composer update`. You will have to install Composer (https://getcomposer.org/) if not already available before running this command.

## Database

#### Development

If on development machine, run `php app/console doctrine:schema:update --force` this will update your database's schema.

#### Production

If on a production machine, see SQL dump files in `sql` directory. It would be best to run those.

## Running

1. Run `grunt serve`. You are ready to go. This is best for development
1. `grunt build` will preprocess and prepare files for deployment. If you have setup apache or another server to access app.php, you're good to go.
