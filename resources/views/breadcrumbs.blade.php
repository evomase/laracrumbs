<nav class="breadcrumb">
    @foreach($breadcrumbs as $link => $title)
        <a class="breadcrumb-item{{ ($loop->last)? ' active' : '' }}" href="{{ $link }}">
            {{ $title }}
        </a>
    @endforeach
</nav>