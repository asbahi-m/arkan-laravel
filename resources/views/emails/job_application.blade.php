<div style="direction: ltr; font-size: 16px; line-height: 2; background-color: #f7f7f7; padding: 20px; border: 1px solid #eee; border-radius: 20px; max-width: 800px; margin: auto">

    @if (isset($content['jobNew']))
        <div>{{ __('admin.hello') }}, <strong style="color: #3B3363">{{ $content['jobNew']['name'] }}</strong></div>
        <div>{{ __('admin.received_job_msg') }}</div>
        <div>{{ __('admin.review_job_msg') }}</div>
    @endif

    @if (isset($content['jobAccept']))
        <div><strong style="color: #3B3363">{{ $content['jobAccept']['name'] }},</strong> {{ __('admin.welcome_back') }}</div>
        <div style="color: #52AD1A; font-weight: bold">{{ $content['jobAccept']['message'] }}</div>
        <div></div>
    @endif

    @if (isset($content['jobReject']))
        <div><strong style="color: #3B3363">{{ $content['jobReject']['name'] }},</strong> {{ __('admin.welcome_back') }}</div>
        <div style="color: #B92C61; font-weight: bold">{{ $content['jobReject']['message'] }}</div>
    @endif

    <hr style="color: #fff" />
    <div>{{ __('admin.yours_sincerely') }}</div>
    <div style="color: #666"><a href="{{ url('/') }}">{{ config('app.name') }}</a></div>
</div>
