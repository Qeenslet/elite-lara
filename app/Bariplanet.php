<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Bariplanet extends Model {

    protected $fillable = ['planet', 'mark', 'distance', 'user_id', 'plandata_id', 'baricenter_id'];

    public function center()
    {
        return $this->belongsTo('App\Baricenter');
    }

}
