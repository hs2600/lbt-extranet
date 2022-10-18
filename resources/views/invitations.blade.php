@extends('layouts.app')

@section('content')

<?php

if(!isset($count)){
    $count = 0;
}

if(!isset($success)){
    $success = '';
} else {
    $success = $success;
}

?>

<div class="container">
    <div class="page-header" style="margin-top: 10px">
        <h1>Invitation Requests</h1>
    </div>
    <div class="card card-default" style="margin-top: 20px">
        <div class="card-header">Pending Requests 
            <span class="badge bg-info text-dark">{{ $count }}</span>
        </div>
        <div class="card-body" style="padding: 0px 10px; padding-bottom: 10px;">
            @if (!empty($invitations))

            <table class="table table-responsive table-striped" style="margin-bottom: 0">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Created At</th>
                        <th>Registered At</th>
                        <th>Invitation Link</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invitations as $invitation)
                    <tr>
                        <td><a href="mailto:{{ $invitation->email }}">{{ $invitation->email }}</a></td>
                        <td>{{ $invitation->created_at }}</td>
                        <td>{{ $invitation->registered_at }}</td>
                        <td>
                            <kbd>{{ $invitation->getLink() }}</kbd>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p>No invitation requests!</p>

            @endif
        </div>
    </div>

    <div class="card card-default" style="margin-top: 20px; padding: 15px 20px;">
        <form class="form-horizontal" method="POST" action="/invitations">
            {{ csrf_field() }}

            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label">E-Mail Address</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus style="width: 300px; margin-top: 5px;">

                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif

                <span class="help-block">
                    <strong style="padding-top: 10px; color: green;">{{ $success }}</strong>
                </span>                

            </div>

            <div class="form-group" style="padding-top: 20px;">

                <button type="submit" class="btn btn-primary">
                    Create Invitation
                </button>

        </form>

    </div>

</div>
@endsection