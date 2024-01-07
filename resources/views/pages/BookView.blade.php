@extends('layouts.mainlayoutBookView')

@section('content')
    <div class="container view-contain mt-2">
        <a href="/books" class="btn btn-primary">
            Back
        </a>
        <a class="btn btn-warning" href="/books-detail-download/{{ $bookDetails->id }}">
            Download as PDF
        </a>

        <h3>This Book was created By : {{ $bookDetails->users->name }}</h3>
        <div class="book-container">
            @if ($bookDetails->book_cover)
                <img class="book-cover" src="{{ asset('storage/images/' . $bookDetails->book_cover) }}" alt="Book Cover">
            @else
                <img src="/storage/images/default_cover/cover_default.png"
                    alt="{{ $bookDetails->title . '-' . $bookDetails->book_cover }}" width="200">
            @endif
            <div class="book-details">
                <h1>{{ $bookDetails->title }}</h1>
                <p>Category: {{ $bookDetails->category->category }}</p>
                <p>Description: {{ $bookDetails->description }}</p>
                <p>Quantity: {{ $bookDetails->count }}</p>
            </div>
            <iframe class="pdf-iframe" src="{{ asset('storage/documents/' . $bookDetails->pdf_file) }}"></iframe>
        </div>

    </div>
@endsection
