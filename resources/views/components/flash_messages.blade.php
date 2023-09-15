@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <h5 class="alert-heading">Terjadi Kesalahan!</h5>
        <hr>
        <ul>
            @foreach ($errors->all() as $item)
                <li>
                    {{ $item }}
                </li>
            @endforeach
        </ul>
    </div>
@endif


@if (Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif
