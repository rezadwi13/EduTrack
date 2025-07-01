@extends('layouts.app')

@section('header')
    <div class="flex items-center gap-4">
        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
            <i class="fas fa-user-edit text-white text-lg"></i>
        </div>
        <div>
            <h2 class="font-bold text-2xl text-gray-900">
                {{ __('Profile Settings') }}
            </h2>
            <p class="text-sm text-gray-600 font-medium">
                {{ __('Manage your account settings and preferences') }}
            </p>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-8">
        <div class="max-w-4xl mx-auto space-y-8">
            <!-- Profile Information Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-user text-blue-600"></i>
                        {{ __('Profile Information') }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-lock text-green-600"></i>
                        {{ __('Update Password') }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-trash-alt text-red-600"></i>
                        {{ __('Delete Account') }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                    </p>
                </div>
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection
