<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
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

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 0 12%;">
        <ul>
            <li>{{ $error }}</li>
            @foreach($errors->all() as $error)
            @endforeach
        </ul>
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


    <div class="modal modal-sheet position-static d-block p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">{{ $user->username }}'s Profile</h1>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form action="{{ route('updatePost') }}" method="POST">
                        @method('patch')
                        @csrf
                        <fieldset disabled="">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control rounded-3" id="floatingInput"
                                    placeholder="name@example.com" value="{{ $user->username}}">
                                <label for="floatingInput">Username</label>
                            </div>
                        </fieldset>

                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="floatingInput"
                                placeholder="name@example.com" value="{{ $user->email }}" name="email" required>
                            <label for="floatingInput">Email address</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingPassword"
                                placeholder="Password" name="current_password" required>
                            <label for="floatingPassword">Current password</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingPassword"
                                placeholder="Password" name="new_password" required>
                            <label for="floatingPassword">New password</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingPassword"
                                placeholder="Password" name="confirm_password" required>
                            <label for="floatingPassword">Confirm new password</label>
                        </div>

                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Update</button>
                    </form>
                    <form action="{{ route('delete') }}" method="post">
                        @method('delete')
                        @csrf
                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-danger" type="submit">Delete</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @if (isset($posts) && count($posts) > 0)
    @foreach ($posts->reverse() as $post)
    <div class="bd-example m-5 border-0">
        <div class="card color-template" style="margin: 0 10%;">
            <form action="{{ route('update', ['post' => $post]) }}" method="POST">
                @method('patch')
                @csrf
                <h5 class="card-header" style="color: #F6B17A">{{ $post->user->username }}</h5>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" value="{{ $post->heading }}" name="heading"
                            autocomplete="off" required>
                    </div>
                    <div class="input-group mb-3">
                        <textarea class="form-control" name="body" autocomplete="off"
                            required>{{ $post->body }}</textarea>
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary me-2">Update</button>
            </form>
            <form action="{{ route('deletePost', ['post' => $post->id]) }}" method="post">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>