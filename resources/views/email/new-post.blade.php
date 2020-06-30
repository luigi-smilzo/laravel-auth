@component('mail::message')
# Your post has been published!

The following post has been successfully published to your blog page:
{{ $title }}

@component('mail::button', ['url' => config('app.url') . '/posts'])
Go to blog
@endcomponent

Thanks,<br>
Your dev
@endcomponent