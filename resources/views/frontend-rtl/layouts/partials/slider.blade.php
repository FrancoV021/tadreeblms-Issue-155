
@php
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="heroslide">
        <div id="main-slider" class="carousel slide main-slider" data-ride="carousel">
            @if(count($slides)>0)
            @foreach($slides as $slide)
            @php
            
            $fileExists = Storage::disk('public')->exists('uploads/'.$slide->bg_image);
            
            @endphp
            
            <div>
                @if(1)
                <img class="d-block w-100 home-first-image" src="{{ asset('storage/uploads/'.$slide->bg_image) }}" alt="First slide">
                @else
                <img class="d-block w-100  home-first-image" src="{{ asset('img/line1.png') }}" alt="{{ $slide->bg_image }}" />
                @endif
            </div>
            @endforeach
            @else
            <div>
                <img class="d-block w-100" src="{{ asset('img/slider1.png') }}" alt="First slide">
            </div>
            @endif

    </div>
</div>

@push('after-scripts')
    <script>
        if ($('.coming-countdown').length > 0) {
            var date = $('.coming-countdown').siblings('.timer-data').data('timer')
            // Specify the deadline date
            var deadlineDate = new Date(date).getTime();
            // var deadlineDate = new Date('2019/02/09 22:00').getTime();

            // Cache all countdown boxes into consts
            var countdownDays = document.querySelector('.days .number');
            var countdownHours = document.querySelector('.hours .number');
            var countdownMinutes = document.querySelector('.minutes .number');
            var countdownSeconds = document.querySelector('.seconds .number');

            // Update the count down every 1 second (1000 milliseconds)
            setInterval(function () {
                // Get current date and time
                var currentDate = new Date().getTime();

                // Calculate the distance between current date and time and the deadline date and time
                var distance = deadlineDate - currentDate;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Insert the result data into individual countdown boxes
                countdownDays.innerHTML = days;
                countdownHours.innerHTML = hours;
                countdownMinutes.innerHTML = minutes;
                countdownSeconds.innerHTML = seconds;

                if (distance < 0) {
                    $('.coming-countdown').empty();
                }
            }, 1000);

        }

    </script>
@endpush