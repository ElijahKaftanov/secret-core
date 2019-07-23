<?php declare(strict_types=1);

namespace Classic\Secret\Core\Api\Service;

use Classic\Package\Support\Exception\NotImplementedException;
use Classic\Secret\Core\Foundation\Architecture\ServiceTrait;
use Classic\Secret\Package\Crypt\SignCheckerInterface;
use Illuminate\Http\Request;

class RequestSignatureService
{
    use ServiceTrait;

    public function check($request, SignCheckerInterface $checker): bool
    {
        if (!$request instanceof Request) {
            throw new NotImplementedException();
        }

        $sign = $request->headers->get('x-sign');
        if (!is_string($sign)) {
            return false;
        }

        $sign = base64_decode($sign);

        $message = $request->getUri() . $request->getContent();

        return $checker->check($message, $sign);
    }
}