<div class="bg-white border mb-4">
    <div class="p-3 p-sm-4 fs-16 fw-600">
        {{ translate('Top Selling Products') }}
    </div>
    <div class="px-3 px-sm-4 pb-4 ">
        <ul class="list-group list-group-flush">
            <li class="list-group-item border-0">
                <!-- Row container with flex wrap to align products in a row -->
                <div class="d-flex justify-content-start align-items-center">
                    @foreach (get_best_selling_products(4, $detailedProduct->user_id) as $key => $top_product)
                        <div class="product-card d-flex align-items-center hov-scale-img hov-shadow-md overflow-hidden has-transition m-2">
                            <div class="image-container">
                                <a href="{{ route('product', $top_product->slug) }}" class="d-block text-reset">
                                    <img class="img-fit lazyload h-80px h-md-150px h-lg-80px has-transition"
                                         src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                         data-src="{{ uploaded_asset($top_product->thumbnail_img) }}"
                                         alt="{{ $top_product->getTranslation('name') }}"
                                         onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </a>
                            </div>
                            <div class="product-details ml-3">
                                <h4 class="fs-14 fw-400 text-truncate-2 mb-2">
                                    <a href="{{ route('product', $top_product->slug) }}" 
                                       class="d-block text-reset hov-text-primary">
                                        {{ $top_product->getTranslation('name') }}
                                    </a>
                                </h4>
                                <div>
                                    <span class="fs-14 fw-700 text-primary">
                                        {{ home_discounted_base_price($top_product) }}
                                    </span>
                                    @if(home_price($top_product) != home_discounted_price($top_product))
                                        <del class="fs-14 fw-700 opacity-60 ml-1">
                                            {{ home_price($top_product) }}
                                        </del>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </li>
        </ul>
    </div>
</div>
