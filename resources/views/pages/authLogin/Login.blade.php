<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Login</title>
</head>
<body class="">
  <div class="container-lg mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="text-center">Login</h3>
          </div>
          @if (Session::has('statusCreated'))
            <div class="alert alert-success" id="statusAlert" role="alert">
              {{ Session::get('messageCreated') }}
            </div>
          @endif
          @if ($errors->any())
              <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
              </ul>
              </div>
          @endif
          @if (Session::has('status'))
            {{-- @php
              $status = Session::get('status');
              $alertClass = 'alert-primary';

              if ($status == 'failed') $alertClass = 'alert-danger';
            @endphp --}}
            <div class="alert alert-danger" id="statusAlert" role="alert">
              {{ Session::get('message') }}
              hah
            </div>
          @endif
          <div class="card-body">
            {{ Session::get('message') }}
            <form action="" method="POST">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" id="email" name="email">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="mb-3">
                <p>Don't have account ? Register <a href="/reg">here</a></p>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var statusAlert = document.getElementById('statusAlert');
      
      statusAlert.style.opacity = 1;

      setTimeout(function () {
        fadeOut(statusAlert);
      }, 2000);
    });

    function fadeOut(element) {
      var opacity = 1;
      var timer = setInterval(function () {
        if (opacity <= 0.1) {
          clearInterval(timer);
          element.style.display = 'none';
        }
        element.style.opacity = opacity;
        opacity -= 0.1;
      }, 50);
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
