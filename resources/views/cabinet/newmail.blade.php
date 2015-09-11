<script>
    var wbbOpt = {
        buttons: "bold,italic,underline,|,img,link,|,quote"
    }
    $(function() {
        $("#editor").wysibb(wbbOpt);
    })
</script>
<form class="form-horizontal" method="post" action="{{route('sender')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="form-group">
        <label for="whom">To:</label>
        <input type="text" id="whom" name="reciever" list="pilots" autocomplete="on">
        <datalist id="pilots">
            @foreach($users as $user)
                <option>{{$user->name}}</option>
            @endforeach
        </datalist>
    </div>
    <div class="form-group">
        <label for="subject">Topic:</label>
        <input type="text" id="subject" name="header" placeholder="No topic">
    </div>
    <div>
        <textarea id="editor" name="body"></textarea>
    </div>
    <button type="submit" class="btn btn-warning">Send</button>
</form>