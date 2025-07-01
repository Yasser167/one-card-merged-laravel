<footer class="bg-dark text-white pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>@lang('messages.about_site')</h5>
                <p>{{ app()->getLocale() == 'ar' ? $settings->description_ar : $settings->description_en }}</p>
            </div>

            <div class="col-md-4 mb-4">
                <h5>@lang('messages.follow_us')</h5>
                @foreach($socialIcons as $socialIcon )
                <a href="{{ $socialIcon->link }}" class="text-white m-1">
                    {!! $socialIcon->icon !!}
                </a>
                @endforeach
            </div>

            <div class="col-md-4 mb-4">
                <a class="logo" href="{{ route('index.store') }}">
                    <img src="{{ url( Storage::url($settings->logo_site )) }}" alt="Logo">
                </a>
            </div>
        </div>
    </div>

    <div class="text-center py-3" style="background-color: rgba(0, 0, 0, 0.2);">
        @lang('messages.all_rights_reserved') © <a class="btn btn-light" href="{{ route('index.store') }}">{{ app()->getLocale() == 'ar' ? $settings->title_ar : $settings->title_en }}</a> - {{ date('Y') }}
    </div>
</footer>