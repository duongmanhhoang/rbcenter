@if ($paginator->last_page > 1)
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->current_page == 1)
            <li class="disabled" aria-disabled="true">
                <span aria-hidden="true">&lsaquo;</span>
            </li>
        @else
            <li>
                <a href="#" rel="prev">&lsaquo;</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        {{--@foreach ($elements as $element)--}}
            {{-- "Three Dots" Separator --}}
            {{--@if (is_string($element))--}}
                {{--<li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>--}}
            {{--@endif--}}

            {{-- Array Of Links --}}
            {{--@if (is_array($element))--}}
                {{--@foreach ($element as $page => $url)--}}
                    {{--@if ($page == $paginator->currentPage())--}}
                        {{--<li class="active" aria-current="page"><span>{{ $page }}</span></li>--}}
                    {{--@else--}}
                        {{--<li><a href="{{ $url }}">{{ $page }}</a></li>--}}
                    {{--@endif--}}
                {{--@endforeach--}}
            {{--@endif--}}
        {{--@endforeach--}}


        {{--@if ($paginator->hasMorePages())--}}
            {{--<li>--}}
                {{--<a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>--}}
            {{--</li>--}}
        {{--@else--}}
            {{--<li class="disabled" aria-disabled="true" aria-label="@lang('pagination.next')">--}}
                {{--<span aria-hidden="true">&rsaquo;</span>--}}
            {{--</li>--}}
        {{--@endif--}}
    </ul>
@endif
