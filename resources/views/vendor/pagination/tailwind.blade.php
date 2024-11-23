<div class="flex justify-center items-center space-x-2">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="px-4 py-2 text-gray-400 cursor-not-allowed">← Previous</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">← Previous</a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="px-4 py-2  bg-strong-blue text-white rounded-lg">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded-lg">Next →</a>
    @else
        <span class="px-4 py-2 text-gray-400 cursor-not-allowed">Next →</span>
    @endif
</div>
