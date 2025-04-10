<!-- Settings Section -->
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg font-semibold mb-4">System Settings</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-gray-700 mb-2">General Settings</h4>
                <div class="bg-gray-50 p-4 rounded">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="site_name">Site Name</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="site_name" type="text" value="WineRecommender">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="contact_email">Contact Email</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="contact_email" type="email" value="contact@winerecommender.com">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="timezone">Timezone</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="timezone">
                            <option>UTC</option>
                            <option selected>Asia/Kolkata</option>
                            <option>America/New_York</option>
                            <option>Europe/London</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div>
                <h4 class="font-medium text-gray-700 mb-2">Email Settings</h4>
                <div class="bg-gray-50 p-4 rounded">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="mail_driver">Mail Driver</label>
                        <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="mail_driver">
                            <option>smtp</option>
                            <option>sendmail</option>
                            <option>mailgun</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="mail_host">Mail Host</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="mail_host" type="text" value="smtp.mailtrap.io">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="mail_port">Mail Port</label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="mail_port" type="text" value="2525">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6">
            <button class="bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition">
                Save Settings
            </button>
        </div>
    </div>
</div>
