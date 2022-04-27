<div style="direction: ltr; font-size: 16px; line-height: 2; background-color: #f7f7f7; padding: 20px; border: 1px solid #eee; border-radius: 20px; max-width: 800px; margin: auto">
    @if (isset($content['orderNew']))
        <div>{{ __('admin.hello') }}, <strong style="color: #3B3363">{{ $content['orderNew']['name'] }}</strong></div>
        <div>{{ __('admin.received_order_msg') }}: <strong style="color: #EB8153">{{ $content['orderNew']['service'] }}</strong></div>
        <div>{{ __('admin.review_order_msg') }}</div>
    @endif

    @if (isset($content['orderAccept']))
        <div><strong style="color: #3B3363">{{ $content['orderAccept']['name'] }},</strong> {{ __('admin.welcome_back') }}</div>
        <div style="color: #52AD1A; font-weight: bold">{{ $content['orderAccept']['message'] }}</div>
        <div></div>
    @endif

    @if (isset($content['orderReject']))
        <div><strong style="color: #3B3363">{{ $content['orderReject']['name'] }},</strong> {{ __('admin.welcome_back') }}</div>
        <div style="color: #B92C61; font-weight: bold">{{ $content['orderReject']['message'] }}</div>
    @endif

    <hr style="color: #fff" />
    <div>{{ __('admin.yours_sincerely') }}</div>
    <div style="color: #666"><a href="{{ url('/') }}">{{ config('app.name') }}</a></div>
</div>
