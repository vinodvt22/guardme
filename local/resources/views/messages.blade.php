@extends('layouts.app')
<head>
    @include('style')
</head>
<body>
@include('header')
<div class="container">
    <div class="container inbox_container" style="margin: 100px 0;">
        <div class="row">
            <h1>Inbox</h1>
            <div role="tabpanel">
                <div class="col-sm-3">
                    <ul class="nav nav-pills brand-pills nav-stacked" role="tablist">
                        @if($ToUser)

                            <li role="presentation" class="brand-nav">
                                <a href="#tab{{$ToUser->id}}" data-id="{{$ToUser->id}}"
                                   aria-controls="tab{{$ToUser->id}}" ole="tab" data-toggle="tab">
                                    <img class="account_img small-custom"
                                         src="{{ ('http://www.clearcredentials.com/static/images/userlogin.png')}}"
                                         alt="">
                                    {{ $ToUser->name}}
                                </a>
                            </li>
                        @endif
                        @if(count($users) > 0)
                            @if(\Auth::user()->admin==0)
                                @foreach($users as $user)
                                    <li role="presentation" class="brand-nav">
                                        <a href="#tab{{$user->id}}" data-id="{{$user->id}}"
                                           aria-controls="tab{{$user->id}}"
                                           role="tab" data-toggle="tab">
                                            {{ $user->name }}
                                            @if(count(\Responsive\Message::where(['sender_id'=>$user->id,'status'=>0])->get())>0)
                                                <span class="alert-danger new_msg_admin">New Message</span>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        @endif

                        @if(count($users) >= 0 && \Auth::user()->admin>0)
                            <li role="presentation" class="brand-nav">
                                <a href="#tab{{$admin->id}}" data-id="{{$admin->id}}"
                                   aria-controls="tab{{$admin->id}}"
                                   role="tab" data-toggle="tab">
                                    {{ $admin->name }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="col-sm-9">
                    <div class="tab-content">
                        @if(count($users) > 0)
                            @foreach($users as $user)
                                <div role="tabpanel" class="tab-pane" id="tab{{$user->id}}">
                                    <div class="all_messages">
                                        @foreach(\Auth::user()->messages as $message)
                                            @if($user->id == $message->sender_id || $user->id == $message->receiver_id)
                                                <div class="col-sm-12 messages_area">
                                                    <div class="{{ ($message->sender_id == \Auth::user()->id)?'reader pull-right alert-success':'sender pull-left alert-warning' }}">
                                                        <p>
                                                            {{$message->msg}}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="message_input">
                                        <div class="form-group">
                                            <textarea class="form-control msg_txt" cols="10" rows="3"></textarea>
                                        </div>
                                        <button class="pull-right msg_btn btn btn-info"><span class="fa fa-send"></span>
                                            Send
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                        @elseif(\Auth::user()->admin!==0 && count($users)<=0)
                            <?php
                            $user = \Responsive\User::where('admin', 0)->first();
                            ?>
                            <div role="tabpanel" class="tab-pane" id="tab{{$user->id}}">
                                <div class="all_messages">
                                    @foreach(\Auth::user()->messages as $message)
                                        @if($user->id == $message->sender_id || $user->id == $message->receiver_id)
                                            <div class="col-sm-12 messages_area">
                                                <div class="{{ ($message->sender_id == \Auth::user()->id)?'reader pull-right alert-success':'sender pull-left alert-warning' }}">
                                                    <p>
                                                        {{$message->msg}}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="message_input">
                                    <div class="form-group">
                                        <textarea class="form-control msg_txt" cols="10" rows="3"></textarea>
                                    </div>
                                    <button class="pull-right msg_btn btn btn-info"><span class="fa fa-send"></span>
                                        Send
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if(!empty($ToUser)&&!is_null($ToUser) )
                            <div role="tabpanel" class="tab-pane" id="tab{{$ToUser->id}}"
                                 style="display: block !important;">
                                <div class="all_messages">
                                    @if($ToUser->id)
                                        <div class="col-sm-12 messages_area">
                                            <div class="reader pull-right">
                                                <p>
                                                    Welcome message system
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="message_input">
                                    <div class="form-group">
                                        <textarea class="form-control msg_txt" cols="10" rows="3"></textarea>
                                    </div>
                                    <button class="pull-right msg_btn btn btn-info"><span class="fa fa-send"></span>
                                        Send
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@include('footer')