@extends('layouts.mainlayout')

@section('content')
    <div class="container">
        <a href="/reg-admin" class="btn btn-danger mt-3">
            Add Data Other Admin Account
        </a>
        <table class="table table-dark table-hover mt-3">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Role</th>
                    <th scope="col">Created On</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataUser as $ListAccount)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $ListAccount->name }}</td>
                        <td>{{ $ListAccount->email }}</td>
                        <td>{{ $ListAccount->password }}</td>
                        <td>{{ $ListAccount->type_role }}</td>
                        <td>{{ Carbon\Carbon::parse($ListAccount->created_at)->diffForHumans() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-5">
            {{ $dataUser->withQueryString()->links() }}
        </div>
    </div>
@endsection
