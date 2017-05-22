<ol class="breadcrumb">
    @foreach($breadcrumbs as $link => $title)
        <li><a {{ ($loop->last)? ' class=active' : '' }} href="{{ $link }}">{{ $title }}</a></li>
    @endforeach
</ol>