<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Model;

  class Item extends Model
  {
      protected $fillable = ['user_id', 'brand_id', 'category_id', 'code', 'name', 'attachment', 'status'];

      public function user()
      {
          return $this->belongsTo(User::class);
      }

      public function brand()
      {
          return $this->belongsTo(Brand::class);
      }

      public function category()
      {
          return $this->belongsTo(Category::class);
      }
  }
