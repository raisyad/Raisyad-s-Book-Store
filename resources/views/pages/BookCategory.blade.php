@extends('layouts.mainlayout')

@section('content')
    <div class="container">
        @if (Auth::user()->role_id == 1)
            <a href="/bookscat-add" class="btn btn-primary mt-3">
                Add Data Book Category
            </a>
        @elseif (Auth::user()->role_id != 1)
            <p class="fs-6 mt-2">List Categories Book</p>
        @endif

        @if (Session::has('statusSuccess'))
            @php
                $status = Session::get('statusSuccess');
                $alertClass = 'alert-primary';

                if ($status == 'inputed') {
                    $alertClass = 'alert-success';
                } elseif ($status == 'updated') {
                    $alertClass = 'alert-primary';
                } elseif ($status == 'deleted') {
                    $alertClass = 'alert-warning';
                }
            @endphp
            <div class="alert {{ $alertClass }}" id="statusAlert" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif


        <table class="table table-dark table-hover mt-3">
            <thead>
                <tr>
                    <th scope="col">No Id</th>
                    <th scope="col">Category</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($catlist as $catsList)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $catsList->category }}</td>
                        <td>
                            <div class="d-flex">
                                @if (Auth::user()->role_id == 1)
                                    <a class="text-decoration-none btn btn-warning mx-2"
                                        href="/bookscat-edit/{{ $catsList->id }}">
                                        Edit
                                    </a>
                                    <form action="/bookscat-deleted/{{ $catsList->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                @elseif (Auth::user()->role_id != 1)
                                    <p class="fs-6 text-danger">Don't have access (Only Admin)</p>    
                                @endif
                            </div>
                            {{-- <a class="text-primary" href="/bookscat-delete/{{ $catsList->id }}">
                Delete
              </a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-5">
            {{ $catlist->withQueryString()->links() }}
        </div>
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
