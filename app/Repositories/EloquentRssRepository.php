<?php

namespace App\Repositories;

use App\Xpath;
use Carbon\Carbon;
use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class EloquentRssRepository implements RssRepositoryContract {
    
    public function query() {
        $allXpaths = Xpath::all();

        $now = Carbon::now();

        $xpaths = $allXpaths->filter(function ($value, $key) use ($now) {
            $diff = $now->diffInHours(Carbon::parse($value->created_at));
            return $diff % $value->interval == 0;
        });

        return $xpaths;
    }
    
    /*
    * 更新 rss
    */
	public function update($xpaths) {
        $client = new Client();

        $requests = function ($xpaths) {
            $uri = 'http://phubb.cweiske.de/hub.php';
            foreach($xpaths as $xpath) {
                yield new Request('POST', $uri, [
                        'form_params' => [
                            'hub.mode' => 'publish',
                            'hub.url' => url("/feed/$xpath->id")
                        ]
                    ]
                );
            }
        };

        $pool = new Pool($client, $requests($xpaths), [
            'concurrency' => 5,
            'fulfilled' => function ($response, $index) {
                // this is delivered each successful response
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();
        
        info('end'.count($xpaths));
    }
}