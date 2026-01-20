<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\TagController;
use App\Jobs\ProcessSendEmailWhenResourceCreated;
use App\Jobs\SendEmailWhenResourceUpdated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    private array $maps = [
        'tags'       => TagController::class,
        'types'      => TypeController::class,
        'users'      => UserController::class,
        'categories' => CategoriesController::class,
    ];

    private array $requestsCreate = [
        'tags'        => [
            'tag' => 'required|unique:tags,tag|max:100'
        ],
        'types'       => [
            'title'       => 'required|max:150|unique:types,title',
        ],
        'users'       => [
            'name'     => 'required|max:200',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required',

        ],
        'categories'  => [
            'title'       => 'required|max:150|unique:categories,title',
            'description' => 'required|max:250',
        ],
    ];

    private array $requestsUpdate = [
        'tags'        => [
            'tag' => 'required|unique:tags,tag|max:100'
        ],
        'types'       => [
            'title'       => 'required|max:150|unique:types,title',
        ],
        'users'       => [
            'name'     => 'required|max:200',
        ],
        'categories'  => [
            'title'       => 'required|max:150|unique:categories,title',
            'description' => 'required|max:250',
        ],
    ];

    public function index() {
        return view('admin.index');
    }

    public function callControllerMethod(mixed $controller, string $method, ?string $id = null) {
        if (!isset($this->maps[$controller])) {
            abort(404);
        }

        $instance = App::make($this->maps[$controller]);

        if (!method_exists($instance, $method)) {
            abort(404);
        }

        return App::call([$instance, $method], [
            'id' => $id
        ]);
    }

    public function callControllerMethodForPost(Request $request, mixed $controller, string $method, ?string $id = null) {
        if (!isset($this->requestsCreate[$controller], $this->maps[$controller])) {
            abort(404);
        }

        $controllerInstance = App::make($this->maps[$controller]);

        if (!method_exists($controllerInstance, $method)) {
            abort(404);
        }

        $validationRules = $this->requestsCreate[$controller];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.callControllerMethod', ['controller' => $controller, 'method' => 'create'])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Start collecting validated fileds in a form of associate array,
        // where keys are the columns of coresponding model
        // and pass it to controller store() method.
        $data = [];

        foreach ($validationRules as $field => $rule) {
            $data[$field] = $validated[$field];
        }

        $authUser = Auth::user();

        // Send notification email to logged ADMIN when new resource is created, using queue jobs.
        ProcessSendEmailWhenResourceCreated::dispatch($authUser->email, ucfirst($controller), $data);

        return App::call([$controllerInstance, $method], [
            'data' => $data
        ]);
    }

    public function callControllerMethodForPatch(Request $request, mixed $controller, string $method, string $id) {
        if (!isset($this->requestsUpdate[$controller], $this->maps[$controller])) {
            abort(404);
        }

        $controllerInstance = App::make($this->maps[$controller]);

        if (!method_exists($controllerInstance, $method)) {
            abort(404);
        }

        $validationRules = $this->requestsUpdate[$controller];

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.callControllerMethod', ['controller' => $controller, 'method' => 'create'])
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // Start collecting validated fileds in a form of associate array,
        // where keys are the columns of coresponding model
        // and pass it to controller store() method.
        $data = [];

        foreach ($validationRules as $field => $rule) {
            $data[$field] = $validated[$field];
        }

        $authUser = Auth::user();

        SendEmailWhenResourceUpdated::dispatch($authUser->email, ucfirst($controller), $data, $id);

        return App::call([$controllerInstance, $method], [
            'data' => $data,
            'id'   => $id
        ]);
    }

}
