<?php $myRank=\App\Myclasses\Rank::getRank();
      $messNum=\Auth::user()->hasInbox()->where('status', 'unread')->count();
?>
<h2>CMDR {{Auth::user()->name}}
@if($messNum>0)
        | <a class="mailLink" href="{{route('usermail')}}"><span class="glyphicon glyphicon-envelope"></span> ({{$messNum}})</a>
@endif
</h2>
<div class="cabmenu pilotRank">
    @if(Auth::user()->isModerator())
        <a href="{{route('moderation')}}">Сайт</a>
    @endif
    @if(Auth::user()->isAdmin())
        <a href="{{route('administration')}}">Админка</a>
    @endif
    <a href="{{route('cabinet')}}">Кабинет </a>
    <a href="{{url('auth/logout')}}"> Выход</a>
</div>
    <div id="personalStat">
    <img src="/media/{{$myRank->logo}}" alt="rank" style="float:right; width: 100px; height:auto;">
    <h4 class="rank">{{$myRank->rank}}</h4>
    <h5>Прогресс до следующего ранга:</h5>
    <div class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="{{$myRank->progression}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$myRank->progression}}%;">
            <span class="sr-only">{{$myRank->progression}}% Complete</span>
        </div>
    </div>
</div>