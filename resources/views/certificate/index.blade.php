<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Delta Certificate</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        .head-text {
            font-size: 2rem;
            font-family: math;
        }

        .lines-bg {
            background-image: url('data:image/png;base64,{{ $data['background'] }}');
            background-size: cover;
            background-repeat: no-repeat;
            height: 100%;
            width: auto;
        }

        .mt-1 {
            margin-top: 1rem;
        }

        .mt-3 {
            margin-top: 3rem;
        }

        .fs-1 {
            font-size: 1.5rem;
        }
    </style>
</head>

<body class="lines-bg">

    <div style="position: relative; height: 100vh; width: 100%;"> 

        <div style="
            position: absolute;
            top: 25%;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            width: 100%;
        ">

            <h3 class="head-text">CERTIFICATE OF ATTENDANCE</h3>
            <p class="mt-1 fs-1">Delta Academy certifies that</p>
            <p class="mt-3 fs-1"><b>{{ $data['name'] }}</b></p>

            <p class="mt-1 fs-1">has successfully attended the course of</p>
            <p class="mt-3 fs-1"><b>{{ $data['course_name'] }}</b></p>

            <div class="mt-1 fs-1">
                <label>on</label>
                <span><b>{{ $data['date'] }}</b></span>
            </div>

            <div style="width: 100%; text-align: left; margin-top:60px; margin-left:120px;">
                <img src="data:image/jpeg;base64,{{ $data['qr'] }}" style="width: 7rem;">
            </div>

            <div style="width: 100%; text-align: center; margin-top:-100px;">
                <img src="data:image/jpeg;base64,{{ $data['stamp'] }}" style="width: 7rem;">
            </div>

        </div>

    </div>
</body>



</html>
