<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Spatie\Sluggable\HasSlug;
//use Spatie\Sluggable\SlugOptions;
use App\Traits\Slug;

class Category extends Model
{
    //use HasSlug;
    use Slug;

    protected $fillable = ['name','description','slug'];

    /*public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }*/

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
