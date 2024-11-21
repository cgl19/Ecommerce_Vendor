<div class="software-nav-menu" style="display:none; width: 1000px; background-color: #424242; border-top: 1px solid #ccc; padding: 0;">
    <ul style="display: flex; justify-content: space-around; list-style: none; margin: 0; padding: 0;">
        @foreach (get_level_zero_categories()->take(12) as $key => $category)
        @php
            $category_name = $category->getTranslation('name');
        @endphp
        
        <li style="flex: 1; text-align: center; padding: 15px; color: white; font-size: 0.78rem !important; cursor: pointer; transition: background-color 0.3s ease;" 
            onmouseover="this.style.backgroundColor='rgba(255, 255, 255, 0.2)'" 
            onmouseout="this.style.backgroundColor=''">
            <a href="{{ route('products.category', $category->slug) }}" style="color:white !important">
              
                <img class="cat-image lazyload mr-2 opacity-60" src="{{ static_asset('assets/img/placeholder.jpg') }}"
                        data-src="{{ isset($category->catIcon->file_name) ? my_asset($category->catIcon->file_name) : static_asset('assets/img/placeholder.jpg') }}" width="16" alt="{{ $category_name }}"
                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    <span class="cat-name has-transition">{{ $category_name }}</span>
            </a>
        </li>
       @endforeach
    </ul>
</div>
