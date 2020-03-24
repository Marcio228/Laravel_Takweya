<h1>Hello {{$user->first_name}}</h1>

<p>
    Please click the following link to activate your account,

    <a href="{{ 'http://kz-courses-laravel.site/activate/' . $user->email }}/{{$code}}">activate account</a>
</p>