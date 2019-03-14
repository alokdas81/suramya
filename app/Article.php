<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

Use DB;

class Article extends Model
{
    protected $fillable = [
		'title',
		'details'
	];

	public function getAllArticle()
    {
        $detail = DB::table('articles')->get();
        $detail = $detail->map(function($obj)
                {
                    return (array) $obj;
                })->toArray();
        return $detail;
    }
}
