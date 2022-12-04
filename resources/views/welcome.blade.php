<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
    <title>Horoscopes</title>
</head>
<body>
    
    <nav class="navbar bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                Horoscopes
            </a>
        </div>
    </nav>

    <div class="container overflow-hidden text-center ">
        <div class="row gx-5">
            <div class="col mt-5">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                @endif
                @if(Session::has('message_success'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message_success') }}</p>
                @endif
                <div class="input-group">
                    <form action="{{ route('upload_file') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <div><input type="file" name="file" class="form-control"></div>
                            <div class="ms-2"><button class="btn btn-primary">Upload file</button></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col mt-5">
                <div class="input-group">
                    <form action="{{ route('get_horoscopes') }}" method="GET" enctype="multipart/form-data">
                        <div class="d-flex">
                            <div><input type="date" name="date" class="form-control"></div>
                            <div class="ms-2"><button class="btn btn-secondary">Search</button></div>
                            <div class="ms-2"><a href="{{route('/')}}" class="btn btn-outline-secondary">X</a></div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 my-3">
                    @if(isset($data))
                        @if(count($data) > 0)
                            <div class="d-flex justify-content-around flex-wrap">
                                @foreach ($data as $item)
                                <div class="card mb-3" style="width: 15rem;height:15rem">
                                    <div class="card-body overflow-scroll">
                                        <h5 class="card-title">{{ucFirst($item->zodiac_sign)}}</h5>
                                        <h6 class="card-title">{{\Carbon\Carbon::parse($item->date)->format('d/m/Y')}}</h6>
                                        <p class="card-text" style="font-size: 13px">{{$item->description}}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                   
                        @if(count($data) == 0)
                            <h1 class="mt-4" style="color: rgba(230, 233, 236, 0.631)">No result</h1>
                        @endif
                    @endif
            </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>