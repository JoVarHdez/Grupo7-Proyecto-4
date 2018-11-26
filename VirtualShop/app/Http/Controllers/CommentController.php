<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Reply;
use Auth;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $content = $request ->input('comment');
            $this->validate(request(), [
                'comment' => 'required'
            ]);
                
            Comment::create([
                'idUser' => Auth::id(),
                'idProduct' => $request -> input('idProduct'),
                'content' => $content,
            ]);
            return redirect() -> back();
        }else{
            return back()->withInput()->with('error','Something wrong');
        }       
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idComment)
    {
        if (Auth::check()) {
            $reply = Reply::where('comment_idComment', $idComment);

            $comment_remove = Comment::where(['idUser' => Auth::id(), 'idComment' => $idComment]);

            if ($reply -> count() > 0 && $comment_remove -> count() > 0) 
            {
                $reply -> delete();
                $comment_remove -> delete();

            }
            else if($comment_remove -> count() > 0)
            {
                $comment_remove->delete();

            }

        }    
        return redirect() -> back();
    }


}
