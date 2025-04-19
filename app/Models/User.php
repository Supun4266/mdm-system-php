<?php

  namespace App\Models;

  use Illuminate\Foundation\Auth\User as Authenticatable;
  use Illuminate\Notifications\Notifiable;
  use Illuminate\Database\Eloquent\Relations\HasMany;




  class User extends Authenticatable
  {
      use Notifiable;

      protected $fillable = [
          'name', 'email', 'password', 'is_admin',
      ];

      protected $hidden = [
          'password', 'remember_token',
      ];

      public function brands()
      {
          return $this->hasMany(Brand::class);
      }

      public function categories()
      {
          return $this->hasMany(Category::class);
      }

      public function items()
      {
          return $this->hasMany(Item::class);
      }
  }
