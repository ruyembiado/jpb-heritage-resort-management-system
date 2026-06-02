<div class="d-flex flex-wrap align-items-center gap-3 justify-content-center bg-theme-primary p-4">

    <a href="{{ url('services') }}"
        class="btn {{ ($filter ?? 'all') == 'all' ? 'bg-success text-light' : 'btn-outline-light' }}">
        All
    </a>

    <a href="{{ url('services?filter=entrance_fee') }}"
        class="btn {{ ($filter ?? '') == 'entrance_fee' ? 'bg-success text-light' : 'btn-outline-light' }}">
        Entrance Fee
    </a>

    <a href="{{ url('services?filter=cottage_fee') }}"
        class="btn {{ ($filter ?? '') == 'cottage_fee' ? 'bg-success text-light' : 'btn-outline-light' }}">
        Cottage Fee
    </a>
    
    <a href="{{ url('services?filter=accommodation') }}"
        class="btn {{ ($filter ?? '') == 'accommodation' ? 'bg-success text-light' : 'btn-outline-light' }}">
        Accommodation
    </a>

     <a href="{{ url('services?filter=function_hall') }}"
        class="btn {{ ($filter ?? '') == 'function_hall' ? 'bg-success text-light' : 'btn-outline-light' }}">
        Function Hall
    </a>

    <a href="{{ url('services?filter=foods') }}"
        class="btn {{ ($filter ?? '') == 'foods' ? 'bg-success text-light' : 'btn-outline-light' }}">
        Foods
    </a>

    <a href="{{ url('services?filter=drinks') }}"
        class="btn {{ ($filter ?? '') == 'drinks' ? 'bg-success text-light' : 'btn-outline-light' }}">
        Drinks
    </a>
</div>
