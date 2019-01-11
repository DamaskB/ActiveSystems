<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    public static function date_between($start, $end) {
    	return static::where('date', '>=', $start)->where('date', '<=', $end)->orderBy('id', 'desc')->get();
    }

    public static function delete_rec($id) {
    	return static::where('id', '=', $id)->delete();
    }
}
