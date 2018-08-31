<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Images</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

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
                /*font-size: 84px;*/
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
           
            <div class="content">
                <div class="title m-b-md">
                    Images
                </div>


                <div>
{{--                     <a href="{{ URL('/images/create') }}">
                        Upload Image
                    </a> --}}
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="file" name="image" id="image">
                        <br>
                        <input type="submit" value="Upload Image" name="submit">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                        {{-- <input type="hidden" name="image" value="{{ $news->id }}" /> --}}
                        {{-- <input type="hidden" name="_method" value="POST" /> --}}
                        <!-- ./ csrf token -->
                    </form>
                </div>


                <div>
                    <ul>
                        @foreach($ret as $r)
                        <li>

                            {{-- <a href="{!! $r->link !!}">{!! $r->metadata['name'] !!}</a> --}}
                            <a href="{{ URL('/images/'.$r->metadata['name']) }}"><img src="{!! $r->link !!}" height="120px"><br>{!! $r->metadata['name'] !!}</a>
                            <br>


                            <form id="delete_{!! $r->metadata['name'] !!}" class="form-horizontal" method="post"
                                action="{{ URL('/images/'.$r->metadata['name']) }}"
                                autocomplete="off">
                                <!-- CSRF Token -->
                                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                                {{-- <input type="hidden" name="image" value="{{ $news->id }}" /> --}}
                                <input type="hidden" name="_method" value="DELETE" />
                                <!-- ./ csrf token -->

                                <button type="submit" class="btn btn-sm btn-danger">
                                    <span class="glyphicon glyphicon-trash"></span> Delete 
                                </button>
                            </form>


                                @endforeach
                            </li>
                        </ul>
                    </div>


            </div>
        </div>

<script type="text/javascript">
    


</script>

    </body>
</html>
