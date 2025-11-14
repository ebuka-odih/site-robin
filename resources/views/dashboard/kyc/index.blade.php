@extends('dashboard.layout.app')
@section('content')

<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
        <div>
            <h1 class="text-2xl font-bold text-white">KYC Verification</h1>
            <p class="text-gray-400 mt-1">Complete your identity verification to unlock all platform features</p>
        </div>
        
        <!-- Overall Status Badge -->
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-400">Status:</span>
            <span class="px-3 py-1 text-sm font-medium rounded-full 
                {{ $kycStatus['overall_status'] === 'completed' ? 'bg-green-100 text-green-800' : 
                   ($kycStatus['overall_status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst($kycStatus['overall_status']) }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-600 border border-green-500 text-white px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-600 border border-red-500 text-white px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.kyc.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <!-- Personal Information -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-white">Personal Information</h3>
                <span class="px-3 py-1 text-sm font-medium rounded-full 
                    {{ $kycStatus['personal_info']['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($kycStatus['personal_info']['status']) }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                    <input type="text" value="{{ $kycStatus['personal_info']['full_name'] }}" 
                           class="w-full px-3 py-2 bg-gray-600 border border-gray-500 rounded-lg text-gray-400" disabled>
                    <p class="text-xs text-gray-500 mt-1">Full name cannot be changed</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                    <input type="email" value="{{ $kycStatus['personal_info']['email'] }}" 
                           class="w-full px-3 py-2 bg-gray-600 border border-gray-500 rounded-lg text-gray-400" disabled>
                    <p class="text-xs text-gray-500 mt-1">Email cannot be changed</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Phone</label>
                    <input type="text" value="{{ $kycStatus['personal_info']['phone'] }}" 
                           class="w-full px-3 py-2 bg-gray-600 border border-gray-500 rounded-lg text-gray-400" disabled>
                    <p class="text-xs text-gray-500 mt-1">Phone cannot be changed</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ $kycStatus['personal_info']['date_of_birth'] }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nationality</label>
                    <input type="text" name="nationality" value="{{ $kycStatus['personal_info']['nationality'] }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-white">Address Information</h3>
                <span class="px-3 py-1 text-sm font-medium rounded-full 
                    {{ $kycStatus['address_info']['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($kycStatus['address_info']['status']) }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Street Address</label>
                    <input type="text" name="street_address" value="{{ $kycStatus['address_info']['street_address'] }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">City</label>
                    <input type="text" name="city" value="{{ $kycStatus['address_info']['city'] }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">State/Province</label>
                    <input type="text" name="state" value="{{ $kycStatus['address_info']['state'] }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Postal Code</label>
                    <input type="text" name="postal_code" value="{{ $kycStatus['address_info']['postal_code'] }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Country</label>
                    <input type="text" name="country" value="{{ $kycStatus['address_info']['country'] }}" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- ID Information -->
        <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-white">Identity Documents</h3>
                <span class="px-3 py-1 text-sm font-medium rounded-full 
                    {{ $kycStatus['id_info']['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($kycStatus['id_info']['status']) }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">ID Type</label>
                    <select name="id_type" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500">
                        <option value="">Select ID Type</option>
                        <option value="passport" {{ $kycStatus['id_info']['id_type'] === 'passport' ? 'selected' : '' }}>Passport</option>
                        <option value="national_id" {{ $kycStatus['id_info']['id_type'] === 'national_id' ? 'selected' : '' }}>National ID</option>
                        <option value="drivers_license" {{ $kycStatus['id_info']['id_type'] === 'drivers_license' ? 'selected' : '' }}>Driver's License</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">ID Front Side</label>
                    <input type="file" name="id_front" accept="image/*" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <p class="text-xs text-gray-500 mt-1">Upload front side of your ID document</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">ID Back Side</label>
                    <input type="file" name="id_back" accept="image/*" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <p class="text-xs text-gray-500 mt-1">Upload back side of your ID document</p>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Selfie with ID (Optional)</label>
                    <input type="file" name="selfie" accept="image/*" 
                           class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white focus:outline-none focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <p class="text-xs text-gray-500 mt-1">Take a selfie while holding your ID document (optional)</p>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                Submit KYC Application
            </button>
        </div>
    </form>
</div>

@endsection
