<p align="center"><a href="https://github.com/TonyOsadolor" target="_blank"><img src="https://osadolor.tinnovations.com.ng/img/relicon.jpg" width="200" height="auto"></a></p>

## About Project => Glimpse 33 Event Booking

Glimpse 33 Event Booking API, is an API collection that helps Companies create Events 
and manage events, with access for participants to register for events.

### Stacks

- **Backend : PHP / Laravel**

## Contribution Guide
##### Setting up your workspace
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

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
