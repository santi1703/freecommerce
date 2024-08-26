## Freecommerce

- Developed on PHP 8.2.4 and Laravel 10
- The database engine used is MySQL
---
- Once all the previous requirements are running you have to install node and npm for frontend
- Clone the project from https://github.com/santi1703/freecommerce.git
- Access the project's root directory from command line:
    - Run `composer install` to install php dependencies
    - Run `npm install` to install javascript dependencies
    - Run `npm run build` to compile javascript dependencies
- Copy the .env.example file and rename it as .env
- Set the environment variables on the .env file, in particular the DB related ones, you have to set the DB_HOST, DB_PORT, DB_DATABASE, 
- DB_USERNAME and DB_PASSWORD variable to match with an existing database running and (hopefully) empty
---
- Execute `php artisan migrate` in order to migrate the project's tables
- You can execute `php artisan db:seed` to fill up Users table with some generated registers to not feel alone in the system
- There is an user already created, the username and password are admin@freecommerce.com and password, respectively
---
- You will be able to access the project from the public directory from a web browser, on the url provided
by the engine you are running it on (i.e. http://localhost/freecommerce/public); you can further manage the rules
of the engine to redirect to a fancier url

---

We can discuss anything related to the design and decisions made on a meeting if you would like to

Have a nice day :)
