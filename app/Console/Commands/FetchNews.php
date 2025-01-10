<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchNews extends Command
{
    protected $signature = 'news:fetch';
    protected $description = 'Fetch articles from news APIs';

    public function handle()
    {
        $apis = [
            'https://newsapi.org/v2/top-headlines?country=us&apiKey=f4b8456f2a29403292c8b7e64e0a28d5',
            'https://content.guardianapis.com/editions?q=uk&api-key=9f69b2aa-9b71-490a-8a14-20b82a81dedd',
            // 'https://api.nytimes.com/svc/search/v2/articlesearch.json',
        ];
    
        foreach ($apis as $api) {
        
            $response = Http::get($api);
    
           
            if ($response->successful()) {
              
                $articles = $response->json()['articles'] ?? [];
    
               
                foreach ($articles as $data) {
                  
                    $title = $data['title'] ?? null;
                    $content = $data['content'] ?? null;
                    $source = $data['source']['name'] ?? 'unknown';
                    $url = $data['url'] ?? null;
                    $publishedAt = $data['publishedAt'] ?? now(); 
    
                    if ($title && $content && $url) {
                       
                        $publishedAt = \Carbon\Carbon::parse($publishedAt)->format('Y-m-d H:i:s');
    
                       
                        Article::updateOrCreate(
                            ['title' => $title],
                            [
                                'title' => $title,
                                'content' => $content,
                                'category' => $data['category'] ?? 'general',
                                'source' => $source,
                                'url' => $url,
                                'published_at' => $publishedAt,
                            ]
                        );
                    } else {
                        // Log if the article is missing required fields (for debugging purposes)
                        \Log::warning('Skipping article due to missing required fields', ['article' => $data]);
                    }
                }
    
                $this->info('Articles fetched and stored successfully from ' . $api);
            } else {
              
                \Log::error('Failed to fetch articles from ' . $api, ['response' => $response->body()]);
                $this->error('Failed to fetch articles from ' . $api);
            }
        }
    }
    
}
