<div class="alert alert-danger" id="form-error">
    <strong>Ups! </strong> It seems there is something wrong with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>