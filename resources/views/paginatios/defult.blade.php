@if ($paginator->hasPages())
<nav class="shop-pages d-flex justify-content-between mt-3" aria-label="Page navigation">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <a href="javascript:void(0)" class="btn-link d-inline-flex align-items-center disabled">
            <svg class="me-1" width="7" height="11"><use href="#icon_prev_sm" /></svg>
            <span class="fw-medium">PREV</span>
        </a>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="btn-link d-inline-flex align-items-center">
            <svg class="me-1" width="7" height="11"><use href="#icon_prev_sm" /></svg>
            <span class="fw-medium">PREV</span>
        </a>
    @endif

    {{-- Pagination Elements --}}
    <ul class="pagination mb-0">
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled">
                    <a class="btn-link px-1 mx-2 btn-link_active" href="#">{{ $element }}</a>
                </li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item"><a class="btn-link px-1 mx-2 btn-link_active" href="#">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="btn-link px-1 mx-2" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
    </ul>

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="btn-link d-inline-flex align-items-center">
            <span class="fw-medium me-1">NEXT</span>
            <svg width="7" height="11"><use href="#icon_next_sm" /></svg>
        </a>
    @else
        <a href="javascript:void(0)" class="btn-link d-inline-flex align-items-center disabled">
            <span class="fw-medium me-1">NEXT</span>
            <svg width="7" height="11"><use href="#icon_next_sm" /></svg>
        </a>
    @endif
</nav>
@endif
