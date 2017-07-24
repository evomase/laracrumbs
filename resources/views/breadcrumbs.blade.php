@if($breadcrumbs)
    <ol class="breadcrumb">
        @foreach($breadcrumbs as $link => $title)
            <li {{ ($loop->last)? ' class=active' : '' }}>
                @if(!$loop->last)
                    <a href="{{ $link }}">{{ $title }}</a>
                @else
                    {{ $title }}
                @endif
            </li>
        @endforeach
    </ol>
@endif