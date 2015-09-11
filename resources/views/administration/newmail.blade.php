<script>
    var wbbOpt = {
        buttons: "bold,italic,underline,|,img,link,|,quote"
    }
    $(function() {
        $("#editor").wysibb(wbbOpt);
    })
</script>
<form class="form-horizontal" method="post" action="{{route('senderAdmin')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="form-group">
        <label for="whom">To whom:</label>
        <select name="recievers[]" multiple="multiple" id="whom">
            @foreach($users as $user)
                <option>{{$user->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="subject">Topic:</label>
        <input type="text" id="subject" name="header" placeholder="Without a topic">
    </div>
    <div>
        <textarea id="editor" name="body"></textarea>
    </div>
    <button type="submit" class="btn btn-warning">Send</button>
</form>