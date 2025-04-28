<?php

namespace App\Service\Google\GenerativeLanguage;

use Illuminate\Support\Facades\Http;

class GenerativeLanguageService
{
    private string $apiKey = 'AIzaSyAxWYjuIE9TOiikSMyht_RjchGtFsc80qo';
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro-latest:generateContent';

    public function generateNews($category, $briefDescription): array
    {
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => "Crie uma notícia jornalística na categoria '$category', com base na seguinte descrição: '$briefDescription'.
                    A resposta deve ser no formato JSON assim:
                    {\"title\": \"Título da Notícia\", \"content\": \"Conteúdo detalhado da notícia\"}"]
                    ]
                ]
            ]
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}?key={$this->apiKey}", $payload);

        $responseData = $response->json();

        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            $text = $responseData['candidates'][0]['content']['parts'][0]['text'];
        } else {
            throw new \Exception('Resposta inválida do modelo.');
        }

        $text = trim($text);
        $text = preg_replace('/^```json|```$/', '', $text);
        $text = trim($text);

        return json_decode($text, true);
    }
}
