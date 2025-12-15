<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment</title>
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .box-shadow {
            box-shadow: 0 2px 15px rgb(0 0 0 / 20%);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-9 box-shadow m-auto p-4">
                <form class="" method="POST">
                    @foreach($assignment_questions as $key => $value)
                    @if ($value->question_type == 1)
                    <div class="form-group mg_form border-bottom py-4 mb-0">
                        <h5 class="mb-3 mg_question_detail" data-question-id="{{$value->id}}" data-question-type="{{$value->question_type}}"><?= $value->question_text ?></h5>
                        <ul class="list-inline" data-question-id="{{$value->question_id}}" data-question-type="{{$value->question_type}}">
                            <li class="list-inline-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" <?= $value->is_correct == 1 ? "checked" : "" ?> <?= $value->is_correct != 0 ? "disabled" : "" ?> name="mg_answer_question_{{$value->id}}" id="mg_question_{{$value->id}}_1" value="1">
                                    <label class="form-check-label" for="mg_question_{{$value->id}}_1">
                                        <div class="btn btn-sm btn-success">Correct</div>
                                    </label>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" <?= $value->is_correct == 2 ? "checked" : "" ?> <?= $value->is_correct != 0 ? "disabled" : "" ?> name="mg_answer_question_{{$value->id}}" id="mg_question_{{$value->id}}_2" value="2">
                                    <label class="form-check-label" for="mg_question_{{$value->id}}_2">
                                        <div class="btn btn-sm btn-danger">Incorrect</div>
                                    </label>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="btn btn-sm btn-info mg_view_solution" data-toggle="modal" data-target="#myModal">View Solutions</div>
                            </li>
                        </ul>
                        @foreach ($value->options as $op_key => $op_value)
                        <div class="form-check">
                            <input class="form-check-input" <?= $op_value->id == $value->answer ? "checked" : "" ?> disabled type="radio" name="mg_options_{{$value->id}}" id="mg_options_{{$op_value->id}}" value="{{$op_value->id}}">
                            <label class="form-check-label" for="mg_options_{{$op_value->id}}">
                                <?= $op_value->option_text ?>
                            </label>
                        </div>
                        @endforeach

                    </div>
                    @elseif ($value->question_type == 2)
                    <?php $user_answer = json_decode($value->answer) ?>
                    <div class="form-group mg_form border-bottom py-4 mb-0">
                        <h5 class="mb-3 mg_question_detail" data-question-id="{{$value->id}}" data-question-type="{{$value->question_type}}"><?= $value->question_text ?></h5>
                        <ul class="list-inline" data-question-id="{{$value->question_id}}" data-question-type="{{$value->question_type}}">
                            <li class="list-inline-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" <?= $value->is_correct == 1 ? "checked" : "" ?> <?= $value->is_correct != 0 ? "disabled" : "" ?> name="mg_answer_question_{{$value->id}}" id="mg_question_{{$value->id}}_1" value="1">
                                    <label class="form-check-label" for="mg_question_{{$value->id}}_1">
                                        <div class="btn btn-sm btn-success">Correct</div>
                                    </label>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" <?= $value->is_correct == 2 ? "checked" : "" ?> <?= $value->is_correct != 0 ? "disabled" : "" ?> name="mg_answer_question_{{$value->id}}" id="mg_question_{{$value->id}}_2" value="2">
                                    <label class="form-check-label" for="mg_question_{{$value->id}}_2">
                                        <div class="btn btn-sm btn-danger">Incorrect</div>
                                    </label>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="btn btn-sm btn-info mg_view_solution" data-toggle="modal" data-target="#myModal">View Solutions</div>
                            </li>
                        </ul>
                        @foreach ($value->options as $op_key => $op_value)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" <?= in_array($op_value->id, $user_answer) ? "checked" : "" ?> disabled name="mg_options_{{$value->id}}" id="mg_options_{{$op_value->id}}" value="{{$op_value->id}}">
                            <label class="form-check-label" for="mg_options_{{$op_value->id}}">
                                <?= $op_value->option_text ?>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @elseif ($value->question_type == 3)
                    <div class="form-group mg_form py-4">
                        <h5 class="mb-3 mg_question_detail" data-question-id="{{$value->id}}" data-question-type="{{$value->question_type}}"><?= $value->question_text ?></h5>
                        <ul class="list-inline mg_answer_check" data-question-id="{{$value->question_id}}" data-question-type="{{$value->question_type}}">
                            <li class="list-inline-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" <?= $value->is_correct == 1 ? "checked" : "" ?> <?= $value->is_correct != 0 ? "disabled" : "" ?> name="mg_answer_question_{{$value->id}}" id="mg_question_{{$value->id}}_1" value="1">
                                    <label class="form-check-label" for="mg_question_{{$value->id}}_1">
                                        <div class="btn btn-sm btn-success">Correct</div>
                                    </label>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" <?= $value->is_correct == 2 ? "checked" : "" ?> <?= $value->is_correct != 0 ? "disabled" : "" ?> name="mg_answer_question_{{$value->id}}" id="mg_question_{{$value->id}}_2" value="2">
                                    <label class="form-check-label" for="mg_question_{{$value->id}}_2">
                                        <div class="btn btn-sm btn-danger">Incorrect</div>
                                    </label>
                                </div>
                            </li>
                            <li class="list-inline-item">
                                <div class="btn btn-sm btn-info mg_view_solution" data-toggle="modal" data-target="#myModal">View Solutions</div>
                            </li>
                        </ul>
                        <textarea class="form-control" id="mg_options_{{$value->id}}" rows="3" name="mg_options_{{$value->id}}" readonly><?= $value->answer ?></textarea>
                    </div>
                    @endif
                    @endforeach
                    <button type="button" class="btn btn-primary mg_all_submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Solution</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body mg_solution_text">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript" src="{{asset('assets/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script>
        var flag = [];

        function dataCollection() {
            flag = [];
            var all_data = $(".mg_form").map(function() {
                var question_id = $(this).first().find(".mg_question_detail").attr('data-question-id');
                var is_correct = $(this).first().find('input[name^=mg_answer_question]:checked').val();
                if (is_correct == undefined) {
                    flag.push(0);
                    console.log(is_correct);
                }
                return {
                    'question_id': question_id,
                    'is_correct': is_correct
                };
            });
            return all_data;
        }
        $(document).on('click', '.mg_all_submit', function() {
            all_data = dataCollection();
            if (flag.includes(0)) {
                alert('Please submit all the answers');
            } else {
                console.log(all_data);
                $.ajax({
                    url: "{{route('admin.assessment_accounts.submit_result')}}",
                    type: 'post',
                    data: {
                        _token: "{{csrf_token()}}",
                        all_data: JSON.stringify(all_data.get())
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status == 200) {
                            // window.location = "{{route('admin.dashboard')}}";
                            location.reload(true);
                        }
                    },
                });
            }
        });

        $(document).on('click', '.mg_view_solution', function() {
            $('.mg_solution_text').html('<p> Loading... </p>');
            var question_id = $(this).parents('ul').attr('data-question-id');
            $.ajax({
                url: "{{route('admin.assessment_accounts.question_solution')}}",
                type: 'post',
                data: {
                    _token: "{{csrf_token()}}",
                    question_id: question_id
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status == 200) {
                        $('.mg_solution_text').html(response.details.solution);
                    } else {
                        alert(response.message);
                    }
                },
            });
        })
    </script>
</body>

</html>