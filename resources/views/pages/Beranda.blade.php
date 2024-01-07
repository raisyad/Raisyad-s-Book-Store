@extends('layouts.mainlayout')

@section('content')
    <div class="container">
        @if (Auth::user()->role_id != 1)
            <h4 class="mt-2">Hi {{ Auth::user()->name }}, Welcome to Raisyad's Book Store</h4>
            <br>
            <p class="fs-6">*This page only displays some data without being able to filter and carry out other
                processes.</p>
            <p class="fs-6">*If you want to filter and do other processes, visit other pages</p>
            <br>

            {{-- Headers Book Created --}}
            <p class="fs-4 text-primary">Your Book</p>
            <hr class="border border-dark shadow-lg">
            @if ($books->isEmpty())
                {{-- Statement when never created book --}}
                <p class="fs-6">You Never Created Book</p>
            @else
                {{-- Statement when have a created book --}}
                <div class="row mb-2">
                    @foreach ($books as $detail)
                        <div class="col-md-6">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        @if ($detail->book_cover != '')
                                            <img src="storage/images/{{ $detail->book_cover }}"
                                                class="img-fluid rounded-start cover-image" alt="...">
                                        @elseif ($detail->book_cover == '')
                                            <img src="storage/images/default_cover/cover_default.png"
                                                class="img-fluid rounded-start cover-image" alt="...">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <strong
                                                class="d-inline-block mb-2 text-primary-emphasis">{{ $detail->category->category }}</strong>
                                            <h3 class="mb-0">{{ Str::limit($detail->title, 16, '...') }}</h3>
                                            <p class="card-text fs-6"><small
                                                    class="text-body-secondary">{{ $detail->created_at->diffForHumans() }}</small>
                                            </p>
                                            <p class="card-text">{{ Str::limit($detail->description, 32, '...') }}</p>
                                            <p class="fs-6">Number of Books : {{ $detail->count }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- DIBAWAH INI ADALAH SECTION UNTUK ADMIN --}}
        @else
            <h4 class="mt-2">Hi {{ Auth::user()->name }}, Welcome to Raisyad's Book Store Dashboard Admin</h4>
            <br>
            <p class="fs-6">*This page only displays some data without being able to filter and carry out other
                processes.</p>
            <p class="fs-6">*If you want to filter and do other processes, visit other pages</p>
            <br>

            {{-- Headers Book Created --}}
            <p class="fs-4 text-primary">Your Book</p>
            <hr class="border border-dark shadow-lg">
            @if ($books->isEmpty())
                {{-- Statement when never created book --}}
                <p class="fs-6">You Never Created Book</p>
            @else
                {{-- Statement when have a created book --}}
                <div class="row mb-2">
                    @foreach ($books as $detail)
                        <div class="col-md-6">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        @if ($detail->book_cover != '')
                                            <img src="storage/images/{{ $detail->book_cover }}"
                                                class="img-fluid rounded-start cover-image" alt="...">
                                        @elseif ($detail->book_cover == '')
                                            <img src="storage/images/default_cover/cover_default.png"
                                                class="img-fluid rounded-start cover-image" alt="...">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <strong
                                                class="d-inline-block mb-2 text-primary-emphasis">{{ $detail->category->category }}</strong>
                                            <h3 class="mb-0">{{ Str::limit($detail->title, 16, '...') }}</h3>
                                            <p class="card-text fs-6"><small
                                                    class="text-body-secondary">{{ $detail->created_at->diffForHumans() }}</small>
                                            </p>
                                            <p class="card-text">{{ Str::limit($detail->description, 32, '...') }}</p>
                                            <p class="fs-6">Number of Books : {{ $detail->count }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Headers Book Created --}}
            <p class="fs-4 text-primary">All Books Created</p>
            <hr class="border border-dark shadow-lg">
            @if ($allBooks->isEmpty())
                {{-- Statement when never created book --}}
                <p class="fs-6">No book was ever created</p>
            @else
                {{-- Statement when have a created book --}}
                <div class="row mb-2">
                    @foreach ($allBooks as $detail)
                        <div class="col-md-6">
                            <div class="card mb-3" style="max-width: 540px;">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        @if ($detail->book_cover != '')
                                            <img src="storage/images/{{ $detail->book_cover }}"
                                                class="img-fluid rounded-start cover-image" alt="...">
                                        @elseif ($detail->book_cover == '')
                                            <img src="storage/images/default_cover/cover_default.png"
                                                class="img-fluid rounded-start cover-image" alt="...">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <strong
                                                class="d-inline-block mb-2 text-primary-emphasis">{{ $detail->category->category }}</strong>
                                            <h3 class="mb-0">{{ Str::limit($detail->title, 16, '...') }}</h3>
                                            <p class="card-text fs-6"><small
                                                    class="text-body-secondary">{{ $detail->created_at->diffForHumans() }}</small>
                                            </p>
                                            <p class="card-text">{{ Str::limit($detail->description, 32, '...') }}</p>
                                            <p class="fs-6">Number of Books : {{ $detail->count }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
@endsection
