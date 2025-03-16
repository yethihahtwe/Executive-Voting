<div>
    <h1>Election Results</h1>
    <div id="results">
        @if(isset($election))
            <h2>{{ $election->title }}</h2>
            @foreach($election->positions as $position)
                <div class="position">
                    <h3>{{ $position->title }}</h3>
                    @if($position->electedRepresentative)
                        <div class="elected">
                            Elected: {{ $position->electedRepresentative->name }}
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>
