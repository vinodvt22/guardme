<?php

namespace Responsive\Http\Middleware;

use Closure;
use Responsive\Message;

class MessagesCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (\Auth::check()){
            $msg_count = Message::where('receiver_id', \Auth::user()->id)
                ->where('status', 0)
                ->count();
            $msg_count = $msg_count?$msg_count:0;
            \View::share('msg_count', $msg_count);
        }
        return $next($request);
    }
}
