@extends('layouts.dashboard-template')
  


@section('bread-crumb')
    <div class="breadcrumb-section">
        <ol class="breadcrumb">
            <li><a href="index.html">Home</a></li>
            <li>Jobs</li>
        </ol>                       
        <h2 class="title">
           My Jobs</h2>
    </div>
@endsection
@section('content')
    <div class="profile job-profile">
        <div class="user-pro-section">
            <div class="profile-details section">

                <h2>
                    My Jobs
                </h2>
                @if(Auth::user()->admin==0)
                    <a class="btn pull-right" href="{{URL::route('job.create')}}"> Create Job</a>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                @endif

                @include('shared.message')
                

                <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($my_jobs as $job)
                            <tr>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->description }}</td>
                                <td><a href="{{ route('my.job.applications', ['id' => $job->id]) }}"><button class="btn btn-success">View Applications</button></a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


            </div>
        </div>
    </div>
@endsection















