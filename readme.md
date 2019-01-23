# PHP-Selenium

I make this project in order to help my mom to automatically make an appointment with the doctor.
But have not finished automation.
Just send an email to me when found to be available for appointment.

## Configuration
* Xampp
    * PHP = 7.1.11
    * MariaDB = 10.1.28
* Selenium Server = 3.9.1 >> [LINK](http://selenium-release.storage.googleapis.com/index.html?path=3.9/)
* Chrome Driver = 2.4.5 >> [LINK](https://chromedriver.storage.googleapis.com/index.html?path=2.45/)
* JAVA = 8u201 >> [LINK](https://www.oracle.com/technetwork/java/javase/downloads/jdk8-downloads-2133151.html)
(I have been tried 11.0.2LTS. That could not work.)

## Get Started
You should preinstalled "Selenium Server", "Xampp" and "Chrome Driver".  
**Then place "Selenium Server" and "Chrome Driver" at your root of the project.**  
(Remember edit the **selenium-server name** at "app/Http/Controller/EnChuKongController.php". Around line 107.)

(use cmd)
```
git clone https://github.com/Hao1995/PHP-Selenium.git
cd PHP-Selenium
composer install
php artisan key:generate
```
**Database setup**  
Manually add a schema on your phpmyadmin.   
Example: php-selenium.  
Then ... edit your env file.
```
copy .env.example .env
notepad .env

--- Edit your database variables.
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=php-selenium
DB_USERNAME=user
DB_PASSWORD=password
--- Save

php artisan migrate

--- Edit your mail variables. Example: [mailgun](https://www.mailgun.com/)
MAIL_DRIVER=mailgun
MAILGUN_DOMAIN=sandbox1596ce9dd2953ae0b24e7b5r8b69e4b7.mailgun.org //Just example
MAILGUN_SECRET=key-34843d70w6277eb3cbfd1f5e3dddd090 //Just example
MAIL_TARGET=helloWorld@gmail.com //Which email address you want to send.
--- Save
```
**Work Scheduler**  
Set up your schedule work. (Example: windows 10)
![Task Scheduler 工作排程器](http://drive.google.com/uc?export=view&id=1LnqJihTWqjEdskTos4VDStjMIcnrQIRX "task-scheduler")  
Use "F:\xampp\php\php.exe"(your php.exe location) to execute "F:\xampp\htdocs\selenium_Laravel56\artisan"(your project location + \artisan) schedule:run
```
F:\xampp\php\php.exe "F:\xampp\htdocs\selenium_Laravel56\artisan" schedule:run
```

## Demo
![Demo](http://drive.google.com/uc?export=view&id=1T7c-PQt2QAUjSDyoa_PzaVmatmCxjdeO "Demo")  

## References
* facebook/php-webdriver >> [LINK](https://github.com/facebook/php-webdriver)