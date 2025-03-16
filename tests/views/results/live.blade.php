<div>
    <h1>Live Results</h1>
    <div id="live-results">
        @if(isset($election))
            <h2>{{ $election->title }}</h2>
            @foreach($election->positions as $position)
                <div class="position">
                    <h3>{{ $position->title }}</h3>
                    @foreach($position->votes as $vote)
                        <div class="vote">
                            {{ $vote->representative->name }}
                        </div>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
</div>
