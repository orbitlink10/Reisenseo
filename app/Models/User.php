<?php
 
namespace App\Models;
 
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
 
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'fname', 'lname', 'phone', 'user_type', 'about', 'is_kenyan', 'country', 'equity_bank', 'site_id', 'applicant', 'added_by', 'user_id', 'account_status', 'top_ten'
    ];
 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
 
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

         public function is_subadmin(){
        if ($this->user_type == 'subadmin'){
            return true;
        }
        return false;
    }

     public function is_admin(){
        if ($this->user_type == 'admin'){
            return true;
        }
        return false;
    }

    public function is_client(){
        if ($this->user_type == 'client'){
            return true;
        }
        return false;
    }


        public function is_student(){
        if ($this->user_type == 'student'){
            return true;
        }
        return false;
    }

    public function is_writer(){
        if ($this->user_type == 'writer'){
            return true;
        }
        return false;
    }

        public function is_editor(){
        if ($this->user_type == 'editor'){
            return true;
        }
        return false;
    }

            public function is_author(){
        if ($this->user_type == 'author'){
            return true;
        }
        return false;
    }

        /**
     * @param int $s
     * @param string $d
     * @param string $r
     * @param bool $img
     * @param array $atts
     * @return string
     */
    public function get_gravatar( $s = 40, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {

        $email = $this->email;
        $url = 'https://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";

        if( ! empty($this->photo)) {
            $url = avatar_img_url($this->photo, $this->photo_storage);
        }

        if ( $img ) {
            $url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }

        return $url;
    }

     public function message() {
        return $this->hasMany("App\Models\Message");
    }


       protected static function boot()

    {

        parent::boot();



        static::created(function ($user) {

            $user->slug = $user->createSlug($user->name, $user->id);

            $user->save();

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