@extends('layouts.mainlayout')

@section('content')
    <div class="container">

        {{-- Show Error when inputed the data --}}
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

            <form action="/books-created" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="userId" value="{{ Auth::id() }}">

                <div class="mb-3">
                    <label for="title">Title</label>
                    <input type="text" class="form-control border-primary" name="title" id="title"
                        value="{{ old('title') }}">
                </div>

                <div class="mb-3">
                    <label for="catId">Book Category</label>
                    <select name="catId" id="catId" class="form-control border-primary">
                        <option value="" disabled selected>Select Category</option>
                        @foreach ($catBooks as $catList)
                            <option value="{{ $catList->id }}" {{ old('catId') == $catList->id ? 'selected' : '' }}>
                                {{ $catList->category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <input type="text" class="form-control border-primary" name="description" id="description"
                        value="{{ old('description') }}">
                </div>

                <div class="mb-3">
                    <label for="count">Count</label>
                    <input type="number" class="form-control border-primary" name="count" id="count"
                        value="{{ old('count') }}">
                </div>

                <div class="mb-3">
                    <label for="pdf">PDF File Book</label>
                    <input type="file" class="form-control border-primary" name="pdf" id="pdf">
                </div>

                <div class="mb-3">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label for="cover">Preview Image</label>
                                <div class="col d-flex align-items-center">
                                    <img id="preview" alt="Not Uploaded Image" width="200">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="cover">Book Cover</label>
                    <input type="file" class="form-control border-primary" name="cover" id="cover"
                        onchange="previewImage(this)">
                </div>

                <div class="mb-3">
                    <button class="btn btn-success" type="submit">Save Data</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            var preview = document.getElementById('preview');
            var file = input.files[0];

            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        }
    </script>

@endsection
