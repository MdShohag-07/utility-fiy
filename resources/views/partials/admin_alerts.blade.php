{{-- resources/views/partials/admin_alerts.blade.php --}}

{{-- Session Status Messages (Success) --}}
@if(session('status'))
    <div class="alert alert-success mb-4 p-3 rounded-md text-sm" role="alert">
        {{ session('status') }}
    </div>
@endif

{{-- Session Error Messages --}}
@if(session('error'))
    <div class="alert alert-danger mb-4 p-3 rounded-md text-sm" role="alert">
        {{ session('error') }}
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger mb-4 p-3 rounded-md text-sm" role="alert">
        <strong class="font-semibold block mb-1">Please fix the following errors:</strong>
        <ul class="list-disc list-inside ml-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif