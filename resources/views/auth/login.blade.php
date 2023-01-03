<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | SignIn</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="login-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mx-auto">
                    <div class="login-form shadow-lg p-4 rounded">
                        <h4 class="text-center mb-3">Admin Login</h4>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <input type="text" name="username" value="{{ old('username') }}" class="form-control mb-3 @error('username') is-invalid @enderror" placeholder="username">
                            @error('username')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                            @enderror
                            <input type="password" value="{{ old('password') }}" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="password">
                            @error('password')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                            @enderror
                            <input type="submit" class="form-control btn btn-dark mt-2" value="Sign In">
                            <hr>
                            <h3 class="text-center"><i class="fa fa-paw"></i> IBS Admin</h3>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
</body>
</html>