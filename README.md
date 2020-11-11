# epignosi
A site for handling vacations submissions.

## Install dependecies
To install dependecies ( basically auto-load the app classes ) run:
`php composer.phar update`

## Page Endpoints
* `index.php`: Redirects the users to the `login.php`.
* `login.php`: Login page for admin and employees. If already logged, redirects to `portal.php`.
* `portal.php`: Displays the vacations-list for employees and the users-list for admins.
* `create-user.php`: Allows the admins to create users.
* `edit-user.php?id={user id}`: Allows the admins to edit users.
* `create-vacation.php`: Allows the employees to submit vacations.

## Files Breakdown
* `_db`:
    * `epignosi.sql`: Is the dump of the database.
    * `ER_diagram_db.jpg`: Is the ER diagram of the database.
* `App`: Contains the app custom framework.
    * `Api`: Responses for the API.
    * `Authentication`: Handles the user authentication ( tokens ).
    * `Entities`: Contains entinties classes to handle the database entities.
    * `Mail`: Class to send email notifications.
    * `Security`: Helpers methods to prevent attacks in the site.
    * `App.php`: Main application class. Loads all the necessary classes.
    * `DatabaseConnection.php`: Handles the database conenction.
* `src`: Contains the public files and all the business logic.
    * `assets`: Contains all the app assets ( css, js ). All files will be available in the grand-parent sub-folder. For example the file `/epignosi/src/assets/js/main.js` will be available as `/epignosi/js/main.js`.
    * `actions`: Contains all the actions that the users will do. Basically it contains the API of the app. The actions are available in the grand-parent sub-folder. For example the file `/epignosi/src/actions/login.php` will be available as `/epignosi/actions/logins.php`.
    * `pages`: Contains files/pages that the users can visit. The files are available in the grand-parent sub-folder. For example the file `/epignosi/src/pages/index.php` will be available as `/epignosi/index.php`.
* `.htaccess`: Does the redirection of the files inside the `/src` to the parent folder.

## User Credentials
If you install the dump of database you can login as:
* admin:
    * email: admin@test.com
    * password: 1
* employee:
    * email: employee@employee.com
    * password: 1

## How to set database credentials
To set database credentials you can change the const variables in the `App` class or create these environment variables:
* `DB_SERVER`: The database server. ( Default: localhost )
* `DB_USER`: The user of the database. ( Default: root )
* `DB_PASS`: The password of the database. ( Default: <null> )
* `DB_NAME`: The name of the database. ( Default: epignosi )

## Important notes
* The app to work correctly must be in the top-level folder. For example, if you use XAMPP to test this app. You have to clone in into the `htdocs` folder.
* The email class use as the domain the `localhost`. So the approve and reject links will point there.

These issues could easily be prevented by allowing the user to configure domain and the application path but we have to talk about something during the interview.