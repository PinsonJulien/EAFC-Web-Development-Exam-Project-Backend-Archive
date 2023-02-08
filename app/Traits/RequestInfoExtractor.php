<?php

namespace App\Traits;

use Illuminate\Http\Request;

/**
 * Trait to extract data from requests.
 */
trait RequestInfoExtractor
{
    /**
     * Returns the model name from a request.
     *
     * @param Request $request
     * @return string
     */
    protected function getRequestModel(Request $request): string {
        $action = $request->route()->getAction();
        $controller = class_basename($this->getRequestController($request));

        // Remove the @function
        $controller = strtok($controller, '@');

        // Extract the model name
        $model = str_replace("Controller", "", $controller);

        return  '\App\Models\\' . $model;
    }

    /**
     * Returns the controller name from a request.
     *
     * @param Request $request
     * @return string
     */
    protected function getRequestController(Request $request): string {
        $action = $request->route()->getAction();
        return $action['controller'];
    }
}
