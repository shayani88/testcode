Task: Fetch 5 random users every 5 minutes from https://randomuser.me/api/ and store their details in the database.

    1.Database migrations for users, user_details, and locations tables 
    2.Laravel Scheduler is properly configured on the system.
    3.Create a Custom Artisan Command 
          php artisan make:command FetchRandomUsers
     It will generate a command file app/Console/Commands/FetchRandomUsers.php
     Now create User, UserDetail, Location model.
     Here all the model is included, a signature and description present for the command. Also here all the code is written as per the requirements. 
    4.Register the Command in the Scheduler
        In App\Console\Kernel.php file add the command to the schedule method.
    5.Test the Command
        To test the command php artisan fetch:random-users
    6.Setting Up the Scheduler
        in crobtab schedule the task 
        crontab -e
        * * * * * php /var/www/html/task-scheduler/artisan schedule:run >> /dev/null 2>&1

        the crontab will run every minute to check if there is any task
    7.Create a Public API: 
        Here create a API
        Request:  GET http://127.0.0.1:8000/api/users?city=Alshus&country=&limit=5&fields[]=name&fields[]=city
        It is a Filterable User API
        parameter:
            Key	        Value
            gender	    male
            city	    London
            country	    UK
            limit	    5
            fields[]	name
            fields[]	email
        
        Response:

        [
            {
                "name": "John Doe",
                "email": "john.doe@example.com"
            },
            {
                "name": "Mike Smith",
                "email": "mike.smith@example.com"
            }
        ]


        If we add another fields value, like fields[] city, then in response along with name and email, city will also be added.
        1.To achive this create a Usercontroller.php and Fetch the data.
        2.Add to the route routes/api.php:
        Route::get('/users', [UserController::class, 'filterUsers']);

