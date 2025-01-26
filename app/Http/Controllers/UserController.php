<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Modules\Test\Models\UserAnswersType;
use App\Modules\Test\Models\UserTest;
use App\Modules\User\Models\Invite;
use App\Modules\User\Models\Token;
use App\Modules\User\Models\User;
use App\Wrapper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    use Wrapper;

    public function index(User $user): User
    {
        return $user;
    }

    public function activeUser(User $user): array
    {
        $user->active = true;
        try {
            $user->save();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    public function getInvite(Request $request)
    {
        return Invite::where('code', $request->get('code'))
            ->where('date_end', '>=', Carbon::now())
            ->firstOrFail();
    }

    public function invite(Request $request): mixed
    {
        try {
            $validator = $this->getDataByRequestInvite($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try {
            $invite = Invite::create($validator);
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return $invite;
    }

    public function check(Request $request)
    {
        $data = $request->all();
        if(empty($data['token'])) {
            return [];
        }
        $token = Token::where('token', $data['token'])->first();
        if (empty($token)) {
            $userInfo = json_decode(Crypt::decryptString($data['token']), true);
        } else {
            $userInfo = json_decode(Crypt::decryptString($token->token), true);
            $token->delete();
        }
        $user = User::where('id', $userInfo['id'])->firstOrFail();
        $token = Crypt::encryptString(json_encode($user->jsonSerialize()));
        Token::create(['token' => $token]);
        $user->update(['remember_token' => $token]);
        return $user->jsonSerialize(true);
    }

    public function register(Request $request): array
    {
        try {
            $validator = $this->getDataByRequestRegister($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try {
            $user = User::create($validator);
            if ($validator['active']) {
                $token = Crypt::encryptString(json_encode($user->jsonSerialize()));
                $user->update(['remember_token' => $token]);
            }
            if (!empty($validator['group'])) {
                $user->groups()->sync([$validator['group']['id']]);
            }
            if (!empty($validator['rights'])) {
                $rightsIds = array_column($validator['rights'], 'id');
                $user->rights()->sync($rightsIds);
            }
            $user->update();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return $user->jsonSerialize($validator['active']);
    }

    public function test(Request $request): array
    {
        try {
            $validator = $this->getDataUserTestByRequest($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        try {
            $userTest = UserTest::where('user_id', Auth::getUser()->id)
                ->where('test_id', $validator['test_id'])
                ->first();
            if (empty($userTest)) {
                $userTest = UserTest::create($validator);
            }
            $answersStrings = [];
            if (!empty($validator['answers'])) {
                $userAnswerIds = array_column($validator['answers'], 'id');
                $userTest->answers()->sync($userAnswerIds);
                foreach ($validator['answers'] as $answer) {
                    if(array_key_exists('questionId', $answer)) {
                        $answersStrings[] = $answer;
                    }
                }
            }
            $userTest->trail += 1;
            $userTest->score = $this->scoreCounter($userTest, $answersStrings);
            $userTest->type_id = match (true) {
                $userTest->score <= UserAnswersType::where('code', 'success')->first()->id
                => UserAnswersType::where('code', 'failed')->first()->id ,
                default => 2
            };
            $userTest->update();
        } catch (\Exception $e) {
            return self::failed($e->getMessage());
        }
        return self::success();
    }

    private function scoreCounter(UserTest $userTest, array $answersSelected = []): int
    {
        $questions = $userTest->test()->first()->questions()->get();
        $answers = $userTest->answers()->get();
        $count = $questions->count();
        $score = 0;
        foreach ($questions as $question) {
            if ('single' === $question->type()->first()->code) { //todo потом подумать как текстовый вод решить
                $rightId = null;
                foreach ($question->answers()->get() as $answer) {
                    if ($answer->right) {
                        $rightId = $answer->id;
                    }
                }
                foreach ($answers as $answer) {
                    if ($answer->id === $rightId) {
                        $score += 1;
                        break;
                    }
                }
            } elseif ('multiple' === $question->type()->first()->code) { // это пиздец лучше так не делать
                $rightIds = [];
                foreach ($question->answers()->get() as $answer) {
                    if ($answer->right) {
                        $rightIds[$answer->id] = $question->id;
                    }
                }
                $multi = 0;
                foreach ($rightIds as $key => $value) {
                    foreach ($answers as $answer) {
                        if ($answer->question_id === $value) {
                            if ($answer->id === $key) {
                                $multi += 1;
                            }
                        }
                    }
                }
                if ($multi === count($rightIds)) {
                    $score += 1;
                }
            } elseif ('textArea' === $question->type()->first()->code) { //костыль
                foreach ($answersSelected as $answer) {
                    if($answer['questionId'] == $question->id) {
                        foreach ($question->answers()->get() as $item) {
                            if($item->text == $answer['value']) {
                                $score += 1;
                            }
                        }
                    }
                }
            }
        }
        $rightPercent = ($score / $count) * 100;

        return match (true) {
            $rightPercent < 50 => 2,  // Недовлетворительно
            $rightPercent >= 50 && $rightPercent < 60 => 3,  // Удовлетворительно
            $rightPercent >= 60 && $rightPercent < 85 => 4,  // Хорошо
            $rightPercent >= 85 => 5,  // Отлично
        };
    }


    public function logging(Request $request): mixed
    {
        try {
            $validator = $this->getDataByRequestLogging($request);
        } catch (ValidationException $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
        $user = User::where('login', $validator['login'])
            ->where('active', true)
            ->firstOrFail();
        if (!Hash::check($validator['password'], $user->password)) {
            abort(401, 'Неверный пароль');
        }
        $token = Crypt::encryptString(json_encode($user->jsonSerialize()));
        Token::create(['token' => $token]);
        $user->update(['remember_token' => $token]);
        return $user->jsonSerialize(true);
    }

    /**
     * @throws ValidationException
     */
    private function getDataByRequestLogging(Request $request): array
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


    /**
     * @throws ValidationException
     */
    private function getDataByRequestRegister(Request $request): array
    {
        $data = $request->all();
        $data['first_name'] = $data['firstName'];
        $data['last_name'] = $data['lastName'];
        $data['middle_name'] = $data['middleName'];
        if (empty($data['active'])) {
            $data['active'] = false;
        }
        return validator(
            $data,
            [
                'login' => 'required|string',
                'password' => 'required|string',
                'rights' => 'required|array',
                'group' => 'required|array',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|string|email',
                'middle_name' => 'required|string',
                'active' => 'required|boolean',
            ]
        )->validate();
    }


    /**
     * @throws ValidationException
     */
    private function getDataByRequestInvite(Request $request): array
    {
        $data = $request->all();
        $data['user_id'] = Auth::getUser()->id;
        $data['date_end'] = Carbon::create($data['dateEnd']);
        $data['info'] = json_encode($data['info']);
        $data['code'] = hash('sha256', 'User' . Auth::getUser()->id . Carbon::now()->toDateTimeString());
        return validator(
            $data,
            [
                'info' => 'required|string',
                'date_end' => 'required',
                'user_id' => 'required|integer',
                'code' => 'required|string',
            ]
        )->validate();
    }

    /**
     * @throws ValidationException
     */
    private function getDataUserTestByRequest(Request $request): array
    {
        $data = $request->all();
        $data['user_id'] = Auth::getUser()->id;
        if (!empty($data['answers'])) {
            /*            foreach ($data['answers'] as &$answer) {
                            $answer = $this->getDataAnswersTestByArray($answer);
                        }*/
        }
        if (!empty($data['type'])) {
            $data['type_id'] = $data['type']['id'];
        } else {
            $data['type_id'] = UserAnswersType::where('code', 'process')->first()->id;
        }
        if (!empty($data['test'])) {
            $data['test_id'] = $data['test']['id'];
        }
        return validator(
            $data,
            [
                'type_id' => 'required|integer',
                'user_id' => 'required|integer',
                'test_id' => 'required|integer',
                'trail' => 'nullable|integer',
                'score' => 'nullable',
                'answers' => 'required|array',
            ]
        )->validate();
    }

    /**
     * @throws ValidationException
     */
    private function getDataAnswersTestByArray(array $data): array
    {
        return validator(
            $data,
            [
                'user_test_id' => 'required|integer',
                'answers_id' => 'required|integer',
            ]
        )->validate();
    }
}
