@extends('admin.layouts.v2')
@section('page_title', __('complaint_portal.officers'))
@section('page_subtitle', __('complaint_portal.account_management'))
@section('style')
<style>
.co-admin{direction:rtl}.co-admin .co-card{background:white;border:1px solid #dce4ed;border-radius:14px;padding:24px;margin-bottom:20px}.co-admin .co-fields{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.co-admin label{display:block;margin-bottom:6px}.co-admin .form-control{width:100%;height:46px}.co-admin .co-actions{display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin:16px 0}.co-admin .co-fields>div{min-width:0}.co-admin summary{cursor:pointer;padding:10px 0;font-weight:600}.co-admin .co-card h2{font-size:20px;overflow-wrap:anywhere}.co-admin .co-note{color:#63748a;font-size:14px}.co-admin .co-error{padding:12px;background:#fff0ec;border-radius:8px}@media(max-width:600px){.co-admin .co-fields{grid-template-columns:1fr}.co-admin .co-card{padding:16px}}
</style>
@endsection
@section('content')
<div class="co-admin">
@if($errors->any())<div class="co-error" role="alert">@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
<section class="co-card"><h2>{{ __('complaint_portal.create_account') }}</h2>
<p class="co-note">{{ __('complaint_portal.password_hint') }}</p>
<form method="POST" action="{{ route('admin.complaint-officers.store') }}">@csrf
<div class="co-fields">
    <div><label for="co-name">{{ __('complaint_portal.name') }}</label><input class="form-control" id="co-name" name="name" maxlength="190" value="{{ old('name') }}" required></div>
    <div><label for="co-email">{{ __('complaint_portal.email') }}</label><input class="form-control" id="co-email" name="email" type="email" dir="ltr" value="{{ old('email') }}" required></div>
    <div><label for="co-password">{{ __('complaint_portal.password') }}</label><input class="form-control" id="co-password" name="password" type="password" minlength="10" maxlength="128" autocomplete="new-password" required></div>
    <div><label for="co-confirm">{{ __('complaint_portal.confirm_password') }}</label><input class="form-control" id="co-confirm" name="password_confirmation" type="password" minlength="10" autocomplete="new-password" required></div>
</div><div class="co-actions"><button class="btn btn-primary">{{ __('complaint_portal.create_account') }}</button></div>
</form></section>
@foreach($officers as $officer)
<section class="co-card"><h2>{{ $officer->name }}</h2><p><bdi>{{ $officer->email }}</bdi> · <span class="badge {{ $officer->complaint_officer_active ? 'badge-success' : 'badge-secondary' }}">{{ __('complaint_portal.'.($officer->complaint_officer_active ? 'active' : 'inactive')) }}</span></p>
<details><summary>{{ __('complaint_portal.save') }}</summary><form method="POST" action="{{ route('admin.complaint-officers.update', $officer->id) }}">@csrf
<div class="co-fields"><div><label for="co-name-{{ $officer->id }}">{{ __('complaint_portal.name') }}</label><input class="form-control" id="co-name-{{ $officer->id }}" name="name" value="{{ $officer->name }}" required maxlength="190"></div><div><label for="co-email-{{ $officer->id }}">{{ __('complaint_portal.email') }}</label><input class="form-control" id="co-email-{{ $officer->id }}" name="email" type="email" dir="ltr" value="{{ $officer->email }}" required></div></div>
<div class="co-actions"><button class="btn btn-primary">{{ __('complaint_portal.save') }}</button></div></form></details>
<details><summary>{{ __('complaint_portal.reset_password') }}</summary><p class="co-note">{{ __('complaint_portal.password_hint') }}</p><form method="POST" action="{{ route('admin.complaint-officers.password', $officer->id) }}">@csrf
<div class="co-fields"><div><label for="co-pass-{{ $officer->id }}">{{ __('complaint_portal.password') }}</label><input class="form-control" id="co-pass-{{ $officer->id }}" name="password" type="password" required minlength="10" maxlength="128" autocomplete="new-password"></div><div><label for="co-pass-confirm-{{ $officer->id }}">{{ __('complaint_portal.confirm_password') }}</label><input class="form-control" id="co-pass-confirm-{{ $officer->id }}" name="password_confirmation" type="password" required autocomplete="new-password"></div></div>
<div class="co-actions"><button class="btn btn-primary">{{ __('complaint_portal.reset_password') }}</button></div></form></details>
<form class="co-actions" method="POST" action="{{ route('admin.complaint-officers.state', $officer->id) }}">@csrf<input type="hidden" name="active" value="{{ $officer->complaint_officer_active ? 0 : 1 }}"><button class="btn btn-outline-secondary">{{ __('complaint_portal.'.($officer->complaint_officer_active ? 'deactivate' : 'activate')) }}</button></form>
</section>
@endforeach
{{ $officers->links() }}
</div>
@endsection
