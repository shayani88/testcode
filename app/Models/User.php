<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Use the HasFactory trait to enable factory-based model generation
    use HasFactory;

    // Define the fillable attributes for mass assignment
    protected $fillable = ['name', 'email'];
    
    /**
     * Define a one-to-one relationship with the UserDetail model.
     * 
     * This method allows access to the user's associated details, such as gender.
    
     */
    public function userDetails()
    {
        // This defines the relationship where a user can have one set of details
        return $this->hasOne(UserDetail::class);
    }

    /**
     * Define a one-to-one relationship with the Location model.
     * 
     * This method allows access to the user's associated location, including city and country.
     * 
     */
    public function location()
    {
        // This defines the relationship where a user can have one location (city and country)
        return $this->hasOne(Location::class);
    }
}
