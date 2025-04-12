<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Store') }}
        </h2>
    </x-slot>

    <div class="py-20">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('admin.stores.update', $store) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Store Name -->
                            <div>
                                <x-input-label for="store_name" :value="__('Store Name')" />
                                <x-text-input id="store_name" class="block mt-1 w-full" type="text" name="store_name" :value="old('store_name', $store->store_name)" required autofocus />
                                <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                            </div>

                            <!-- Business Type -->
                            <div>
                                <x-input-label for="business_type" :value="__('Business Type')" />
                                <x-text-input id="business_type" class="block mt-1 w-full" type="text" name="business_type" :value="old('business_type', $store->business_type)" />
                                <x-input-error :messages="$errors->get('business_type')" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Address')" />
                                <textarea id="address" name="address" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('address', $store->address) }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>

                            <!-- Contact Number -->
                            <div>
                                <x-input-label for="contact_number" :value="__('Contact Number')" />
                                <x-text-input id="contact_number" class="block mt-1 w-full" type="text" name="contact_number" :value="old('contact_number', $store->contact_number)" />
                                <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $store->email)" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- State -->
                            <div>
                                <x-input-label for="state" :value="__('State')" />
                                <x-text-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state', $store->state)" />
                                <x-input-error :messages="$errors->get('state')" class="mt-2" />
                            </div>

                            <!-- License Type -->
                            <div>
                                <x-input-label for="licence_type" :value="__('License Type')" />
                                <x-text-input id="licence_type" class="block mt-1 w-full" type="text" name="licence_type" :value="old('licence_type', $store->licence_type)" />
                                <x-input-error :messages="$errors->get('licence_type')" class="mt-2" />
                            </div>

                            <!-- License Number -->
                            <div>
                                <x-input-label for="license_number" :value="__('License Number')" />
                                <x-text-input id="license_number" class="block mt-1 w-full" type="text" name="license_number" :value="old('license_number', $store->license_number)" />
                                <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                            </div>

                            <!-- Group -->
                            <div>
                                <x-input-label for="group" :value="__('Group')" />
                                <x-text-input id="group" class="block mt-1 w-full" type="text" name="group" :value="old('group', $store->group)" />
                                <x-input-error :messages="$errors->get('group')" class="mt-2" />
                            </div>

                            <!-- GST/VAT -->
                            <div>
                                <x-input-label for="gst_vat" :value="__('GST/VAT')" />
                                <x-text-input id="gst_vat" class="block mt-1 w-full" type="text" name="gst_vat" :value="old('gst_vat', $store->gst_vat)" />
                                <x-input-error :messages="$errors->get('gst_vat')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select id="status" name="status" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="active" {{ old('status', $store->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $store->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.stores.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Store') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
