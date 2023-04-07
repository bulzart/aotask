<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isPostOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
   if(Post::where("id",$request->route('id'))->exists()){
        if(Post::find($request->route('id'))->user_id == auth()->user()->id){
        return $next($request);   
    }
    else{
        return response("Youre not the owner",401);
    }
}
else{
    return response("Post not found",400);
}
}
}