<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    /**
     * Generate certificate message using AI.
     *
     * @param string $goalTitle
     * @param string $userName
     * @return string
     */
    public static function generateCertificateMessage($goalTitle, $userName = null)
    {
        try {
            $apiKey = config('services.ai.api_key');
            $apiHost = config('services.ai.api_host');
            $apiBaseUrl = config('services.ai.api_base_url');
            $apiEndpoint = config('services.ai.api_endpoint');

            if (!$apiKey || !$apiHost || !$apiBaseUrl || !$apiEndpoint) {
                return self::getFallbackCertificateMessage($goalTitle, $userName);
            }

            $name = $userName ?: 'Achiever';
            $prompt = "Generate a congratulatory certificate message for {$name} who has successfully completed a goal titled '{$goalTitle}'. The message should be inspiring, motivational, and celebrate their achievement. Keep it between 2-3 sentences. Make it personal and encouraging. Use their name '{$name}' in the message.";

            $timeout = config('services.ai.timeout', 10);
            $response = Http::timeout($timeout)
                ->withHeaders([
                    'X-RapidAPI-Key' => $apiKey,
                    'X-RapidAPI-Host' => $apiHost,
                    'Content-Type' => 'application/json',
                ])->post($apiBaseUrl . $apiEndpoint, [
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.8,
                    'max_tokens' => 150,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $message = '';
                
                // RapidAPI ChatGPT response format
                if (isset($data['result']) && $data['status'] === true) {
                    $message = $data['result'];
                }
                // Fallback to OpenAI format if needed
                elseif (isset($data['choices'][0]['message']['content'])) {
                    $message = $data['choices'][0]['message']['content'];
                }
                else {
                    return self::getFallbackCertificateMessage($goalTitle, $userName);
                }
                
                // Clean the message
                return self::cleanAIMessage($message);
            }

            return self::getFallbackCertificateMessage($goalTitle, $userName);
        } catch (\Exception $e) {
            Log::error('AI Service Error: ' . $e->getMessage());
            return self::getFallbackCertificateMessage($goalTitle, $userName);
        }
    }

    /**
     * Generate affirmation message using AI.
     *
     * @param string $goalTitle
     * @param string $userName
     * @return string
     */
    public static function generateAffirmationMessage($goalTitle, $userName = null)
    {
        try {
            $apiKey = config('services.ai.api_key');
            $apiHost = config('services.ai.api_host');
            $apiBaseUrl = config('services.ai.api_base_url');
            $apiEndpoint = config('services.ai.api_endpoint');

            if (!$apiKey || !$apiHost || !$apiBaseUrl || !$apiEndpoint) {
                return self::getFallbackAffirmationMessage($goalTitle, $userName);
            }

            $name = $userName ?: 'You';
            $prompt = "Generate a powerful affirmation message for {$name} who has completed the goal '{$goalTitle}'. This should be a positive, empowering statement that reinforces their capability and success. Make it encouraging and motivational. Keep it to 1-2 sentences. Use their name '{$name}' in the message.";

            $timeout = config('services.ai.timeout', 10);
            $response = Http::timeout($timeout)
                ->withHeaders([
                    'X-RapidAPI-Key' => $apiKey,
                    'X-RapidAPI-Host' => $apiHost,
                    'Content-Type' => 'application/json',
                ])->post($apiBaseUrl . $apiEndpoint, [
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.8,
                    'max_tokens' => 100,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                $message = '';
                
                // RapidAPI ChatGPT response format
                if (isset($data['result']) && $data['status'] === true) {
                    $message = $data['result'];
                }
                // Fallback to OpenAI format if needed
                elseif (isset($data['choices'][0]['message']['content'])) {
                    $message = $data['choices'][0]['message']['content'];
                }
                else {
                    return self::getFallbackAffirmationMessage($goalTitle, $userName);
                }
                
                // Clean the message
                return self::cleanAIMessage($message);
            }

            return self::getFallbackAffirmationMessage($goalTitle, $userName);
        } catch (\Exception $e) {
            Log::error('AI Service Error: ' . $e->getMessage());
            return self::getFallbackAffirmationMessage($goalTitle, $userName);
        }
    }

    /**
     * Get fallback certificate message when AI is not available.
     *
     * @param string $goalTitle
     * @param string $userName
     * @return string
     */
    private static function getFallbackCertificateMessage($goalTitle, $userName = null)
    {
        $name = $userName ?: 'Achiever';
        
        $messages = [
            "Congratulations {$name}! You have successfully completed your goal {$goalTitle}. Your dedication, perseverance, and commitment have led you to this remarkable achievement. This certificate recognizes your outstanding accomplishment and serves as a testament to your ability to turn dreams into reality.",
            
            "This is to certify that {$name} has successfully achieved the goal {$goalTitle}. Your journey of growth and determination has culminated in this well-deserved success. May this achievement inspire you to continue reaching for even greater heights in your future endeavors.",
            
            "We proudly present this certificate to {$name} for the successful completion of {$goalTitle}. Your unwavering focus and relentless pursuit of excellence have made this achievement possible. This milestone represents not just the end of a goal, but the beginning of even greater accomplishments.",
            
            "Congratulations {$name}! You have demonstrated exceptional commitment and resilience in achieving your goal {$goalTitle}. This certificate celebrates your success and acknowledges the hard work, discipline, and passion that brought you to this moment. Your achievement serves as an inspiration to others.",
            
            "This certificate is awarded to {$name} for successfully completing {$goalTitle}. Your dedication to personal growth and your ability to overcome challenges have resulted in this outstanding achievement. May this success fuel your confidence to pursue and achieve even more ambitious goals."
        ];

        return $messages[array_rand($messages)];
    }

    /**
     * Clean AI generated message by removing unwanted symbols and formatting.
     *
     * @param string $message
     * @return string
     */
    private static function cleanAIMessage($message)
    {
        // Remove markdown formatting
        $message = preg_replace('/\*\*(.*?)\*\*/', '$1', $message); // Remove **bold**
        $message = preg_replace('/\*(.*?)\*/', '$1', $message); // Remove *italic*
        $message = preg_replace('/`(.*?)`/', '$1', $message); // Remove `code`
        
        // Remove quotes at the beginning and end
        $message = trim($message);
        $message = preg_replace('/^["\']+|["\']+$/', '', $message); // Remove quotes at start/end
        
        // Remove extra quotes within the text
        $message = str_replace('"', '', $message);
        $message = str_replace("'", '', $message);
        
        // Remove extra whitespace and normalize
        $message = preg_replace('/\s+/', ' ', $message);
        $message = trim($message);
        
        // Remove common AI prefixes/suffixes
        $message = preg_replace('/^(Here\'s|Here is|I\'ve created|I have created|Generated|AI generated):\s*/i', '', $message);
        $message = preg_replace('/\s*(This message|This certificate|The above|Generated by AI).*$/i', '', $message);
        
        // Remove numbered lists or bullet points
        $message = preg_replace('/^\d+\.\s*/m', '', $message);
        $message = preg_replace('/^[-*]\s*/m', '', $message);
        
        // Remove extra punctuation at the end
        $message = rtrim($message, '.!?');
        $message .= '.';
        
        return $message;
    }

    /**
     * Get fallback affirmation message when AI is not available.
     *
     * @param string $goalTitle
     * @param string $userName
     * @return string
     */
    private static function getFallbackAffirmationMessage($goalTitle, $userName = null)
    {
        $name = $userName ?: 'You';
        
        $affirmations = [
            "I am capable of achieving anything I set my mind to, as proven by my success in completing {$goalTitle}.",
            
            "My determination and perseverance are my superpowers, and they have led me to this incredible achievement.",
            
            "Every goal I complete strengthens my belief in my abilities and propels me toward even greater success.",
            
            "I am a goal-achiever, and my success with {$goalTitle} proves that I can accomplish anything I commit to.",
            
            "My achievements are a reflection of my inner strength and my ability to turn challenges into opportunities for growth."
        ];

        return $affirmations[array_rand($affirmations)];
    }
}
