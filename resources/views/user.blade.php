<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div>
        <h3><?= $login_link ?></h3>

        <h1>User Page: <?= $user->name ?></h1>
        @if (NULL !== $logged_in)
        <form method="post" action="<?php echo route('myhome_post', ['user_id'=>$user->id]) ?>">
            @csrf
            <button value="update" name="update">Get/Update Characters</button>
        </form>
        @endif
    </div>
    <div>
        Characters:
    </div>
</body>
</html>
