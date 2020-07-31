<?php


namespace Axterisko\ProfileJsonResponse\Middleware;


use Axterisko\ProfileJsonResponse\ProfilingData;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProfileJsonResponse
{

    /**
     * limit the profiling data
     *
     * available keys:
     *   __meta
     *  php
     *  messages
     *  time
     *  memory
     *  exceptions
     *  views
     *  route
     *  queries
     *  swiftmailer_mails
     *  auth
     *  gate
     *  session
     *  request
     *
     * leave empty for show all data
     * @var array
     */
    protected $profilingData = [];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     *
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!app()->bound('debugbar') || !app('debugbar')->isEnabled()) {
            return $response;
        }

        if ($response instanceof JsonResponse) {
            $data = $response->getData();
            if (is_array($data)) {
                $response->setData(array_merge($data, [
                    '_debugbar' => $this->getProfilingData()
                ]));
            } else {
                $data->_debugbar = $this->getProfilingData();
                $response->setData($data);
            }
        }

        return $response;
    }

    /**
     * Get profiling data
     *
     * @return array
     */
    protected function getProfilingData()
    {
        $this->profilingData = config('app.profile-json-response-data', []);
        $data = app('debugbar')->getData();

        if (empty($this->profilingData))
            return $data;

        if (is_array($this->profilingData))
            return Arr::only($data, $this->profilingData);
        else if (is_a($this->profilingData, ProfilingData::class, true)) {
            return (new $this->profilingData($data))->getData();
        }

        return $data;
    }
}
