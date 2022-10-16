@if ($paginator->hasPages())
    <nav
        class="pagination is-centered"
        role="navigation"
        aria-label="pagination"
    >
        <a
            class="pagination-previous {{ $paginator->onFirstPage() ? 'is-disabled' : '' }}"
            href="{{ !$paginator->onFirstPage() ? $paginator->previousPageUrl() : '#' }}"
            rel="prev"
            aria-label="@lang('pagination.previous')"
        >
            @icon('fa-angle-left')
        </a>

        <a
            class="pagination-next {{ !$paginator->hasMorePages() ? 'is-disabled' : '' }}"
            href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '#' }}"
            rel="next"
            aria-label="@lang('pagination.next')"
        >
            @icon('fa-angle-right')
        </a>

        <ul class="pagination-list">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <a class="pagination-link">{{ $element }}</a>
                    </li>
                @elseif (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            <a
                                class="pagination-link {{ $page == $paginator->currentPage() ? 'is-current' : '' }}"
                                href="{{ $url }}"
                            >
                                {{ $page }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>
@endif
