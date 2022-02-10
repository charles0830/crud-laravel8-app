<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    /**
     * Relantionships
     * Many to Many: 
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Relantionships
     * Many to Many
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
  
}
