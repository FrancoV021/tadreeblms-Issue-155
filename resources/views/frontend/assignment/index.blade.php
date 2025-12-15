<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
</head>

<body>
    <div class="my-5">
        @if(Session::has('message'))
        <div class="col-md-6 m-auto">
            <p class="alert {{ Session::get('alert-class', 'alert-info') }} text-center">{{ Session::get('message') }}</p>
        </div>
        @endif
        <form class="p-5 w-50 m-auto bg-primary" method="POST" action="{{route('online_assessment.verify')}}">
            @csrf
            <input type="hidden" name="url_code" value="{{$assignment->url_code}}">
            <div class="form-group">
                <label for="exampleFormControlInput1">Verification Code</label>
                <input type="text" class="form-control" id="verification_code" required name="verification_code" placeholder="Enter verification code here">
            </div>
            <div class="form-group">
                <button class="btn btn-info" type="submit">Submit</button>
            </div>
        </form>
    </div>

    <script type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
</body>

</html>