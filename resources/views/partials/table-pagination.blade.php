@if ($paginator->total() > 0)
    <nav class="table-pagination" aria-label="Page navigation">
        <p class="table-pagination-summary mb-0">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </p>

        @if ($paginator->hasPages())
            <ul class="pagination table-pagination-controls mb-0">
                <li class="page-item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                    @if ($paginator->onFirstPage())
                        <span class="page-link">Previous</span>
                    @else
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
                    @endif
                </li>
                <li class="page-item active" aria-current="page">
                    <span class="page-link">{{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
                </li>
                <li class="page-item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                    @if ($paginator->hasMorePages())
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
                    @else
                        <span class="page-link">Next</span>
                    @endif
                </li>
            </ul>
        @endif
    </nav>
@endif
