@php
    $contact = App\Models\Option::where('option', 'contact_options')->get()->map(function ($item, $key) {
        return [$item['key'] => $item['value']];
    })->collapse();
@endphp
<div>
    <span><i class="fas fa-map-marker-alt"></i></span>
    <a>{{ $contact['address'] }}</a>
</div>
<div>
    <span><i class="far fa-envelope"></i></span>
    <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
</div>
<div>
    <span><i class="fas fa-phone-volume"></i></span>
    <a>{{ $contact['mobile'] }}</a>
</div>
