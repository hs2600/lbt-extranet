@extends('layouts.dashboard')

@section('content')

<?php

if (!isset($count)) {
    $count = 0;
}

if (!isset($success)) {
    $success = '';
} else {
    $success = $success;
}

?>



<section class="section dashboard">
    <div class="row">
        <div class="col-lg-12">
            <h2 style="padding-top: 10px;">Invitation Requests</h2>
            <div class="card">
                <div class="card-header">Pending Requests
                    <span class="badge bg-info text-dark">{{ $count }}</span>
                </div>
                <div class="card-body" style="padding: 10px;">

                    <div class="row" style="--bs-gutter-x: 0rem;">

                        @if (!empty($invitations))

                        <table class="table table-responsive table-striped" style="margin-bottom: 0">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Registered At</th>
                                    <th>Role</th>
                                    <th>Invitation Link</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invitations as $invitation)
                                <tr>
                                    <td><a href="mailto:{{ $invitation->email }}">{{ $invitation->email }}</a></td>
                                    <td>{{ $invitation->created_at }}</td>
                                    <td>{{ $invitation->registered_at }}</td>
                                    <td>{{ $invitation->role }}</td>
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
            </div>

            <div class="card" style="margin-top: 20px; padding: 15px 20px;">

                <form class="form-horizontal" method="POST" action="/invitations" style="padding-bottom: 10px;">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">* E-Mail Address</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus style="width: 300px; margin-top: 5px;">
                        </div>

                        <div class="col-sm">
                            <label for="role" class="control-label">* Role</label>
                            <select id="role" type="text" class="form-control" name="role" required style="width: 300px; margin-top: 5px;">
                                <option value=""></option>
                                <option value="customer">Customer</option>
                                <option value="salesperson">Sales Person</option>
                                <option value="csr">CSR</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="col-sm">
                            <label for="company" class="control-label">Company ID</label>
                            <input id="company" type="text" class="form-control" placeholder="eg. CERA-001" name="company" style="width: 300px; margin-top: 5px;">
                        </div>
                    </div>

                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif

                    <span class="help-block">
                        <strong style="padding-top: 10px; color: green;">{{ $success }}</strong>
                    </span>

                    <div class="form-group" style="padding-top: 20px;">
                    <span style="margin-right: 30px; font-size: 12px;"></i>* = Required</i></span>
                        <button type="submit" class="btn btn-primary">
                            Create Invitation
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</section>
@endsection