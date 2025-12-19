@extends('layouts.settings')

@section('content')
<div>
    <h1 class="text-2xl font-bold mb-6" style="color: #1B3C53;">Settings</h1>
    <p class="text-gray-600 mb-8">Manage your company and account settings</p>
    
    <!-- Content will be loaded via AJAX -->
    <div id="settings-content">
        @include('settings.client.tabs.account')
    </div>
</div>
@endsection