<?php

namespace Responsive\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Responsive\Message;
use Responsive\User;


class MessagesController extends Controller
{
    public function messages($id, $to = null)
    {
        if($id!=Auth::user()->id){
            return redirect()->back();
        }
        $ToUser = null;
        if(!is_null($to)){
            $msg = Message::where('receiver_id',$to)->first();
            if (!$msg){
                $ToUser= DB::table('users')->whereid($to)
                    ->first();
            }
        }
        $messages = \Auth::user()->messages;
        $s_ids = $messages->map(function ($msg) use($id){
            return ($id != $msg->sender_id)? $msg->sender_id:'';
        });

        $r_ids = $messages->map(function ($msg) use($id){
            return ($id != $msg->receiver_id)? $msg->receiver_id:'';
        });

        $s_ids = array_filter($s_ids->toArray(), function($value) { return $value !== ''; });
        $r_ids = array_filter($r_ids->toArray(), function($value) { return $value !== ''; });

        $users = User::withCount(['messagesSentUnviewed'])
            ->whereIn('users.id', array_unique($s_ids))
            ->orWhereIn('users.id', array_unique($r_ids))
            ->get();
        $admin = User::where('admin',0)->first();
        return view('messages', compact('users','ToUser','admin'));
    }

    public function sendMessages($id, Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);

        Message::insert([
            'sender_id' => \Auth::user()->id,
            'receiver_id' => $request->reader,
            'msg' => $request->message,
            'status' => 0
        ]);

        return response()->json(1);
    }

    public function seeMessages($id, Request $request)
    {
        Message::where('receiver_id', \Auth::user()->id)
            ->where('sender_id', $request->sender)
            ->update(['status' => 1]);

        return response()->json(1);
    }
}
