durationInTotalSeconds = (parseInt(duration) * 60) - parseInt(elapsed_time);
// Set the date we're counting down to
//var countDownDate = (new Date().getTime()) + (durationInTotalSeconds * 1000);
var countDownDate = (durationInTotalSeconds * 1000);

// Update the count down every 1 second
var now = 0;

var timerCounts = setInterval(function () {

    // Get today's date and time
    // var now = new Date().getTime();
    now += 1000;

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    var elapsed_time_in_sec = distance / 1000;

    if ((elapsed_time_in_sec % 5) == 0) {
        $.ajax({
            type: "POST",
            url: elapsed_url,
            data: ({ elapsed_time: (durationInTotalSeconds - elapsed_time_in_sec) + parseInt(elapsed_time), _token: csrf_token }),
            success: function (data) {
                console.log(data);
            }
        });
    }

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Output the result in an element with id="demo"
    document.getElementById("time_remaining").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

    // If the count down is over, write some text
    if (distance < 0) {
        clearInterval(timerCounts);
        document.getElementById("time_remaining").innerHTML = "EXPIRED";
        all_data = dataCollection();
        $.ajax({
            url: submit_url,
            type: 'post',
            data: {
                _token: csrf_token,
                all_data: JSON.stringify(all_data.get())
            },
            success: function (response) {
                response = JSON.parse(response);
                if (response.status == 200) {
                    if (window.confirm(response.message)) {
                        window.location = home_url;
                    } else {
                        window.location = home_url;
                    }
                }
            },
        });
    }
}, 1000);