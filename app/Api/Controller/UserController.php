<?php declare(strict_types=1);

namespace Classic\Secret\Core\Api\Controller;


use Classic\Secret\Core\Model\User;
use Illuminate\Http\Request;

class UserController extends AbstractApiController
{
    public function register(Request $request)
    {
        $data = $request->get('data', []);

        //validation here


        dump($request->all());

        $user = new User();
        $user->username = $data['username'];
        $user->public_key = $data['publicKey'];

        $user->save();
    }
}