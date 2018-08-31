<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{!! $image->metadata['name'] !!}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <!-- Styles -->
    <style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Raleway', sans-serif;
        font-weight: 100;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        /*justify-content: center;*/
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 32px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        /*margin-bottom: 30px;*/
    }
</style>
</head>

<body>
    <div class="flex-center position-ref full-height">

        <div class="container">

            <div class="row">
                <a href="{{ URL('/images/')}}"> All images</a>
            </div>
            
            <div class="row">
                <br>
            </div>

            <div class="row">
                <img src="{!! $image->link !!}" height="100%">
            </div>


            <div class="row">

                {!! $image->metadata['name'] !!}

            </div>

            <div class="row">
                <br>
            </div>

            <div class="row">
                <form action="{{ URL('/images/'.$image->metadata['name']) }}" method="post" enctype="multipart/form-data">
                    <input type="file" name="image" id="image">
                    <input type="submit" value="Upload New Image" name="submit">
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <input type="hidden" name="_method" value="PUT" />
                </form>
            </div>

            <div class="row">
                <br>
            </div>

            <div class="row">                           
                <form id="delete_{!! $image->metadata['name'] !!}" class="form-horizontal" method="post"
                    action="{{ URL('/images/'.$image->metadata['name']) }}"
                    autocomplete="off">
                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    <input type="hidden" name="_method" value="DELETE" />
                    <button type="submit" class="btn btn-sm btn-danger">
                        Delete 
                    </button>
                </form>
            </div>


        </div>
    </div>
</body>
</html>
