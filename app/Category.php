<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categorys';

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = ['*'];

    public function record()
    {
        return $this->hasMany('App/Record');
    }

}
