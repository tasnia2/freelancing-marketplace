@extends('layouts.settings')

@section('content')
<div>
    <h1 class="text-2xl font-bold text-purple-700 mb-6">Settings</h1>
    <p class="text-gray-600 mb-8">Manage your account preferences and settings</p>
    
    <!-- Content will be loaded via AJAX -->
    <div id="settings-content">
        @include('settings.freelancer.tabs.account')
    </div>
</div>
@endsection