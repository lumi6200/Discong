<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body id="style-3">
    <header class="p-3">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-file-post" viewBox="0 0 16 16">
                        <path
                            d="M4 3.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5z" />
                        <path
                            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1" />
                    </svg>
                    <span class="fs-4 fw-bold">Discong</span>
                </a>

                @if (auth()->check())
                <div class="d-flex">
                    <a href="{{ route('profile') }}" style="text-decoration: none;"><span class="fs-5 me-2"
                            style="color: #F6B17A">{{
                            auth()->user()->username }}</span></a>
                    <button class="btn btn-sm btn-link" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">Logout</button>
                </div>

                <!-- Logout confirmation modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Logout Confirmation</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to log out of your account?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <span>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary" type="submit">Logout</button>
                                    </form>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div>
                    <button type="button" class="btn btn-outline-light me-2" data-bs-toggle="modal"
                        data-bs-target="#loginModal">
                        Login
                    </button>
                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#signupModal">
                        Sign up
                    </button>
                </div>
                @endif
            </div>
        </div>
    </header>

    <!-- Display Success and Errors -->
    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 0 12%;">
        {{ session()->get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0 12%;">
        {{ session()->get('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @php
    $errorMessages = [];
    @endphp

    @foreach(['username', 'email', 'password', 'heading', 'body'] as $fieldName)
    @error($fieldName)
    @php
    $errorMessages[] = $message;
    @endphp
    @enderror
    @endforeach

    @if(count($errorMessages) > 0)
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0 12%;">
        <ul>
            @foreach($errorMessages as $errorMessage)
            <li>{{ $errorMessage }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="fw-bold mb-0 fs-2 auth">Login to your account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('loginPost') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Username"
                                autocomplete="off" name="username" required>
                            <label for="floatingInput">Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingInput"
                                placeholder="name@example.com" name="password" required>
                            <label for="floatingInput">Password</label>
                        </div>
                        <p>Don't have an account? Sign up <a href="#" data-bs-toggle="modal"
                                data-bs-target="#signupModal">here</a>.</p>
                        <div class="modal-footer">
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-dark auth-bg"
                                type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="fw-bold mb-0 fs-2 auth">Sign up for free</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('signUpPost') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Username"
                                autocomplete="off" name="username" required>
                            <label for="floatingInput">Username</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="floatingInput"
                                placeholder="name@example.com" autocomplete="off" name="email" required>
                            <label for="floatingInput">Email Address</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingInput"
                                placeholder="name@example.com" name="password" required>
                            <label for="floatingInput">Password</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingInput"
                                placeholder="name@example.com" name="password_confirmation" required>
                            <label for="floatingInput">Confirm Password</label>
                        </div>
                        <div class="modal-footer">
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-dark auth-bg" type="submit">Sign
                                up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- If logged in -->
    @if (auth()->check())
    <div class="bd-example m-5 border-0">
        <div class="card color-template" style="margin: 0 10%;">
            <form action="{{ route('post') }}" method="POST">
                @csrf
                <h5 class="card-header">Write new post</h5>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Heading" name="heading" autocomplete="off"
                            required>
                    </div>
                    <div class="input-group mb-3">
                        <textarea class="form-control" placeholder="Write Something..." name="body" autocomplete="off"
                            required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="bd-example m-5 border-0">
        <div class="card color-template" style="margin: 0 10%;">
            <form>
                <fieldset disabled="">
                    <h5 class="card-header">Log in to your account to write a post</h5>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="disabledInput" placeholder="Heading"
                                name="heading" autocomplete="off">
                        </div>
                        <div class="input-group mb-3">
                            <textarea class="form-control" placeholder="Write Something..." name="body"
                                autocomplete="off"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Post</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
    @endif

    @if (isset($posts) && count($posts) > 0)
    @foreach ($posts->reverse() as $post)
    <div class="bd-example m-5 border-0">
        <div class="card color-template" style="margin: 0 10%;">
            <h5 class="card-header" style="color: #F6B17A">{{ $post->user->username }}</h5>
            <div class="card-body">
                <h5 class="card-title">{{ $post->heading }}</h5>
                <p class="card-text">{{ $post->body }}</p>
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="bd-example m-5 border-0">
        <div class="card color-template" style="margin: 0 10%;">
            <h5 class="card-header">No posts yet</h5>
        </div>
    </div>
    @endif

    <footer class="py-3 my-4">
        <div class="nav justify-content-center border-bottom pb-3 mb-3"></div>
        <p class="text-center text-white">// made by keni</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>