@props(['paginator'])


@if ($paginator->hasPages())
    <div class="flex justify-center mt-6">
        <div class="flex items-center">


            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <button
                    class="px-3 py-1 border border-gray-300 rounded-l-md text-gray-400 bg-gray-100 cursor-not-allowed">
                    < </button>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}"
                            class="px-3 py-1 border border-gray-300 rounded-l-md text-gray-700 hover:bg-gray-100 transition">
                            < </a>
            @endif


            {{-- Current Page --}}
            <span class="px-3 py-1 border-t border-b border-gray-300 bg-plp-green text-white">
                {{ $paginator->currentPage() }}
            </span>


            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="px-3 py-1 border border-gray-300 rounded-r-md text-gray-700 hover:bg-gray-100 transition">
                    >
                </a>
            @else
                <button
                    class="px-3 py-1 border border-gray-300 rounded-r-md text-gray-400 bg-gray-100 cursor-not-allowed">
                    >
                </button>
            @endif


        </div>
    </div>
@endif
