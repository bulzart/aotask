<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
 public function createPost(Request $req){
    
    $validator = Validator::make($req->all(),
    [
        'title'=> 'required',
        'content'=> 'required'
    ]);
    if($validator->fails()){
        $error = $validator->errors();
        return response()->json(['error' => $error],400);
    }
    else{
    $post = Post::create([
        'user_id' => auth()->user()->id,
        'title'=>$req->input('title'),
        'content'=>$req->input('content'),
    ]);
    return response()->json(['data'=>$post],201);
}
 }
 public function listAllPosts(){
    return response()->json(['data' => Post::all()],200);
 }
 public function listPost($id){
    return Post::query()->findOrFailWithDefResponse($id);
 }
public function editPostWithId($id,Request $req){
    $validator = Validator::make($req->all(),
    [
        'content'=>'required',
        'title'=>'required'
    ]);
    if(!$validator->fails()){
        $post = Post::whereId($id)->update($req->all());
        return response()->json(["message" =>"Edited"],200);
    }
    else{
        $error = $validator->errors();
        return response()->json(['message' => $error],400);
    }
}
public function deletePost($id){
    Post::destroy($id);
    return response()->json(["message" =>"Deleted"],404);
   
}
public function addComment($id,Request $req)
{
    $validator = Validator::make($req->all(),
    [
        'content'=>'required',
    ]);
    if (Post::where('id', $id)->exists() && !$validator->fails()) {
        $comment = Comment::create(
            [
                'post_id'=>$id,
                'content'=>$req->input('content'),
                'user_id'=> auth()->user()->id
            ]
            );
            return response()->json($comment,201);
    } else {
    return response()->json(['message' => 'Post was not found or content is missing'],400);
    }
 
}
public function listAllPostComments($id){
  return Post::query()->postExistsOrNot($id) ? Post::find($id)->comments : response()->json(["message" =>"Post not found"],404);
}

}
