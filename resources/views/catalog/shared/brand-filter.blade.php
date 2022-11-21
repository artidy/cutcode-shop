<div class="form-checkbox">
    <input
        type="checkbox"
        value="{{ $item->id }}"
        id="filters-brands-{{ $item->id }}"
        name="filters[brands][{{ $item->id }}]"
        @checked(request("filters.brands.$item->id"))
    >
    <label
        for="filters-brands-{{ $item->id }}"
        class="form-checkbox-label">
        {{ $item->title }}
    </label>
</div>
