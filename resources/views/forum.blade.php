<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <link rel="stylesheet" href="app.css"> --}}

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<style>
    * {
        padding: 0;
        margin: 0;

    }

    .que_cont {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
    }

    .que_cont img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin: auto 0;
    }

    .que_cont .time {
        font-size: 12px;
        font-weight: 500;
        color: grey;
    }

    .user_profile {
        display: flex;
        flex-direction: column;

    }

    .forum_post {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .forum_cont {
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .add_btn {
        background: #543ae3;
        color: white;
        width: 100%;
        font-size: 32px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        padding-bottom: 7px;
        border-radius: 50%;
        position: fixed;
        right: 30px;
        bottom: 50px;
    }

    .add_ques {
        display: flex;
        height: 50px;
        width: 50px;
    }

    .add_que_form {
        display: flex;
        position: fixed;
        width: 100%;
        left: 0;
        top: 0;
        height: 100vh;
        background-color: #00000020;
        align-items: end;
    }

    .form_cont {
        display: flex;
        background-color: white;
        width: 100%;
        height: 60%;
        border-radius: 20px 20px 0 0;
        padding: 15px;

    }

    h6 {
        padding: 15px 15px 5px;
    }

    form {
        width: 100%
    }
</style>

<body>

    <h6>Hey, {{ $user->name }}</h6>


    <div class="forum_cont">

        @foreach ($ques as $que)
            <div class="forum_post">

                <div class="que_cont">
                    <img src="https://static.vecteezy.com/system/resources/thumbnails/019/896/012/small_2x/female-user-avatar-icon-in-flat-design-style-person-signs-illustration-png.png"
                        alt="">
                    <div class="user_profile">
                        <span class="name">{{ $que->name }}</span>
                        <span class="time">15 nov, 2024</span>

                    </div>

                </div>

                <div class="ques_asked">
                    {{ $que->question }}
                </div>

                <div class="actions">
                    <div class="like" data-postid="{{ $que->id }}">
                        <img src="https://img.icons8.com/color/24/000000/like.png" alt="">
                        <span>{{ $que->likes }}</span>
                    </div>

                    <div class="reply" data-postid="{{ $que->id }}">
                        <img src="https://img.icons8.com/color/24/000000/reply.png" alt="">
                        <span>{{ $que->comments }}</span>
                    </div>
                </div>
            </div>
        @endforeach



    </div>

    {{-- <div class="add_ques"> --}}
    <div class="add_btn">+</div>
    {{-- </div> --}}

    <div class="add_que_form">
        <div class="form_cont">
            <form action="{{ url('/add_question/' . $user->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="question">Ask your question</label>
                    <input type="text" class="form-control" name="question" id="question" aria-describedby="helpId"
                        placeholder="Enter your question" required>
                    <small id="helpId" class="form-text text-muted">Please ask your question clearly.</small>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>


    <script>
        $(document).ready(function() {
            $('.add_que_form').hide();
            $('.add_btn').on('click', function() {
                $('.add_que_form').show();

            });

            $('.like').on('click', function() {
                let postId = $(this).data('postid');
                let userId = {{ $user->id }} ;
                
                $.ajax({
                    type: "get",
                    url: 'http://localhost:8000/add_like/' + userId + '/' + postId,
                    data: {
                        user_id: userId,
                        post_id: postId,
                        is_liked: 1,
                        like_type: 'like'
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                    }
                });

            });
        });
    </script>
</body>



</html>
