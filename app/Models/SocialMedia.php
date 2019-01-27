<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $table = 'social_media';
    protected $guarded = [ 'id'];
    protected $fillable = ['name', 'description','url','username','password'];

      public function getMeta()
    {
        return
            $social_media =[
                "id" =>null,
                "name" => null,
                "description" => null,
                "url" => null,
                "username" => null,
                "password" => null,
                "deleted_at" => null,
                "created_at" => null,
                "updated_at" => null];
    }

}
