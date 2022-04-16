<div class="d-flex flex-wrap">
    @if (!Route::is('option.general'))
        <a href="{{ route('option.general') }}" class="btn btn-info btn-xs m-1">
            <i class="fa fa-sliders fa-lg"></i>
            <span>{{ __('admin.general_options') }}</span>
        </a>
    @endif
    @if (!Route::is('option.social'))
        <a href="{{ route('option.social') }}" class="btn btn-info btn-xs m-1">
            <i class="fa fa-share-alt fa-lg"></i>
            <span>{{ __('admin.social_options') }}</span>
        </a>
    @endif
    @if (!Route::is('option.contact'))
        <a href="{{ route('option.contact') }}" class="btn btn-info btn-xs m-1">
            <i class="fa fa-address-card-o fa-lg"></i>
            <span>{{ __('admin.contact_options') }}</span>
        </a>
    @endif
</div>
