<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;


class Order extends Model
{
    protected $guarded = [];

   protected static function boot()

    {

        parent::boot();



        static::created(function ($product) {

            $product->slug = $product->createSlug($product->title, $product->id);

            $product->save();

        });




    }

  public function createSlug($title, $id){

        if (static::whereSlug($slug = Str::slug($title))->exists()) {
            $max = static::whereTitle($title)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2".$id;
        }

        return $slug.'-'.$id;

    }
   
}
