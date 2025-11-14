@extends('dashboard.layout.app')

@php
    $livechatService = app(\App\Services\LivechatService::class);
    $livechatConfig = $livechatService->getWidgetConfig();
    $showLivechat = $livechatService->shouldShowOnPage('support');
@endphp

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Support Center</h1>
            <p class="text-gray-400 mt-1">Get help and support for your account</p>
        </div>
    </div>

    <!-- Support Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Support Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contact Information -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">Email Support</h3>
                            <p class="text-gray-400 text-sm">{{ \App\Helpers\WebsiteSettingsHelper::getSiteEmail() }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">Response Time</h3>
                            <p class="text-gray-400 text-sm">Within 24 hours</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Frequently Asked Questions</h2>
                <div class="space-y-4">
                    <div class="border-b border-gray-700 pb-4">
                        <h3 class="text-white font-medium mb-2">How do I make a deposit?</h3>
                        <p class="text-gray-400 text-sm">Go to the Transactions section and select "Deposit". Choose your preferred payment method and follow the instructions.</p>
                    </div>
                    
                    <div class="border-b border-gray-700 pb-4">
                        <h3 class="text-white font-medium mb-2">How long does withdrawal take?</h3>
                        <p class="text-gray-400 text-sm">Withdrawals are typically processed within 24-48 hours after approval by our team.</p>
                    </div>
                    
                    <div class="border-b border-gray-700 pb-4">
                        <h3 class="text-white font-medium mb-2">What are the trading fees?</h3>
                        <p class="text-gray-400 text-sm">Trading fees vary by plan. Check your subscription details in the dashboard for specific rates.</p>
                    </div>
                    
                    <div>
                        <h3 class="text-white font-medium mb-2">How do I change my password?</h3>
                        <p class="text-gray-400 text-sm">Go to your profile settings and select "Change Password" to update your account security.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Chat Widget -->
        @if($showLivechat)
        <div class="lg:col-span-1">
            <div class="bg-gray-800 rounded-lg border border-gray-700 p-6">
                <h2 class="text-xl font-semibold text-white mb-4">Live Chat Support</h2>
                <p class="text-gray-400 text-sm mb-4">Chat with our support team in real-time for immediate assistance.</p>
                
                <!-- Live Chat Widget Container -->
                <div id="livechat-widget" class="min-h-[400px] bg-gray-700 rounded-lg">
                    @php
                        $widgetScript = $livechatService->getWidgetScript();
                    @endphp
                    @if($widgetScript)
                    <!-- Livechat widget will load here -->
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-medium mb-2">Live Chat Available</h3>
                            <p class="text-gray-400 text-sm">Chat widget is loading. Look for the chat button on the page.</p>
                        </div>
                    </div>
                    @else
                    <!-- Default JivoChat demo -->
                    <div class="h-full flex items-center justify-center">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-white font-medium mb-2">Demo Live Chat</h3>
                            <p class="text-gray-400 text-sm">Using JivoChat demo widget. Configure your own widget in admin settings.</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@if($showLivechat)
<!-- Livechat Widget Script -->
@php
    $widgetScript = $livechatService->getWidgetScript();
@endphp
@if($widgetScript)
{!! $widgetScript !!}
@else
<!-- Default JivoChat Widget (Fallback) -->
<script>
(function(d,s,id){
    var z = d.createElement(s);
    var ts = (+new Date()).toString(36);
    z.type = "text/javascript"; z.async = true; z.id = id;
    z.src = "https://code.jivosite.com/widget/demo";
    var f = function(){var sd = d.getElementById(id);if(!sd) return;var p = d.getElementsByTagName(s)[0];p.parentNode.insertBefore(sd,p);};
    if(d.readyState === "complete") f(); else if(d.addEventListener) d.addEventListener("DOMContentLoaded", f, false);
})(document, "script", "jivosite-script");
</script>
@endif

<!-- Hide loading message when widget loads -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide loading message after 3 seconds to show widget has loaded
    setTimeout(function() {
        var loadingDiv = document.querySelector('#livechat-widget .animate-pulse');
        if (loadingDiv) {
            loadingDiv.style.display = 'none';
        }
    }, 3000);
    
    // Also hide loading message when JivoChat widget appears
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length > 0) {
                // Check if JivoChat widget was added
                for (var i = 0; i < mutation.addedNodes.length; i++) {
                    var node = mutation.addedNodes[i];
                    if (node.nodeType === 1) { // Element node
                        if (node.classList && (node.classList.contains('jivo-widget') || node.id === 'jivosite-script')) {
                            var loadingDiv = document.querySelector('#livechat-widget .animate-pulse');
                            if (loadingDiv) {
                                loadingDiv.style.display = 'none';
                            }
                        }
                    }
                }
            }
        });
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
</script>

@if($livechatConfig['custom_css'])
<style>
{!! $livechatConfig['custom_css'] !!}
</style>
@endif
@endif
@endsection
