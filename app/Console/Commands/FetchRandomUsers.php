<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Location;
use Illuminate\Support\Facades\Http;

class FetchRandomUsers extends Command
{
    protected $signature = 'fetch:random-users';
    protected $description = 'Fetch 5 random users and store them in the database';

    public function handle()
    {
        $this->info('Fetching 5 random users...');  // Inform the user that the task is starting
        
        
        $response = Http::get('https://randomuser.me/api/', ['results' => 5]); // Make the API request to fetch random users

        if ($response->successful()) {
            $users = $response->json()['results']; //converts the JSON response from an HTTP request into a PHP associative array.

            foreach ($users as $randomUser) { // Loop through the users and save their data
                
                // Save user details to User table
                $user = User::create([
                    'name' => $randomUser['name']['first'] . ' ' . $randomUser['name']['last'],
                    'email' => $randomUser['email'],
                ]);

                // Save user details
                UserDetail::create([
                    'user_id' => $user->id,
                    'gender' => $randomUser['gender'],
                ]);

                // Save location
                Location::create([
                    'user_id' => $user->id,
                    'city' => $randomUser['location']['city'],
                    'country' => $randomUser['location']['country'],
                ]);
            }

            $this->info('Successfully stored 5 random users!');        // Inform the user that the task was successful

        } else {
            $this->error('Failed to fetch random users. Error: ' . $response->body());        // If the request failed, display an error message

        }
    }
}
