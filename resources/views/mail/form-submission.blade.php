<x-mail::message>
<h1>{{ $submission->form->title }}</h1>

<table class="table">
@foreach ($submission->data() as $data)
<tr>
<td width="20%">
{{ $data['field'] }}
</td>

<td>
{!! is_array($data['value']) ? implode("<br />", $data['value']) : $data['value'] !!}
</td>
</tr>
@endforeach

<tr>
<td>
{{ __('forms.submissions.attributes.user_agent') }}
</td>

<td>
{{ $submission->user_agent }}
</td>
</tr>

<tr>
<td>
{{ __('forms.submissions.attributes.user_ip') }}
</td>

<td>
{{ $submission->user_ip }}
</td>
</tr>

<tr>
<td>
{{ __('forms.submissions.attributes.referrer_url') }}
</td>

<td>
{{ $submission->referrer_url }}
</td>
</tr>
</table>
</x-mail::message>
