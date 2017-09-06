[ ![Codeship Status for thakurroxxx/backend](https://codeship.com/projects/9b1d5190-b7c9-0133-ab74-4a886ebdee0b/status?branch=master)](https://codeship.com/projects/134884)
# How to setup


## Codebase

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

1. Make sure `app/config/parameters.yml` is setup. It should contain at least the same set of configuration as in `app/config/paramters.yml.dist`
1. You will also need to setup an Instagram client.  Go to https://instagram.com/developer/clients/manage/ and create a new client.
1. Make sure the redirect URL is setup as ` http://localhost:8000/login/check-insta ` and your website URL is  ` http://localhost:8000 `
1. The client ID and client secret received after setting up the new instagram client should be copy-pasted into your `parameters.yml` file. 
1. Run `grunt serve`. You are ready to go. This is best for development.
1. `grunt build` will preprocess and prepare files for deployment. If you have setup apache or another server to access app.php, you're good to go.


## Branching

See Branching.md for more info.


## Deployment

Deployments are currently made by pulling and building the code on the server. Steps are as follows:

1. Login to the EC2 server.
1. Navigate to the respective directory. Right now they are:
	1. Staging: /home/ubuntu/www/poptates.lookmarkd.com

    1. Production: /home/ubuntu/www/lookmarkd.com
    
1. Inside the directory pull the from the repository and the respective branch. 

1. Run `grunt build`. 