<?php

namespace App\Models\Matchday;

use Illuminate\Database\Eloquent\Model;

class MatchDay extends Model {

    protected $table = "match_days";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'league_id',
        'description',        
        'completed',
    ];

    /**
     * Date attributes.
     *
     * @var array
     */
    protected $dates = ['start_date', 'end_date'];

    /**
     * Is this model linked to any data that would break integrity if it were deleted
     * 
     * @return string
     */
    public function isLinked() {
        return false; //Could be updated to query portal links. For now, we simply return false for testing 02/07/2020
    }

}
