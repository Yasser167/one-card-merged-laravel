    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <div class="d-flex align-items-center gap-2 justify-content-between w-100 navbar_all_button">
                <!-- Logo -->
                <a class="navbar-brand logo" href="{{ route('index.store') }}">
                    <img src="{{ url( Storage::url($settings->logo_site )) }}" alt="Logo">
                </a>

                <div class="d-flex align-items-center gap-2 justify-content-center">

                    <button class="btn btn-light basket_cart" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
                        <i class="bi bi-cart"></i>
                        <span>0</span>
                    </button>

                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

            </div>

            <div class="d-flex align-items-center gap-2 justify-content-between navbar_all_button">
                <form action="{{ route('change.language') }}" method="POST" class="d-flex">
                    @csrf
                    <select style="width:fit-content;" name="language" id="language" class="form-select" onchange="this.form.submit()">
                        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
                        <option value="ar" {{ app()->getLocale() == 'ar' ? 'selected' : '' }}>العربية</option>
                    </select>
                </form>

                <!-- Social Links -->
                <ul class="navbar-nav">
                    @foreach($socialIcons as $socialIcon )
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $socialIcon->link }}" target="_blank">
                            {!! $socialIcon->icon !!}
                        </a>
                    </li>
                    @endforeach
                
<li class="nav-item"><a class="nav-link" href="{{ url('/sections/pc_games') }}">🎮 ألعاب PC</a></li>
<li class="nav-item"><a class="nav-link" href="{{ url('/sections/xbox_games') }}">🕹 ألعاب Xbox</a></li>

<li><a href="{{ route('playstation_games') }}">{{ __('PlayStation Games') }}</a></li>
<li><a href="{{ route('discounts') }}">{{ __('Discounts') }}</a></li>
<li><a href="{{ route('products') }}">{{ __('Products') }}</a></li>

<li class="nav-item"><a class="nav-link" href="{{ url('/sections/subscriptions') }}">🔐 الاشتراكات</a></li>
<li class="nav-item"><a class="nav-link" href="{{ url('/sections/books') }}">📚 الكتب</a></li>

</ul>
            </div>
        </div>
    </nav>

    <!-- Offcanvas Shopping cart -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">@lang('messages.shopping_cart')</h5>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column h-100" style="overflow: hidden;overflow-y: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody class="cart-body"></tbody>
            </table>
        </div>

        <div class="offcanvas-footer p-2">
            <hr>
            <div class="d-flex align-items-center flex-column">
                <h4>@lang('messages.total'): <span class="btn btn-danger total">00.00</span> @lang('messages.currency')</h4>
                <a href="{{ route('purchase.complete') }}" class="btn btn-success">
                    @lang('messages.complete_purchase')
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Search -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true" dir="ltr">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="GET" action="{{ route('index.store') }}">
                        <div class="mb-3">
                            <div class="input-group search">
                                <input type="search" name="search" placeholder="@lang('messages.search')" class="form-control" value="{{ request('search') }}">
                                <button type="submit" class="input-group-text"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        var currencySymbol = @json(__('messages.currency'));
        var product_has_been_added_to_cart = @json(__('messages.product_has_been_added_to_cart'));
        var product_is_in_the_cart = @json(__('messages.product_is_in_the_cart'));
        var no_items_in_cart = @json(__('messages.no_items_in_cart'));
    </script>