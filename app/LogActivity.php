<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class LogActivity extends Model

{

    /**

     * The attributes that are mass assignable.

     *

     * @var array

     */
    protected $table = 'log_activities';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [

        'subject', 'url', 'method', 'ip', 'agent', 'user_id', 'referer'

    ];

}