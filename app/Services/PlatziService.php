<?php

namespace App\Services;

use App\Interfaces\PlatziInterface;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;

class PlatziService implements PlatziInterface
{
    private string $url;

    public function __construct()
    {
        $this->setUrl(env('PLATZI_API_URL'));
    }

    private function setUrl(string $url): void
    {
        $this->url = $url;
    }

    private function getApiResponse(string $method = 'GET', string $url = ''): Response
    {
        $client = new GuzzleClient();

        return $client->request($method, $url);
    }

    public function retrieveProducts(): Collection
    {
        $url = $this->url . 'products';

        $response = $this->getApiResponse('GET', $url);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error, wrong response from API.');
        }

        $content = $response->getBody()->getContents();

        $products = collect(json_decode($content));

        foreach ($products as $product) {
            $category = Category::find($product->category->id);

            if (!$category) {
                $category = Category::create([
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                    'image' => $product->category->image,
                    'created_at' => $product->category->creationAt,
                    'updated_at' => $product->category->updatedAt,
                ]);
            }

            if (!Product::find($product->id)) {
                Product::create([
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'images' => implode(', ', $product->images),
                    'description' => $product->description,
                    'category_id' => $category->id,
                    'created_at' => $product->creationAt,
                    'updated_at' => $product->updatedAt,
                ]);
            }
        }

        return $products;
    }
}
