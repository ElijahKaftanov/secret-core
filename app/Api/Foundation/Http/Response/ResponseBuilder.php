<?php declare(strict_types=1);


namespace Classic\Secret\Core\Api\Foundation\Http\Response;

use Classic\Package\Support\Exception\InvalidArgumentException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class ResponseBuilder implements Responsable
{
    private $response;

    private $payload = [];

    public function __construct()
    {
        $this->response = new JsonResponse();
    }

    public function setStatus(int $code, string $message = null)
    {
        $this->response->setStatusCode($code, $message);

        return $this;
    }

    public function setErrors(array $errors): ResponseBuilder
    {
        $this->payload['errors'] = [];
        foreach ($errors as $error) {
            $this->addError($error);
        }

        return $this;
    }

    /**
     * @param string|array $error
     * @return ResponseBuilder
     */
    public function addError($error): ResponseBuilder
    {
        if (is_string($error)) {
            $error = ['message' => $error];
        }

        if (!is_array($error)) {
            throw InvalidArgumentException::unexpectedType(
                '$error',
                ['array', 'callable', 'string'],
                $error
            );
        }

        $this->payload['errors'][] = $error;

        return $this;
    }

    public function setData($data): self
    {
        Arr::set($this->payload, 'data', $data);

        return $this;
    }

    public function setMeta($meta)
    {
        Arr::set($this->payload, 'meta', $meta);

        return $this;
    }

    public function putMeta(string $path, $data)
    {
        Arr::set($this->payload, 'meta.' . $path, $data);

        return $this;
    }

    public function build(): Response
    {
        if (!isset($this->payload['meta']['status']['code'])) {
            $this->payload['meta']['status']['code'] = $this->response->getStatusCode();
        }

        $this->response->setStatusCode(\Illuminate\Http\Response::HTTP_OK);
        $this->response->setData($this->payload);

        return $this->response;
    }

    public static function create(): ResponseBuilder
    {
        return new static();
    }

    public function badRequest(): ResponseBuilder
    {
        return $this->setStatus(Response::HTTP_BAD_REQUEST);
    }

    public function notFound(): ResponseBuilder
    {
        return $this->setStatus(Response::HTTP_BAD_REQUEST);
    }

    public function accepted(): ResponseBuilder
    {
        return $this->setStatus(Response::HTTP_ACCEPTED);
    }

    public function toResponse($request)
    {
        return $this->build();
    }
}