<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class LikeController extends Controller
{
   function toggle(Post $post){
       /** @var User $user */
       $user = auth()->user();
       $likes = $post->likes();

       if($post->isLikeBy($user)){
           $likes->where('user_id',$user->id)->delete();
       }else{
           $likes->create(['user_id'=>$user->id]);
       }

       return back();
   }
}
