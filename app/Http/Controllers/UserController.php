<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }


    public function logging(Request $request): mixed
    {
        try {
            $validator = $this->getDataByRequest($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        $user = User::where('login', $validator['login'])
            ->where('password', $validator['password'])->firstOrFail();
        $token = Str::random(40);
        $user->update(['remember_token' => $token]);
        return $user->jsonSerialize(true);
    }

    /**
     * @throws ValidationException
     */
    private function getDataByRequest(Request $request): array
    {
        $data = $request->all();
        return validator(
            $data,
            [
                'login' => 'required|string',
                'password' => 'required|string',
            ]
        )->validate();
    }
}
