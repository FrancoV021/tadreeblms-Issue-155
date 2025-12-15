<?php

namespace App\Models;

use CustomHelper;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected  $guarded = [];
    protected $table = 'events';

    public static function populateSlugs()
    {
        $existing_news = Events::where('slug', '')->orWhereNull('slug')->get();
        foreach ($existing_news as $value) {
            if (!$value->slug || $value->slug == '') {
                $value->slug = CustomHelper::toSnakeCase($value->title);
                $value->save();
            }
        }
    }
}
