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

            <form action="/books-updated/{{ $specifyBook->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="userId" value="1">
                <label for="title">Created By : {{ $specifyBook->users->name }}</label>

                <div class="mb-3">
                    <label for="title">Title</label>
                    <input type="text" class="form-control border-primary" name="title"
                        value="{{ $specifyBook->title }}" id="title">
                </div>

                <div class="mb-3">
                    <label for="catId">Book Category</label>
                    <select name="catId" id="catId" class="form-control">
                        <option value="{{ $specifyBook->category->id }}">{{ $specifyBook->category->category }}</option>
                        @foreach ($catBooks as $catList)
                            <option value="{{ $catList->id }}">{{ $catList->category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <input type="text" class="form-control border-primary" name="description"
                        value="{{ $specifyBook->description }}" id="description">
                </div>

                <div class="mb-3">
                    <label for="count">Count</label>
                    <input type="number" class="form-control border-primary" name="count"
                        value="{{ $specifyBook->count }}" id="count">
                </div>

                <div class="mb-3">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label for="cover">Preview Before</label>
                                <div class="col d-flex align-items-center">
                                    <iframe src="{{ asset('storage/documents/' . $specifyBook->pdf_file) }}"
                                        frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pdf">PDF File Book</label>
                    <input type="file" class="form-control border-primary" name="pdf" id="pdf">
                </div>



                <div class="mb-3">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <label for="cover">Preview Before</label>
                                <div class="col d-flex align-items-center">
                                    @if ($specifyBook->book_cover != '')
                                        <img src="{{ asset('storage/images/' . $specifyBook->book_cover) }}"
                                            alt="{{ $specifyBook->title . '-' . $specifyBook->book_cover }}"
                                            class="img-fluid rounded-start cover-image">
                                    @else
                                        <img src="/storage/images/default_cover/cover_default.png"
                                            class="img-fluid rounded-start cover-image" alt="...">
                                    @endif
                                </div>
                            </div>

                            <div class="col">
                                <label for="cover">Preview After</label>
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
