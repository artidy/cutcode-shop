<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $filter->title() }}</h5>
    @foreach($filter->values() as $id => $label)
        <div class="form-checkbox">
            <input
                    type="checkbox"
                    value="{{ $id }}"
                    id="{{ $filter->id($id) }}"
                    name="{{ $filter->name($id) }}"
                    @checked($filter->request($id))
            >
            <label
                    for="{{ $filter->id($id) }}"
                    class="form-checkbox-label">
                {{ $label }}
            </label>
        </div>
    @endforeach
</div>
