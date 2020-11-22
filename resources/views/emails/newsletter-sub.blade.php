@component('mail::message')
# You've got a Subscriber

Add them to the list

@component('mail::panel')
<p><b>Email:</b> {{ $email }}</p>
<p><b>Source:</b> {{ $source }}</p>
@endcomponent

@component('mail::button', ['url' => 'https://streetviewhub.substack.com'])
Add them
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
