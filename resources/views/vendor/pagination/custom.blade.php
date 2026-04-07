@if ($paginator->hasPages())
<nav style="display:flex;gap:0.5rem;justify-content:center;margin-top:1.5rem;flex-wrap:wrap;">
    @if ($paginator->onFirstPage())
    <span style="padding:0.4rem 0.8rem;border:1px solid #E7E5E4;border-radius:8px;font-size:0.85rem;color:#A8A29E;">‹ Prev</span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}" style="padding:0.4rem 0.8rem;border:1px solid #E7E5E4;border-radius:8px;font-size:0.85rem;text-decoration:none;color:#1C1917;">‹ Prev</a>
    @endif

    @foreach ($elements as $element)
    @if (is_string($element))
    <span style="padding:0.4rem 0.8rem;font-size:0.85rem;color:#A8A29E;">{{ $element }}</span>
    @endif
    @if (is_array($element))
    @foreach ($element as $page => $url)
    @if ($page == $paginator->currentPage())
    <span style="padding:0.4rem 0.8rem;border:1px solid #F97316;border-radius:8px;font-size:0.85rem;background:#F97316;color:white;">{{ $page }}</span>
    @else
    <a href="{{ $url }}" style="padding:0.4rem 0.8rem;border:1px solid #E7E5E4;border-radius:8px;font-size:0.85rem;text-decoration:none;color:#1C1917;">{{ $page }}</a>
    @endif
    @endforeach
    @endif
    @endforeach

    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" style="padding:0.4rem 0.8rem;border:1px solid #E7E5E4;border-radius:8px;font-size:0.85rem;text-decoration:none;color:#1C1917;">Next ›</a>
    @else
    <span style="padding:0.4rem 0.8rem;border:1px solid #E7E5E4;border-radius:8px;font-size:0.85rem;color:#A8A29E;">Next ›</span>
    @endif
</nav>
@endif