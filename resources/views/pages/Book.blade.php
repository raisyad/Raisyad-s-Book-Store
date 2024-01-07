@extends('layouts.mainlayout')

@section('content')
    <div class="container">
        {{-- Headers Book Created --}}
        @if (Session::has('status'))
            @php
                $status = Session::get('status');
                $alertClass = '';
                $flags = false;

                if ($status == 'inputed') {
                    $alertClass = 'alert-success';
                    $flags = true;
                } elseif ($status == 'updated') {
                    $alertClass = 'alert-primary';
                    $flags = true;
                } elseif ($status == 'deleted') {
                    $alertClass = 'alert-warning';
                    $flags = true;
                }
            @endphp
            @if ($flags)
                <div class="alert {{ $alertClass }}" id="statusAlert" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif
        @endif

        <div class="col mt-2">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <p class="fs-4 text-primary">Your Book</p>
                </div>
                <div class="col-md-6 col-sm-12 d-flex justify-content-end">
                    <a href="/books-add" class="btn btn-primary text-center">
                        Add Data Book
                    </a>
                </div>
            </div>
        </div>
        <hr class="border border-dark shadow-lg">
        {{-- INI ADALAH SECTION BUKAN ADMIN --}}
        @if (Auth::user()->role_id != 1)
            @if (Session::get('flashData'))
                @php
                    $flashData = Session::get('flashData');
                    $message = '';
                    $flag = false;

                    if (isset($flashData['status1']) && isset($flashData['message1'])) {
                        $flag = true;
                        $message = $flashData['message1'];
                    }
                @endphp

                @if ($flag)
                    <p class="fs-6">{{ $message }}</p>
                @endif
            @endif
            {{-- !$books->isEmpty() --}}
            @php
                $flashData = Session::get('flashData');
                $showDatas = true;

                if (isset($flashData['status1']) && isset($flashData['message1'])) {
                    $showDatas = false;
                }
            @endphp
            @if ($books && $showDatas)
                {{-- Statement when have a created book --}}
                <div class="my-3 col-12 col-sm-6 col-md-4">
                    <form action="">
                        <div class="input-group mb-3">
                            <select name="catId" id="catId" class="form-control border-primary"
                                id="floatingInputGroup1">
                                <option value="" disabled selected>Filter Category</option>
                                {{-- <option value="12">Hihah</option> --}}
                                @foreach ($booksCat as $catList)
                                    <option value="{{ $catList->id }}"
                                        {{ old('catId') == $catList->id ? 'selected' : '' }}>{{ $catList->category }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="input-group-text btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
                @if (Session::get('flashData'))
                    @php
                        $flashData = Session::get('flashData');
                        $message = '';
                        $flagS = false;

                        if (isset($flashData['status']) && isset($flashData['message'])) {
                            if ($flashData['status'] == 'nullDataYourBook') {
                                $flagS = true;
                                $message = $flashData['message'];
                            }
                        }
                    @endphp

                    @if ($flagS)
                        <p class="fs-6">{{ $message }}</p>
                    @endif
                @endif
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
                                            <p class="card-text">{{ Str::limit($detail->description, 35, '...') }}</p>
                                            <p class="fs-6">Number of Books : {{ $detail->count }}</p>
                                            <div class="d-flex">
                                                <a class="text-decoration-none btn btn-primary"
                                                    href="/books/{{ $detail->id }}/detail-view">
                                                    Detail View
                                                </a>
                                                <a class="text-decoration-none btn btn-warning mx-2"
                                                    href="/books-edit/{{ $detail->id }}">
                                                    Edit
                                                </a>
                                                <form action="/books-deleted/{{ $detail->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="my-5">
                {{ $books->withQueryString()->links() }}
            </div>

            {{-- DIBAWAH INI ADALAH SECTION UNTUK ADMIN --}}
        @else
            @if (Session::get('flashData'))
                @php
                    $flashData = Session::get('flashData');
                    $message = '';
                    $flagS = false;

                    if (isset($flashData['status1']) && isset($flashData['message1'])) {
                        $flagS = true;
                        $message = $flashData['message1'];
                    }
                @endphp

                @if ($flagS)
                    <p class="fs-6">{{ $message }}</p>
                @endif
            @endif
            @php
                $flashData = Session::get('flashData');
                $flag = false;
                $showDatasYourAdmin = true;

                if (isset($flashData['status1']) && isset($flashData['message1'])) {
                    $flagS = true;
                    $showDatasYourAdmin = false;
                    $message = $flashData['message1'];
                }
            @endphp
            @if ($books && $showDatasYourAdmin)
                {{-- Statement when have a created book --}}
                <div class="my-3 col-12 col-sm-6 col-md-4">
                    <form action="">
                        <div class="input-group mb-3">
                            <select name="catId" id="catId" class="form-control border-primary"
                                id="floatingInputGroup1">
                                <option value="" disabled selected>Filter Category</option>
                                {{-- <option value="12">Hihah</option> --}}
                                @foreach ($booksCat as $catList)
                                    <option value="{{ $catList->id }}"
                                        {{ old('catId') == $catList->id ? 'selected' : '' }}>{{ $catList->category }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="input-group-text btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
                @if (Session::get('flashData'))
                    @php
                        $flashData = Session::get('flashData');
                        $message = '';
                        $flagS = false;

                        if (isset($flashData['status']) && isset($flashData['message'])) {
                            if ($flashData['status'] == 'nullDataYourBook') {
                                $flagS = true;
                                $message = $flashData['message'];
                            }
                        }
                    @endphp

                    @if ($flagS)
                        <p class="fs-6">{{ $message }}</p>
                    @endif
                @endif
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
                                            <p class="card-text">{{ Str::limit($detail->description, 35, '...') }}</p>
                                            <p class="fs-6">Number of Books : {{ $detail->count }}</p>
                                            <div class="d-flex">
                                                <a class="text-decoration-none btn btn-primary"
                                                    href="/books/{{ $detail->id }}/detail-view">
                                                    Detail View
                                                </a>
                                                <a class="text-decoration-none btn btn-warning mx-2"
                                                    href="/books-edit/{{ $detail->id }}">
                                                    Edit
                                                </a>
                                                <form action="/books-deleted/{{ $detail->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="my-5">
                {{ $books->withQueryString()->links() }}
            </div>


            {{-- Headers Book Created --}}
            <p class="fs-4 text-primary">All Books Created</p>
            <hr class="border border-dark shadow-lg">
            {{-- Statement when never created book --}}
            @if (Session::get('flashData'))
                @php
                    $flashData = Session::get('flashData');
                    $message = '';
                    $flagS = false;

                    if (isset($flashData['status']) && isset($flashData['message'])) {
                        $flagS = true;
                        $message = $flashData['message'];
                    }
                @endphp

                @if ($flagS)
                    <p class="fs-6">{{ $message }}</p>
                @endif
            @endif
            @php
                $flashData = Session::get('flashData');
                $flag = false;
                $showDatasAllAdmin = true;

                if (isset($flashData['status1']) && isset($flashData['message1'])) {
                    $flagS = true;
                    $showDatasAllAdmin = false;
                    $message = $flashData['message1'];
                }
            @endphp
            {{-- @if (!$allBooks) --}}
            {{-- <p class="fs-6">No book was ever created</p> --}}
            @if ($allBooks && $showDatasAllAdmin)
                {{-- Statement when have a created book --}}
                <div class="my-3 col-12 col-sm-6 col-md-4">
                    <form action="">
                        <div class="input-group mb-3">
                            <select name="catIdAllBooks" id="catIdAllBooks" class="form-control border-primary"
                                id="floatingInputGroup1">
                                <option value="" disabled selected>Filter Category</option>
                                {{-- <option value="12">Hihah</option> --}}
                                @foreach ($booksCat as $catList)
                                    <option value="{{ $catList->id }}"
                                        {{ old('catIdAllBooks') == $catList->id ? 'selected' : '' }}>
                                        {{ $catList->category }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="input-group-text btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
                @if (Session::get('flashData'))
                    @php
                        $flashData = Session::get('flashData');
                        $message = '';
                        $flag = false;

                        if (isset($flashData['status']) && isset($flashData['message'])) {
                            $flag = true;
                            $message = $flashData['message'];
                        }
                    @endphp

                    @if ($flag)
                        <p class="fs-6">{{ $message }}</p>
                    @endif
                @endif
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
                                            <p class="card-text">{{ Str::limit($detail->description, 35, '...') }}</p>
                                            <p class="fs-6">Number of Books : {{ $detail->count }}</p>
                                            <div class="d-flex">
                                                <a class="text-decoration-none btn btn-primary"
                                                    href="/books/{{ $detail->id }}/detail-view">
                                                    Detail View
                                                </a>
                                                <a class="text-decoration-none btn btn-warning mx-2"
                                                    href="/books-edit/{{ $detail->id }}">
                                                    Edit
                                                </a>
                                                <form action="/books-deleted/{{ $detail->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="my-5">
                {{ $allBooks->withQueryString()->links() }}
            </div>
        @endif

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var statusAlert = document.getElementById('statusAlert');

            statusAlert.style.opacity = 1;

            setTimeout(function() {
                fadeOut(statusAlert);
            }, 2000);
        });

        function fadeOut(element) {
            var opacity = 1;
            var timer = setInterval(function() {
                if (opacity <= 0.1) {
                    clearInterval(timer);
                    element.style.display = 'none';
                }
                element.style.opacity = opacity;
                opacity -= 0.1;
            }, 50);
        }
    </script>
@endsection
