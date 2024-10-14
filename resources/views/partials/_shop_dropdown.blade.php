<!-- resources/views/partials/_shop_dropdown.blade.php -->

<ul class="dropdown-menu position-absolute bg-white shadow-sm mt-2">
@if (isset($categories))
    @foreach ($categories as $category) <!-- Assuming $categories contains the category data -->
        <li>
            <a class="dropdown-item" href="{{ route('shop.category', $category->slug) }}">
                {{ $category->name }}
            </a>
        </li>
    @endforeach
    @endif
</ul>

