@extends("tickets.template")

@section('content')
    <?php
    $pageTitle = 'Tickets';
        $user = auth()->user();
        $userId = $user->id;
        $userName = $user->name;
       /* $isRole = $user->inRoles([q
            config('guardme.acl.License_partner'),
            config('guardme.acl.Admin'),
            config('guardme.acl.Super_Admin')
        ]); */
    ?>
    <div class="breadcrumb-section">
        <ol class="breadcrumb">
            <li><a href="{{URL::to('/')}}">Home</a></li>
            <li>Support</li>
             <li>Tickets</li>
        </ol>                       
        <h2 class="title">Tickets</h2>
    </div>
    <div class="job-postdetails post-resume">
    <div class="row"> 
        <div class="col-md-8 clearfix">
        <div class="resume-content">
            <div class="profile section clearfix">

                 <a class="btn btn-secondary" href="{{ Route('ticket.create') }}">Create ticket</a>

                    @if (session('type') && session('type') == 'assign')
                        <div class="alert alert-success">
                            Ticket was successfully assigned to you
                        </div>
                    @endif

                   @if ($tickets)
                    <table class="ui table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>State</th>
                                <th>Status</th>
                                <th>Responsible</th>
                                @if ( $user->admin ==1 )

                                    <th>Actions</th>
                                @endif
                              
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                            <tr>
                                <td>
                                    <a href="{{ route('ticket.show', $ticket->id) }}">{{ $ticket->title }}</a>
                                </td>
                                <td>
                                    @if (isset($stateOf[$ticket->state]))
                                        @if ($ticket->state == 0)
                                            <span class="label label-success">{{ $stateOf[$ticket->state] }}</span>
                                        @else
                                            <span class="label label-warning">{{ $stateOf[$ticket->state] }}</span>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    @if (isset($statuses[$ticket->status]))
                                        <span class="label label-{{ $statusClasses[$ticket->status] }}">{{ $statuses[$ticket->status] }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($ticket->responsible_id)
                                        {{ $ticket->userResponsible->name }}
                                    @else
                                        <span>No responsible</span>
                                    @endif
                                </td>
                                    <td>
                                        @if (!$ticket->responsible_id  && $user->admin ==1 )
                                            <form action="{{ route('ticket.update', $ticket->id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT') }}
                                                <input type="hidden" name="type" value="responsible">
                                                <input type="submit" value="Claim ticket" class="btn btn-secondary btn-sm">
                                            </form>
                                        @endif
                                    </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if ($tickets->lastPage() > 1)
                        <ul class="ui pagination">
                            <?php
                                $showOnTheSides = 2;
                                $firstPage = (($tickets->currentPage() - $showOnTheSides) > 0) ? $tickets->currentPage() - $showOnTheSides : 1;
                                $lastPage = (($tickets->currentPage() + $showOnTheSides) > $tickets->lastPage()) ?
                                    $tickets->lastPage() :
                                    $tickets->currentPage() + $showOnTheSides;
                            ?>
                            <li class="page-item"><a class="page-link" href="{{ route('ticket.index') }}"><<</a></li>
                            @for ($i = $firstPage; $i <= $lastPage; $i++)
                                @if ($tickets->currentPage() == $i)
                                    <li class="page-item active" style='margin: 0 5px'><span class="page-link">{{ $i }}</span></li>
                                @else
                                    <li class="page-item" style='margin: 0 5px'><a class="page-link" href="{{ ($i == 1) ? route('ticket.index') : route('ticket.index', ['page' => $i]) }}">{{ $i }}</a></li>
                                @endif
                            @endfor
                            <li class="page-item"><a class="page-link" href="{{ route('ticket.index', ['page' => $tickets->lastPage()]) }}">>></a></li>
                        </ul>
                    @endif

                @endif  
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="section quick-rules">
            <h4>Heading style h4</h4>
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>

            <ul>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
            </ul>
        </div>
    </div>
</div>
</div> 
@endsection

@push('styles')
    <style>
        #page-wrapper {
            position: relative;
        }
        .footer {
            left: 0 !important;
        }
        h1 {
            padding-top: 20px !important;
        }
    </style>
@endpush

@push('scripts')

@endpush