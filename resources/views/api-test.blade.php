@extends('layouts.app')

@section('title', 'API Test - Lab 10')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">🚀 Lab 10: REST API Testing</h1>
        
        <div class="space-y-6">
            <!-- API Health Check -->
            <div class="border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">1. Health Check API</h2>
                <button onclick="testHealthApi()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Test Health API
                </button>
                <div id="health-result" class="mt-4 p-4 bg-gray-50 rounded hidden">
                    <pre id="health-output" class="text-sm"></pre>
                </div>
            </div>

            <!-- Campaigns API -->
            <div class="border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">2. Campaigns API</h2>
                <div class="space-x-2 mb-4">
                    <button onclick="testCampaignsApi()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Get All Campaigns
                    </button>
                    <button onclick="testCampaignsApi('?status=active')" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                        Get Active Campaigns
                    </button>
                    <button onclick="testCampaignsApi('?limit=5')" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                        Get 5 Campaigns
                    </button>
                </div>
                <div id="campaigns-result" class="mt-4 p-4 bg-gray-50 rounded hidden">
                    <pre id="campaigns-output" class="text-sm"></pre>
                </div>
            </div>

            <!-- Stats API -->
            <div class="border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">3. Platform Statistics API</h2>
                <button onclick="testStatsApi()" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Get Platform Stats
                </button>
                <div id="stats-result" class="mt-4 p-4 bg-gray-50 rounded hidden">
                    <pre id="stats-output" class="text-sm"></pre>
                </div>
            </div>

            <!-- Individual Campaign API -->
            <div class="border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">4. Single Campaign API</h2>
                <input type="number" id="campaign-id" placeholder="Enter Campaign ID" class="border border-gray-300 rounded px-3 py-2 mr-2" value="1">
                <button onclick="testSingleCampaign()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Get Campaign Details
                </button>
                <div id="single-result" class="mt-4 p-4 bg-gray-50 rounded hidden">
                    <pre id="single-output" class="text-sm"></pre>
                </div>
            </div>
        </div>

        <!-- API Endpoints Reference -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-4">📋 Available API Endpoints</h3>
            <div class="space-y-2 text-sm">
                <div><code class="bg-blue-100 px-2 py-1 rounded">GET /api/health</code> - API health check</div>
                <div><code class="bg-blue-100 px-2 py-1 rounded">GET /api/campaigns</code> - List all campaigns</div>
                <div><code class="bg-blue-100 px-2 py-1 rounded">GET /api/campaigns?status=active</code> - Filter by status</div>
                <div><code class="bg-blue-100 px-2 py-1 rounded">GET /api/campaigns?category=Technology</code> - Filter by category</div>
                <div><code class="bg-blue-100 px-2 py-1 rounded">GET /api/campaigns?limit=10</code> - Limit results</div>
                <div><code class="bg-blue-100 px-2 py-1 rounded">GET /api/campaigns/{id}</code> - Get single campaign</div>
                <div><code class="bg-blue-100 px-2 py-1 rounded">GET /api/stats</code> - Platform statistics</div>
            </div>
        </div>
    </div>
</div>

<script>
// Lab 10: AJAX/Fetch API Implementation
async function makeApiRequest(url) {
    try {
        const response = await fetch(url);
        const data = await response.json();
        return { success: true, data, status: response.status };
    } catch (error) {
        return { success: false, error: error.message };
    }
}

async function testHealthApi() {
    const result = await makeApiRequest('/api/health');
    displayResult('health', result);
}

async function testCampaignsApi(params = '') {
    const result = await makeApiRequest('/api/campaigns' + params);
    displayResult('campaigns', result);
}

async function testStatsApi() {
    const result = await makeApiRequest('/api/stats');
    displayResult('stats', result);
}

async function testSingleCampaign() {
    const campaignId = document.getElementById('campaign-id').value;
    const result = await makeApiRequest(`/api/campaigns/${campaignId}`);
    displayResult('single', result);
}

function displayResult(type, result) {
    const resultDiv = document.getElementById(type + '-result');
    const outputPre = document.getElementById(type + '-output');
    
    resultDiv.classList.remove('hidden');
    
    if (result.success) {
        outputPre.textContent = JSON.stringify(result.data, null, 2);
        outputPre.className = 'text-sm text-green-800';
    } else {
        outputPre.textContent = `Error: ${result.error}`;
        outputPre.className = 'text-sm text-red-800';
    }
}
</script>
@endsection