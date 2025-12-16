@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 border-2 border-swiss-gray-300 text-swiss-gray-400 cursor-not-allowed">
                    ← TRƯỚC
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all">
                    ← TRƯỚC
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all">
                    SAU →
                </a>
            @else
                <span class="px-4 py-2 border-2 border-swiss-gray-300 text-swiss-gray-400 cursor-not-allowed">
                    SAU →
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-swiss-gray-700 leading-5">
                    Hiển thị
                    <span class="font-bold">{{ $paginator->firstItem() }}</span>
                    đến
                    <span class="font-bold">{{ $paginator->lastItem() }}</span>
                    trong tổng số
                    <span class="font-bold">{{ $paginator->total() }}</span>
                    kết quả
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex space-x-2">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span class="w-10 h-10 border-2 border-swiss-gray-300 text-swiss-gray-400 cursor-not-allowed flex items-center justify-center">
                            ←
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" 
                           class="w-10 h-10 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all flex items-center justify-center">
                            ←
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span class="w-10 h-10 flex items-center justify-center font-bold">{{ $element }}</span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="w-10 h-10 bg-swiss-red text-white font-bold flex items-center justify-center">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="w-10 h-10 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all flex items-center justify-center font-bold">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" 
                           class="w-10 h-10 border-2 border-swiss-black hover:bg-swiss-black hover:text-white transition-all flex items-center justify-center">
                            →
                        </a>
                    @else
                        <span class="w-10 h-10 border-2 border-swiss-gray-300 text-swiss-gray-400 cursor-not-allowed flex items-center justify-center">
                            →
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
