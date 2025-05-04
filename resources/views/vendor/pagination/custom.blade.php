@if ($paginator->hasPages())
    <div style="display: flex; justify-content: flex-end; margin:10px">
        <ul style="display: flex; list-style: none; gap: 6px; padding: 0;">
            {{-- Lien vers page précédente --}}
            @if ($paginator->onFirstPage())
                <li style="padding: 8px 12px; background-color: #ccc; border-radius: 6px; color: white;">«</li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" style="padding: 8px 12px; background-color: #2c3e50; border-radius: 6px; color: white; text-decoration: none;">«</a>
                </li>
            @endif

            {{-- Liens de pagination --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li style="padding: 8px 12px; color: gray;">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li style="padding: 8px 12px; background-color: #3498db; border-radius: 6px; color: white; font-weight: bold;">{{ $page }}</li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="padding: 8px 12px; background-color: #2c3e50; border-radius: 6px; color: white; text-decoration: none;">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Lien vers page suivante --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" style="padding: 8px 12px; background-color: #2c3e50; border-radius: 6px; color: white; text-decoration: none;">»</a>
                </li>
            @else
                <li style="padding: 8px 12px; background-color: #ccc; border-radius: 6px; color: white;">»</li>
            @endif
        </ul>
    </div>
@endif
