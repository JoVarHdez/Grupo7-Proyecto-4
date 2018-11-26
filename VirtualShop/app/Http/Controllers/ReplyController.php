<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Reply;
use Auth;

class ReplyController extends Controller
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

            Reply::create([
                'comment_idComment' => $request -> input('idComment'),
                'idUser' => Auth::id(),
                'reply' => $request -> input('reply'),
            ]);

            return redirect() -> back();
        }
        return back()->withInput()->with('error','Something wrong');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::check()) 
        {
            $reply = Reply::where(['idReply' => $id,
                                   'idUser' => Auth::id()]);
            if ($reply->delete())
            {
                return redirect() -> back();
            }
            else
            {
                return 2;
            }
        }
       
        return redirect() -> back();
    }
}
