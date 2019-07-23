<?php declare(strict_types=1);

namespace Classic\Secret\Core\Api\Controller;


use Classic\Package\Support\Tool\Dot\Dot;
use Classic\Secret\Core\Api\Service\RequestSignatureService;
use Classic\Secret\Core\Domain\System\SystemManager;
use Classic\Secret\Core\Domain\User\UserManager;
use Classic\Secret\Core\Repository\UserRepository;
use Classic\Secret\Core\Model\Secret;
use Classic\Secret\Core\Model\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SecretController extends AbstractApiController
{
    public function view(Request $request)
    {
        $data = Dot::find($request->all(), 'data', []);

        // validation here

        $user = $this->getUser($data['username']);
        $this->verifyRequest($request, $user);

        /** @var Secret $secret */
        $secret = Secret::query()
            ->where('user_id', $user->id)
            ->where('name', $data['secretName'])
            ->first();

        if (is_null($secret)) {
            throw new NotFoundHttpException();
        }

        $message = $secret->message;
        $message = SystemManager::up()->decrypt($message);
        $message = UserManager::up()->getEncryptor($user)->encrypt($message);

        return $this->response()->setData([
            'name' => $secret,
            'encryptedSecret' => $message
        ]);
    }

    public function store(Request $request)
    {
        $data = Dot::find($request->all(), 'data', []);

        // validation here

        $user = $this->getUser($data['username']);
        $this->verifyRequest($request, $user);

        $message = $data['encryptedSecret'];

        $secret = new Secret();
        $secret->user_id = $user->id;
        $secret->name = $data['secretName'];
        $secret->message = $message;
        $secret->save();

        return $this->response();
    }

    private function getUser(string $username): User
    {
        $user = UserRepository::up()->findByUsername($username);
        if (is_null($user)) {
            throw new NotFoundHttpException();
        }
        return $user;
    }

    private function verifyRequest(Request $request, User $user)
    {
        $checker = UserManager::up()->getSignChecker($user);
        if (!RequestSignatureService::up()->check($request, $checker)) {
            throw new BadRequestHttpException();
        }
    }
}