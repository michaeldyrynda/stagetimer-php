<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer;

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
        return $this->connector->send($request);
    }
}
