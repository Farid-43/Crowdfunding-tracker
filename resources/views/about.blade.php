@extends('layouts.app')

@section('title', 'About Us - CrowdFunder')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 text-white overflow-hidden py-24">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGRlZnM+PHBhdHRlcm4gaWQ9ImdyaWQiIHdpZHRoPSI2MCIgaGVpZ2h0PSI2MCIgcGF0dGVyblVuaXRzPSJ1c2VyU3BhY2VPblVzZSI+PHBhdGggZD0iTSAxMCAwIEwgMCAwIDAgMTAiIGZpbGw9Im5vbmUiIHN0cm9rZT0id2hpdGUiIHN0cm9rZS13aWR0aD0iMSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3Qgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgZmlsbD0idXJsKCNncmlkKSIvPjwvc3ZnPg==')]"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl md:text-6xl font-extrabold mb-6">
            About CrowdFunder
        </h1>
        <p class="text-xl md:text-2xl text-indigo-50 max-w-3xl mx-auto">
            Empowering dreams through collective funding since 2025
        </p>
    </div>
</div>

<!-- Mission & Vision Section -->
<div class="bg-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Mission -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl opacity-10 group-hover:opacity-20 transition duration-300"></div>
                <div class="relative bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Mission</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To democratize funding and make it possible for anyone with a great idea to bring it to life. 
                        We believe that creativity and innovation should never be limited by financial barriers.
                    </p>
                </div>
            </div>

            <!-- Vision -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-pink-600 rounded-3xl opacity-10 group-hover:opacity-20 transition duration-300"></div>
                <div class="relative bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-br from-purple-500 to-pink-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Vision</h2>
                    <p class="text-gray-600 text-lg leading-relaxed">
                        To become the world's most trusted crowdfunding platform where every creator finds support 
                        and every backer discovers meaningful projects that inspire them.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div class="bg-gradient-to-br from-gray-50 to-gray-100 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Our Impact</h2>
            <p class="text-xl text-gray-600">Making a difference, one campaign at a time</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="text-5xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-2">
                    10K+
                </div>
                <div class="text-gray-600 font-semibold">Campaigns Funded</div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="text-5xl font-black bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
                    ৳50M+
                </div>
                <div class="text-gray-600 font-semibold">Money Raised</div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="text-5xl font-black bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                    100K+
                </div>
                <div class="text-gray-600 font-semibold">Active Backers</div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-lg text-center transform hover:-translate-y-2 transition-all duration-300">
                <div class="text-5xl font-black bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent mb-2">
                    95%
                </div>
                <div class="text-gray-600 font-semibold">Success Rate</div>
            </div>
        </div>
    </div>
</div>

<!-- Our Story Section -->
<div class="bg-white py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">Our Story</h2>
        </div>

        <div class="prose prose-lg mx-auto">
            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                CrowdFunder was born from a simple belief: great ideas deserve a chance to become reality. 
                Founded in 2025, we set out to create a platform where creativity meets opportunity, and 
                where communities come together to support innovation.
            </p>

            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                What started as a small project has grown into a thriving ecosystem of creators, entrepreneurs, 
                artists, and backers from around the world. Every day, we're inspired by the incredible projects 
                that launch on our platform and the generous supporters who make them possible.
            </p>

            <p class="text-gray-600 text-lg leading-relaxed">
                Today, CrowdFunder is more than just a platform—it's a movement. A movement that believes in 
                the power of collective action, the importance of creative expression, and the potential of 
                every individual to make a difference.
            </p>
        </div>
    </div>
</div>

<!-- Values Section -->
<div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-extrabold text-white mb-4">Our Values</h2>
            <p class="text-xl text-indigo-50">The principles that guide everything we do</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Trust -->
            <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="text-4xl mb-4">🤝</div>
                <h3 class="text-2xl font-bold text-white mb-3">Trust</h3>
                <p class="text-indigo-50 leading-relaxed">
                    Building trust between creators and backers through transparency, security, and accountability.
                </p>
            </div>

            <!-- Innovation -->
            <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="text-4xl mb-4">💡</div>
                <h3 class="text-2xl font-bold text-white mb-3">Innovation</h3>
                <p class="text-indigo-50 leading-relaxed">
                    Constantly evolving our platform to provide the best tools and features for our community.
                </p>
            </div>

            <!-- Community -->
            <div class="bg-white/10 backdrop-blur-lg p-8 rounded-2xl border border-white/20 hover:bg-white/20 transition-all duration-300">
                <div class="text-4xl mb-4">🌍</div>
                <h3 class="text-2xl font-bold text-white mb-3">Community</h3>
                <p class="text-indigo-50 leading-relaxed">
                    Fostering a supportive environment where creativity thrives and connections flourish.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-white py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-extrabold text-gray-900 mb-6">
            Ready to Join Our Community?
        </h2>
        <p class="text-xl text-gray-600 mb-10">
            Whether you're a creator with a vision or a backer looking for inspiring projects, 
            CrowdFunder is the place to be.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('campaigns.start') }}" 
               class="inline-flex items-center justify-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-8 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Start Your Campaign
            </a>
            <a href="{{ route('campaigns.index') }}" 
               class="inline-flex items-center justify-center border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-600 hover:text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                Explore Campaigns
            </a>
        </div>
    </div>
</div>
@endsection
