@extends('layouts.mainlayout')

@section('content')
    <div class="container">
        <div class="mt-5 col-8 m-auto">
            <form action="/bookscat-updated/{{ $specifyBookCat->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="categoryEdit">Category</label>
                    <input type="text" class="form-control" name="categoryEdit" id="categoryEdit"
                        value="{{ $specifyBookCat->category }}" required>
                </div>

                <div class="mb-3">
                    <button class="btn btn-success" type="submit">Update Data</button>
                </div>
            </form>
        </div>
    </div>
@endsection
