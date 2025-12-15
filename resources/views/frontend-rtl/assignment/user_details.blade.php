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
        <form class="p-5 w-50 m-auto bg-primary" method="POST" action="{{route('online_assessment.store_user_details')}}">
            @csrf
            <input type="hidden" name="assignment_id" value="{{$assignment->id}}">
            <input type="hidden" name="url_code" value="{{$assignment->url_code}}">
            <input type="hidden" name="verify_code" value="{{$assignment->verify_code}}">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required placeholder="Enter First Name">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" required placeholder="Enter Last Name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" maxlength="15" name="phone" required placeholder="Enter Phone Number">
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