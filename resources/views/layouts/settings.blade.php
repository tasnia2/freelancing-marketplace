<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - WorkNest</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        [x-cloak] { display: none !important; }
        
        .settings-sidebar {
            width: 250px;
        }
        
        .settings-content {
            width: calc(100% - 250px);
        }
        
        .form-input {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        
        @media (max-width: 768px) {
            .settings-sidebar,
            .settings-content {
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        @if(auth()->user()->isFreelancer())
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Work<span class="text-purple-600">Nest</span></span>
                        @else
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                            <i class="fas fa-handshake text-white"></i>
                        </div>
                        <span class="text-xl font-bold">Work<span class="text-blue-800">Nest</span></span>
                        @endif
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-home mr-1"></i> Dashboard
                    </a>
                    <a href="{{ route('profile') }}" class="text-gray-600 hover:text-gray-900">
                        <i class="fas fa-user mr-1"></i> Profile
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Settings Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <div class="settings-sidebar">
                @include('settings.partials.sidebar')
            </div>
            
            <!-- Main Content -->
            <div class="settings-content bg-white rounded-lg shadow-sm border p-6">
                <div id="settings-content">
                    @if(auth()->user()->isFreelancer())
                        @include('settings.freelancer.tabs.account')
                    @else
                        @include('settings.client.tabs.account')
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab switching
            document.querySelectorAll('[data-tab]').forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all tabs
                    document.querySelectorAll('[data-tab]').forEach(t => {
                        t.classList.remove('bg-purple-50', 'text-purple-700', 'border-purple-500');
                        t.classList.add('text-gray-700', 'hover:bg-gray-50');
                    });
                    
                    // Add active class to clicked tab
                    this.classList.remove('text-gray-700', 'hover:bg-gray-50');
                    this.classList.add('bg-purple-50', 'text-purple-700', 'border-purple-500');
                    
                    const tabName = this.getAttribute('data-tab');
                    
                    // Load content
                    fetch(`/settings/load-tab/${tabName}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('settings-content').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('settings-content').innerHTML = '<div class="text-red-500">Error loading content</div>';
                    });
                });
            });
            
            // Form submission
            document.addEventListener('submit', function(e) {
                if (e.target.classList.contains('settings-form')) {
                    e.preventDefault();
                    
                    const form = e.target;
                    const formData = new FormData(form);
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    
                    // Show loading
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
                    submitBtn.disabled = true;
                    
                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Settings saved successfully!');
                        } else {
                            alert('Error: ' + (data.message || 'Something went wrong'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Network error. Please try again.');
                    })
                    .finally(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
                }
            });
        });
    </script>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
</body>
</html>