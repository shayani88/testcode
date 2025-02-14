<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    // Use the HasFactory trait to enable factory-based model generation
    use HasFactory;

    // Define the fillable attributes for mass assignment
    protected $fillable = ['user_id', 'city', 'country'];

    /**
     * Define an inverse one-to-many relationship with the User model.
     * 
     * This method allows access to the user associated with these location details.
     * 
     */
    public function user()
    {
        // This defines the inverse relationship where Location belongs to one User
        return $this->belongsTo(User::class);
    }
}
