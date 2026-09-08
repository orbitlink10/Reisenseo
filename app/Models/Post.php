<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Str;



class Post extends Model

{

    use HasFactory;



    protected $guarded = [];



    /**

     * Boot the model.

     */

    protected static function boot()

    {

        parent::boot();



        static::created(function ($product) {

            $product->slug = $product->createSlug($product->title);

            $product->save();

        });




    }



    /** 

     * Write code on Method

     *

     * @return response()

     */

    public function createSlug($title){

        if (static::whereSlug($slug = Str::slug($title))->exists()) {
            $max = static::whereTitle($title)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;

    }




    public function created_at_datetime(){
        $created_date_time = $this->created_at;
        return $created_date_time;
    }

    public function feature_img(){

        //return $this->hasOne(Media::class);
    }

    public function author(){

        return $this->belongsTo(User::class, 'user_id');
    }

}