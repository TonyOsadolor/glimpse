<p align="center"><a href="https://github.com/TonyOsadolor" target="_blank"><img src="https://osadolor.tinnovations.com.ng/img/relicon.jpg" width="200" height="auto"></a></p>

## About Project => Glimpse 33 Event Booking

Glimpse 33 Event Booking API, is an API collection that helps Companies create Events 
and manage events, with access for participants to register for events.

### Stacks

- **Backend : PHP / Laravel**

## Contribution Guide
##### Setting up your workspace
##### Laravel Version => '12.10.2'
Before running this app locally make sure you have the following software installed:
<ul>
    <li>XAMPP/WAMP/LAMP or it's equivalent</li>
    <li>Composer</li>
    <li>Postman for API Testing</li>
</ul>
Now, follow this steps:
<ol>
    <li>Go to https://github.com/TonyOsadolor/glimpse .</li>
    <li>Open your terminal, navigate to your preferred folder and Run: <code>git clone https://github.com/TonyOsadolor/glimpse.git</code>.</li>
    <li>Run <code>composer install</code></li>
    <li>Copy all the contents of the <code>.env.example</code> file. Create <code>.env</code> file and paste all the contents you copied from <code>.env.exmaple</code> file to your <code>.env</code> file.</li>
    <li>Run <code>php artisan key:generate --show</code> to retrieve a base64 encoded string for Laravel's APP_KEY in <code>.env</code></li>
    <li>Set your DB_DATABASE = <code>glimpse</code></li>
    <li>If you are using XAMPP , run it as an administrator. Start Apache and Mysql. Go to <code>localhost/phpmyadmin</code> and create new database and name it <code>glimpse</code>.</li>
    <li>Run php artisan serve from your terminal to start your local server at: <code>http://127.0.0.1:8000/</code> .</li>
</ol>

## Documentation Guide
##### Documentation for the Project
Basic feature of the App built with Laravel Classes includes:
<ol>
    <li>Enum Classes <code>for Uniform naming</code></li>
    <li>Controller Classes</li>
    <li>Middlewares</li>
    <li>Requests</li>
    <li>Resources</li>
    <li>Jobs <code>for running background tasks</code></li>
    <li>Notification <code>handles the mailing</code></li>
    <li>Services <code>for personal preference, I chose services class over repositories</code></li>
    <li>Traits <code>majoring the Response class for returning json responses</code></li>
    <li>Command <code>Make a new Command 'MakeServiceCommand' for handling the auto generation of Service Class</code></li>
</ol>

For the purpose of this project, since we are building an API platform I want 
to make the url 'https://domain/api/v1/', so I installed api plugin, this doesn't come with 
the default Laravel 12 and publish the cors configuration.
<br>
A new folder was created in the routes folder => 'api/v1' then api.php, since we are using Laravel 
"12.10.2" I had to change the configuration inside the bootstrap app.php.
<br>
The api directory points <code>routes/api/v1/api.php</code>, while the apiPrefix <code>'api/v1'</code>

##### Model, Migration and Seeder
Next we will setup the Model and Database migration along by running <code>php artisan make:model Model -m</code>
<br>
After publishing the models and migration, I have to make a seeder for an Admin and Event Category 
bearing in mind that events will have categories, and also though not implemented into this project 
an Admin to oversee the activities of the companies and participants.

##### Routes and Authentications
For this project, keeping things simple, we used the 'users' table for storing all users, which includes
<ol>
    <li>Admins</li>
    <li>Companies</li>
    <li>Participants</li>
</ol>
Also, I want all participants to be registered on the system before they can register for any event.
for the admin route, we prefix '/admin', '/companies' and '/participants' respectively, guarding them 
with <code>'middleware' => ['auth:sanctum', 'verified']</code>.
<br>
The 'auth:sanctum' brings the 'sanctum' tokenazation into play, while the 'verified' ensures that 
Admins, Companies or Participants must verify their email address before they access these protected routes.

##### Registration and Login
Upon Successful Registration a verification code is sent to the registered email, 
for the purpose of this project and testing, this is sent as in verification link, 
once click it verifies the user, and then 
the user is verified and can access all protected 'verified' protected routes.

For Login, Once a successful login is triggered, a token is issued which is used to access the system 
through the 'auth:sanctum'.

##### Companies API Routes
Register [POST] => <code>/api/register</code>
Login [POST] => <code>/api/login</code>
Active Event Categories [GET] => <code>/companies/events-categories</code>
Get Companies Events [GET] => <code>/companies/events</code>
Add new Company Event [POST] => <code>/companies/events</code>
Show an Event [GET] => <code>/companies/events/:eventId</code>
Update an Event [PUT] => <code>/companies/events/:eventId</code>
Delete an Event [DELETE] => <code>/companies/events/:eventId</code>

##### Participants API Routes
Register [POST] => <code>/api/register</code>
Login [POST] => <code>/api/login</code>
Get Active Events [GET] => <code>/participants/events</code>
Show an Event [GET] => <code>/participants/events/:eventId</code>
Get Participants Registered Events [GET] => <code>/participants/events-registered</code>
Register for an Event [POST] => <code>/participants/events/register</code>
Participant View a Registered Event [GET] => <code>/participants/events-registered/:event</code>
Delete Event Registration [DELETE] => <code>/participants/events-registered/:event</code>

##### Used Middleware
Two major middleware were used, and registered in the app.php inside the bootstrap folder
<ul>
    <li>ForceJsonResponse => <code>This forces all response to be in json</code></li>
    <li>
        Company => 
        <code>
            This handles the protection of events, to ensure companies.. must be verified 
            and vetted by the system admin.
        </code>
    </li>
</ul>

##### Resource Calss
This ensure a more modest way of returning model data for a better organization 
and easy accessibility by the FE

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
