<ol class="breadcrumb">
    @foreach($breadcrumbs as $link => $title)
        <li {{ ($loop->last)? ' class=active' : '' }}>
            @if(!$loop->last)
                <a {{ $link }}>{{ $title }}</a>
            @else
                {{ $title }}
            @endif
        </li>
    @endforeach
</ol>