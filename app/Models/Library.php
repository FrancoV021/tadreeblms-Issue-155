<?php

namespace App\Models;

use CustomHelper;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected  $guarded = [];
    protected $table = 'libraries';

    public static function populateSlugs()
    {
        $existing_news = Library::where('slug', '')->orWhereNull('slug')->get();
        foreach ($existing_news as $value) {
            if (!$value->slug || $value->slug == '') {
                $value->slug = CustomHelper::toSnakeCase($value->title);
                $value->save();
            }
        }
    }
}
