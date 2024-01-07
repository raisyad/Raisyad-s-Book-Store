@extends('layouts.mainlayout')

@section('content')
    <div class="container">
        <div class="mt-5 col-8 m-auto">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/bookscat-created" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="categoryNew">New Category</label>
                    <input type="text" class="form-control" name="categoryNew" id="categoryNew"
                        value="{{ old('categoryNew') }}">
                </div>

                <div class="mb-3">
                    <button class="btn btn-success" type="submit">Save Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
