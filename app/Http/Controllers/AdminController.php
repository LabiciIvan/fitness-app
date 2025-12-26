<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\TagController;

class AdminController extends Controller
{
    private array $maps = [
        'tags'       => TagController::class,
        'types'      => TypeController::class,
        'users'      => UserController::class,
        'categories' => CategoriesController::class,
    ];

    public function index() {
        return view('admin.index');
    }

    public function callControllerAction(mixed $controller, string $action) {
        if (!isset($this->maps[$controller])) {
            abort(404);
        }

        $instance = App::make($this->maps[$controller]);

        if (!method_exists($instance, $action)) {
            abort(404);
        }

        return App::call([$instance, $action]);
    }

}
