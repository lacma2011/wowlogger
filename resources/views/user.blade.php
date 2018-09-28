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

            @if ($user->region === 'cn')
            <fieldset>
                <legend>Select a region</legend>

                <div>
                    <input type="radio" id="cn" 
                           name="region" value="cn" checked />
                    <label for="cn">CN</label>
                </div>
            </fieldset>
           @else
            <fieldset>
                <legend>Select a region</legend>

                <div>
                    <input type="radio" id="us" 
                           name="region" value="us" checked />
                    <label for="us">US</label>
                </div>

                <div>
                    <input type="radio" id="eu" 
                           name="region" value="eu" />
                    <label for="eu">EU</label>
                </div>

                <div>
                    <input type="radio" id="apac" 
                           name="region" value="apac" />
                    <label for="apac">APAC</label>
                </div>
            </fieldset>
            @endif
            <button value="update" name="update">Get/Update Characters</button>
        </form>
        @endif
    </div>
    <div>
        Characters:
    </div>
</body>
</html>
