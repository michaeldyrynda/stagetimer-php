<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer;

use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Request;
use Saloon\Http\Response;

abstract class Resource
{
    public function __construct(
        protected Stagetimer $connector,
    ) {}

    /**
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function send(Request $request): Response
    {
        $response = $this->connector->send($request);

        if ($response->failed()) {
            throw new RequestException($response, $response->json('message') ?: 'Unable to complete request', $response->status());
        }

        return $response;
    }
}
