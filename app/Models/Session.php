<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Session extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity' 
    ];

    public function getLastLoginAttribute()
    {

        $timeBD = Carbon::parse($this->last_activity); //convert 
        $timeBD->setTimezone('America/Sao_Paulo'); //change to timezone
        return $timeBD->format( 'd-m-Y H:i:s' );  //format
    }


     /**
     * Relantionships
     * Many to Many
     */
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}