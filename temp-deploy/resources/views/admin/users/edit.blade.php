@extends('layouts.admin')
@section('title', 'Edit User')

@section('content')
<section class="admin-content px-4 py-4 md:px-6 md:py-6">
    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-700">Edit User: {{ $user->full_name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary text-sm"><i class="fas fa-arrow-left fa-fw mr-1"></i> Back</a>
    </div>
    <hr class="mb-5">
    @if ($errors->any()) <div class="alert alert-danger mb-4"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div> @endif

    <div class="widget-card shadow rounded-lg overflow-hidden">
         <div class="widget-header bg-gray-50 border-b p-4"><h3 class="font-medium">User Details</h3></div>
         <form action="{{ route('admin.users.update', $user) }}" method="POST" class="widget-content bg-white p-6 space-y-4">
            @csrf
            @method('PUT') {{-- Method spoofing for updates --}}

            {{-- Include the shared form fields, passing the $user data --}}
            @include('admin.users._form-fields', ['user' => $user])

            <div class="pt-3 text-right">
                <button type="submit" class="btn btn-primary"><i class="fas fa-sync-alt mr-1"></i> Update User</button>
            </div>
        </form>
    </div>
</section>
@endsection
{{-- Include form styles --}}