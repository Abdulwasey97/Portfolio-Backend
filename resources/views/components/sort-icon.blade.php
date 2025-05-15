@if ($sortField === $field)
    @if ($sortDirection === 'asc')
        <span class="sort-icon">↑</span>
    @else
        <span class="sort-icon">↓</span>
    @endif
@else
    <span class="sort-icon sort-inactive">↕</span>
@endif
