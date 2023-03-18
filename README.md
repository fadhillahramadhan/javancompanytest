Installation

Clone the repository:

Then do a composer install:

composer install

Edit .env file with appropriate credential for your database server. Just edit these two parameter(DB_USERNAME, DB_PASSWORD).

Then create a database named "families" and then do a database migration using this command:

php artisan migrate

Run server

Run server using this command:

php artisan serve

Run (compile) front end scripts

Run this command (any change you make to the HTML, CSS, JavaScript code will be reflected immediately in the page you see in your browser):

npm run dev

Then go to http://localhost:8000 from your browser and see the web application.



