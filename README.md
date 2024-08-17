# Installation:

## Prerequisites:
 - Docker running

1. Clone the project:
 - `git clone https://github.com/roninds14/vacation-plan-app.git`

2. In the main project folder rename the file **.env.example** to **.env**.

3. Open a command terminal in the directory where the project was cloned.

4. Run the command to build and start the project:
 - `docker-compose up --build -d`
 
5. Install the Composer dependencies:
 - Run: `docker-compose exec app composer install`.
 - Wait for it to complete; this might take some time.

6. Install Passport:
 - Run: `docker-compose exec app php artisan passport:install`
 - You might see the error: ***ERROR Encryption keys already exist. Use the --force option to overwrite them***. Don’t worry.
 - When asked, ***Would you like to run all pending database migrations?*** answer yes.
 - When asked, ***Would you like to create the 'personal access' and 'password grant' clients?*** answer yes.

7. __Done__! Now you can run the project easily.

Optional:

9. To make your life easier, import the Collection and Environment of the project into Postman. The files are in the main project folder:
 - Collection: **VacationPlan.postman_collection.json**
 - Environment: **VacationPlanEnvironment.postman_environment**
 - PS: Don’t forget to activate the environment.

10. To shut down, run: `docker-compose down -v`