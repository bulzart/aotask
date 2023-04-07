<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Post;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('findOrFailWithDefResponse', function ($id) {
            $post = $this->where('id', $id)->exists();
            return $post ? response()->json(["data" => $this->find($id)],200) : response()->json(["message"=>'Post not found'], 404);
        });
        Builder::macro('postExistsOrNot', function ($id) {
            return $this->where('id', $id)->exists();
          
        });
        
    }
}
