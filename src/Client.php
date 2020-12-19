<?php
namespace Purp\ScalablepressAPI;
use Exception;
use GrahamCampbell\GuzzleFactory\GuzzleFactory;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
class Client{
    protected $apikey;
    protected $endPoint = "https://api.scalablepress.com/v2/categories";
    protected $client;
    function __construct($key)
    {
        $this->client = new GuzzleClient();
        $this->key = $key;
    }

    public function cancelOrder($orderId)
    {
        try {
            $response = $this->client->request('DELETE', 'https://api.scalablepress.com/v2/order/' . $orderId, [
                'auth' => ['', $this->key]
            ]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            }
        }
    }

    public function getOrderEvents($orderId)
    {
        $key = $this->key;
        try {
            $response = $this->client->request('GET', 'https://api.scalablepress.com/v3/event', [
                'auth'  => ['', $key],
                'query' => ["orderId" => $orderId]
            ]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            }
        }
    }

    public function getProductImage($design_id)
    {
        try {
            $response = $this->client->request('GET', 'https://api.scalablepress.com/v2/design/' . $design_id, [
                'auth' => ['', $this->key]
            ]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            }
        }
    }

    public function getOrder($order_id)
    {
        try {
            $response = $this->client->request('GET', 'https://api.scalablepress.com/v2/order/' . $order_id, [
                'auth' => ['', $this->key]
            ]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            }
        }
    }

//    public function sendQuote($data)
//    {
//        $address = $data->address;
//        $items   = [];
//        $i       = 0;
//        $temp    = $data->items;
//        foreach ($temp as $item) {
//            if (isset($item["customizes"])) {
//                $products = ScalableProduct::where('sku', $item['sku'])->where('account_id', $item['account_id'])->where('customizes', $item['customizes'])->where('scalable_account_id', getCurrentScalableAccountFulfillId())->get();
//            } else {
//                $products = ScalableProduct::where('sku', $item['sku'])->where('account_id', $item['account_id'])->whereNull('customizes')->where('scalable_account_id', getCurrentScalableAccountFulfillId())->get();
//            }
//            foreach ($products as $product) {
//                if ($item['quantity'] <= 0) {
//                    continue;
//                }
//                if ($product->type != "poster") {
//                    $items["items[" . $i . "][type]"]                  = $product->type;
//                    $items["items[" . $i . "][products][0][id]"]       = $product->product_id;
//                    $items["items[" . $i . "][products][0][color]"]    = $product->color;
//                    $items["items[" . $i . "][products][0][quantity]"] = $item['quantity'];
//                    $items["items[" . $i . "][products][0][size]"]     = $product->size;
//                    $items["items[" . $i . "][designId]"]              = $product->design_id;
//                    $items["items[" . $i . "][address][name]"]         = $address->name;
//                    $items["items[" . $i . "][address][address1]"]     = $address->address1;
//                    $items["items[" . $i . "][address][address2]"]     = $address->address2;
//                    $items["items[" . $i . "][address][city]"]         = $address->city;
//                    $items["items[" . $i . "][address][state]"]        = $address->state;
//                    $items["items[" . $i . "][address][zip]"]          = $address->zip;
//                    $items["items[" . $i . "][address][country]"]      = $address->countryCode;
//                    $i++;
//                } else {
//                    for ($j = 0; $j < $item['quantity']; $j++) {
//                        $items["items[" . $i . "][type]"]                  = $product->type;
//                        $items["items[" . $i . "][products][0][id]"]       = $product->product_id;
//                        $items["items[" . $i . "][products][0][color]"]    = $product->color;
//                        $items["items[" . $i . "][products][0][quantity]"] = 1;
//                        $items["items[" . $i . "][products][0][size]"]     = $product->size;
//                        $items["items[" . $i . "][designId]"]              = $product->design_id;
//                        $items["items[" . $i . "][address][name]"]         = $address->name;
//                        $items["items[" . $i . "][address][address1]"]     = $address->address1;
//                        $items["items[" . $i . "][address][address2]"]     = $address->address2;
//                        $items["items[" . $i . "][address][city]"]         = $address->city;
//                        $items["items[" . $i . "][address][state]"]        = $address->state;
//                        $items["items[" . $i . "][address][zip]"]          = $address->zip;
//                        $items["items[" . $i . "][address][country]"]      = $address->countryCode;
//                        $i++;
//                    }
//                }
//            }
//            //				$i_++;
//        }
//        try {
//            $response = $this->client->request(
//                'POST',
//                'https://api.scalablepress.com/v2/quote/bulk',
//                [
//                    'auth'        => ['', $this->key],
//                    'form_params' => $items
//                ]
//            );
//            return $response->getBody()->getContents();
//        } catch (RequestException $e) {
//            if ($e->hasResponse()) {
//                return $e->getResponse()->getBody()->getContents();
////                dd(Psr7\str($e->getResponse()));
//            }
//        }
//    }

//    public function sendQuote2($data)
//    {
//        $product = ScalableProduct::where('sku', $data->items[0]['sku'])->first();
//        $address = $data->address;
//
//        try {
//            $response = $this->client->request(
//                'POST',
//                'https://api.scalablepress.com/v2/quote',
//                [
//                    'auth'        => ['', $this->key],
//                    'form_params' => [
//                        'type'                  => 'mug',
//                        'products[0][id]'       => $product->product_id,
//                        "products[0][color]"    => $product->color,
//                        "products[0][quantity]" => $data->items[0]['quantity'],
//                        "products[0][size]"     => "11oz",
//
//                        "address[name]"     => $address->name,
//                        "address[address1]" => $address->address1,
//                        "address[address2]" => $address->address2,
//                        "address[city]"     => $address->city,
//                        "address[state]"    => $address->state,
//                        "address[zip]"      => $address->zip,
//                        "address[country]"  => $address->countryCode,
//                        "designId"          => $product->design_id
//                    ]
//                ]
//            );
//            return $response->getBody()->getContents();
//        } catch (RequestException $e) {
//            if ($e->hasResponse()) {
//                return $e->getResponse()->getBody()->getContents();
//                dd(Psr7\str($e->getResponse()));
//            }
//        }
//    }

//    public function sendOrder($orderToken)
//    {
//
//        try {
//            $response = $this->client->request(
//                'POST',
//                'https://api.scalablepress.com/v2/order',
//                [
//                    'auth'        => ['', $this->key],
//                    'form_params' => [
//                        'orderToken' => $orderToken,
//                    ]
//                ]
//            );
//            return $response->getBody()->getContents();
//        } catch (RequestException $e) {
//            if ($e->hasResponse()) {
//                return $e->getResponse()->getBody()->getContents();
//                echo Psr7\str($e->getResponse());
//            }
//        }
//    }

    public function getDesign($designID)
    {
        $ids = explode(",", $designID);
        for ($i = 0; $i < count($ids); $i++) {
            try {
                $response = $this->client->request('GET', 'https://api.scalablepress.com/v2/design/' . $ids[$i], [
                    'auth' => ['', $this->key]
                ]);
                return $response->getBody()->getContents();
            } catch (RequestException $e) {
                if ($e->hasResponse()) {
                    return $e->getResponse()->getBody()->getContents();
                    echo Psr7\str($e->getResponse());
                }
            }
        }
    }
    public function uploadDesign($data)
    {
        // dd($data);
        try {
            $response = $this->client->request('POST', 'https://api.scalablepress.com/v2/design', [
                'auth'        => ['', $this->key],
                'form_params' => $data
            ]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return $e->getResponse()->getBody()->getContents();
            }
            return $e->getResponse()->getBody()->getContents();
        }
    }
}
