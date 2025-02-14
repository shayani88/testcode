<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Method to filter users based on query parameters
    public function filterUsers(Request $request)
    {
        // Get query parameters from the request
        $gender = $request->input('gender'); // Gender filter
        $city = $request->input('city'); // City filter
        $country = $request->input('country'); // Country filter
        $limit = $request->input('limit', 100); // Number of records to return (defaults to 100)
        $fields = $request->input('fields', []); // Fields to include in the response (defaults to empty array)

        // Initialize the base query to fetch users with related userDetails and location
        $query = User::query()
            ->with(['userDetails', 'location']); // Eager load related userDetails and location to reduce queries

        // Apply the gender filter if provided in the request
        if ($gender) {
            $query->whereHas('userDetails', function ($q) use ($gender) {
                // Filter users by gender in the userDetails table
                $q->where('gender', $gender);
            });
        }

        // Apply the city filter if provided in the request
        if ($city) {
            $query->whereHas('location', function ($q) use ($city) {
                // Filter users by city in the location table
                $q->where('city', $city);
            });
        }

        // Apply the country filter if provided in the request
        if ($country) {
            $query->whereHas('location', function ($q) use ($country) {
                // Filter users by country in the location table
                $q->where('country', $country);
            });
        }

        // Execute the query with the specified limit and get the filtered users
        $users = $query->limit($limit)->get();

        // Customize the response by mapping each user to the desired fields
        $response = $users->map(function ($user) use ($fields) {
            // Prepare a data array with user attributes
            $data = [
                'name' => $user->name, // User's full name
                'email' => $user->email, // User's email
                'gender' => $user->userDetails->gender ?? null, // User's gender (from userDetails)
                'city' => $user->location->city ?? null, // User's city (from location)
                'country' => $user->location->country ?? null, // User's country (from location)
            ];

            // If specific fields are requested, filter the data array to include only those fields
            return $fields ? array_intersect_key($data, array_flip($fields)) : $data;
        });

        // Return the response as a JSON response
        return response()->json($response);
    }
}
