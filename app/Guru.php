<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
   protected $table = 'guru';
   protected $fillable = ['nama','telpon','alamat','avatar'];

   public function mapel()
   {
       return $this->hasMany(Mapel::class);
   }

   public function guruAvatar()
   {
       if (!$this->avatar) {
          return asset('images/default.jpeg');
       }return asset('images/'.$this->avatar);
   }
}
