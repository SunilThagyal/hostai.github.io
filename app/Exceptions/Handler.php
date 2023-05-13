<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            abort_if ($e instanceof MethodNotAllowedHttpException, 404);
            if ($e->getPrevious() instanceof TokenMismatchException) {
                return redirect()->route('login');
            };
        });
    }

    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
        $message = null;
        if ($exception instanceof MethodNotAllowedHttpException) {
            $message = "Requested method is not allowed";
        }
        if($exception instanceof ModelNotFoundException) {
            $message = "Record does not exist";
        }

        if($exception instanceof NotFoundHttpException) {
            $message = "Record does not exist";
        }
        if ($exception instanceof TokenMismatchException) {
            $message = "CSRF token mismatch";
        }

        if (!is_null($message)) {
            // get the previous  url
            $url = url()->previous();
            $currentUrl = url()->full();
            if ($url == $currentUrl) {
                $url = $this->getRedirectedPath();
            }

            $response = ['status' => 'danger', 'message' => $message];

            return redirect($url)->with($response);
            // return response()->view('errors.4xx', ['exception' => $exception], 404);
        }

        return parent::render($request, $exception);
    }

    public function getRedirectedPath()
    {
        $authUser = auth()->user();
        $url = route('login');
        if (!is_null($authUser)) {
            if ($authUser->role == 'admin') {
                $url = route('admin.dashboard');
            } elseif($authUser->role == 'project-manager'){
                $url = route('project-manager.dashboard');
            } elseif($authUser->role == 'subcontractor'){
                $url = route('subcontractor.dashboard');
            } elseif($authUser->role == 'manager'){
                $url = route('manager.dashboard');
            } else {
                Auth::logout();
                session()->flash('message', 'Invalid Credentials!');
                session()->flash('alert-class', 'alert-danger');

                $url = route('login');
            }
        }

        return $url;
    }

}
