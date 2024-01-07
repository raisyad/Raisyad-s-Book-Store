<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ $titles }}</title>
    <style>
      body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            text-align: center;
            background-color: #f1f1f1;
            padding: 20px;
        }

        h1 {
            margin: 0;
        }

        .invoice-details {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }

        .invoice-details td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .invoice-details th {
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f1f1f1;
        }

        .invoice-total {
            margin-top: 30px;
            text-align: right;
        }

        .invoice-total td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .invoice-total th {
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f1f1f1;
        }

        .img-edit {
          display: block;
          margin-left: auto;
          margin-right: auto;
          max-width: 354px;
          max-height: 472px;
          padding-bottom: 10px;
        }
  </style>
</head>
<body>
  <h3>This Book was created By : {{ $bookDetails->users->name }}</h3>
  <header>
    <h1>{{ $bookDetails->title }} Book</h1>
  </header>
  <div class="invoice-content">
      <h2>Data Of Book</h2>
      <div class="img-edit">
        @if ($bookDetails->book_cover)
          <img src="storage/images/{{ $bookDetails->book_cover }}" class="book-cover" alt="Foto" width="220">
        @else
          <img src="storage/images/default_cover/cover_default.png" class="book-cover" alt="Foto" width="220">
        @endif
      </div>
      <table class="invoice-details">
          <tr>
              <th>Title : </th>
              <td>{{ $bookDetails->title }}</td>
          </tr>
          <tr>
              <th>Category : </th>
              <td>{{ $bookDetails->category->category }}</td>
          </tr>
          <tr>
            <th>Description : </th>
            <td>{{ $bookDetails->description }}</td>
          </tr>
          <tr>
              <th>Number of Books : </th>
              <td>{{ $bookDetails->count }}</td>
          </tr>
      </table>
      <p>Data file book on below</p>
  </div>
</body>
</html>