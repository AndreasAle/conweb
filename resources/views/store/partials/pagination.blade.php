@if ($paginator->hasPages())
  <nav class="pagination" role="navigation" aria-label="Pagination">
    @if ($paginator->onFirstPage())
      <span aria-disabled="true"><span>&laquo;</span></span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><span>&laquo;</span></a>
    @endif

    @foreach ($elements as $element)
      @if (is_string($element))
        <span aria-disabled="true"><span>{{ $element }}</span></span>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span class="active" aria-current="page"><span>{{ $page }}</span></span>
          @else
            <a href="{{ $url }}"><span>{{ $page }}</span></a>
          @endif
        @endforeach
      @endif
    @endforeach

    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" rel="next"><span>&raquo;</span></a>
    @else
      <span aria-disabled="true"><span>&raquo;</span></span>
    @endif
  </nav>
@endif
