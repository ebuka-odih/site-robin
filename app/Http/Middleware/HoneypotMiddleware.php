<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HoneypotMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply honeypot validation to auth routes
        if ($request->is('login', 'register')) {
            // Check for suspicious patterns
            $userAgent = $request->userAgent();
            $ip = $request->ip();
            
            // List of known bot user agents
            $botPatterns = [
                'bot', 'crawler', 'spider', 'scraper', 'curl', 'wget', 'python', 'java',
                'php', 'perl', 'ruby', 'go-http', 'okhttp', 'apache-httpclient'
            ];
            
            // Check if user agent contains bot patterns
            $isBot = false;
            foreach ($botPatterns as $pattern) {
                if (stripos($userAgent, $pattern) !== false) {
                    $isBot = true;
                    break;
                }
            }
            
            // Check for missing or suspicious user agent
            if (empty($userAgent) || strlen($userAgent) < 10) {
                $isBot = true;
            }
            
            // Check for rapid requests from same IP (basic rate limiting)
            $cacheKey = 'honeypot_requests_' . $ip;
            $requestCount = cache()->get($cacheKey, 0);
            
            if ($requestCount > 5) { // More than 5 requests per minute
                $isBot = true;
            }
            
            // Increment request count
            cache()->put($cacheKey, $requestCount + 1, 60); // 1 minute cache
            
            if ($isBot) {
                \Log::warning('Bot detected by middleware', [
                    'ip' => $ip,
                    'user_agent' => $userAgent,
                    'url' => $request->fullUrl(),
                    'timestamp' => now()
                ]);
                
                // Return a generic error response
                return response()->json(['error' => 'Access denied'], 403);
            }
        }
        
        return $next($request);
    }
}