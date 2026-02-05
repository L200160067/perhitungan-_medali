@extends('layouts.app')
@section('title', 'Create Registration')
@php $header = 'Create New Registration'; @endphp

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('registrations.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <div class="space-y-6">
            <div><label for="category_id" class="block text-sm font-medium text-gray-700">Tournament Category <span class="text-red-500">*</span></label><select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror" required><option value="">Select a category</option>@foreach($categories as $category)<option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>@endforeach</select>@error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label for="contingent_id" class="block text-sm font-medium text-gray-700">Contingent <span class="text-red-500">*</span></label><select name="contingent_id" id="contingent_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('contingent_id') border-red-500 @enderror" required><option value="">Select a contingent</option>@foreach($contingents as $contingent)<option value="{{ $contingent->id }}" {{ old('contingent_id') == $contingent->id ? 'selected' : '' }}>{{ $contingent->name }}</option>@endforeach</select>@error('contingent_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror</div>
            <div><label for="status" class="block text-sm font-medium text-gray-700">Status</label><select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"><option value="">Select status</option>@foreach($statuses as $status)<option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $status->value)) }}</option>@endforeach</select></div>
            <div><label for="medal_id" class="block text-sm font-medium text-gray-700">Medal</label><select name="medal_id" id="medal_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"><option value="">No medal</option>@foreach($medals as $medal)<option value="{{ $medal->id }}" {{ old('medal_id') == $medal->id ? 'selected' : '' }}>{{ ucfirst($medal->name) }}</option>@endforeach</select></div>
            <div class="flex items-center justify-end space-x-3 pt-4 border-t">
                <a href="{{ route('registrations.index') }}" class="inline-flex items-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Cancel</a>
                <button type="submit" class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500">Create Registration</button>
            </div>
        </div>
    </form>
</div>
@endsection
