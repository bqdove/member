<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-08 14:47
 */

namespace Notadd\Member\Abstracts;

use Closure;
use Notadd\Foundation\Routing\Abstracts\Controller;

class AbstractApiController extends Controller
{
    /**
     * @var int $statusCode
     */
    protected $statusCode = 200;

    /**
     * @var string $message
     */
    protected $message = 'ok';

    /**
     * @var array $errors
     */
    protected $errors = [];

    /**
     * @var array $pagination
     */
    protected $pagination = [];

    /**
     * Get the status code.
     *
     * @return int $statusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the status code.
     *
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get the message.
     *
     * @return int $statusCode
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the message.
     *
     * @param $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * set errors
     *
     * @param array $errors
     *
     * @return $this
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * get errors
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * set pagination
     *
     * @param array $pagination
     *
     * @return $this
     */
    public function setPagination(array $pagination)
    {
        $this->pagination = $pagination;

        return $this;
    }

    /**
     * get pagination
     *
     * @return array
     */
    public function getPagination()
    {
        return $this->pagination;
    }

    public function noContent()
    {
        return $this->setMessage('No Content')
            ->setStatusCode(204)
            ->respondWithArray([]);
    }

    /**
     * Respond the item data. 可以理解为单个数据, 如单个用户的数据
     *
     * @param $item
     * @param $callback
     *
     * @return mixed
     */
    public function respondWithItem($item, $callback)
    {
        $resource = new Item($item, $callback);

        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray(array_get($rootScope->toArray(), 'data', []));
    }

    /**
     * Respond the collection data. 多个数据不分页的
     *
     * @param $collection
     * @param $callback
     * @return mixed
     */
    public function respondWithCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);

        $rootScope = $this->fractal->createData($resource);

        return $this->respondWithArray(array_get($rootScope->toArray(), 'data', []));
    }

    /**
     *  Respond the collection data with pagination.
     *
     * @param $paginator
     * @param $callback
     *
     * @return mixed
     */
    public function respondWithPaginator($paginator, Closure $callback)
    {
        $data = [];
        foreach ($paginator as $item) {
            $data[] = $callback($item);
       }

        return $this->setPagination(array_except($paginator->toArray(), 'data', []))
            ->respondWithArray($data);
    }

    /**
     * Respond the data.
     *
     * @param array $array
     * @param array $headers
     *
     * @return mixed
     */
    public function respondWithArray(array $array, array $headers = [])
    {
        $results = [
            'code'       => $this->statusCode,
            'message'    => $this->message,
            'errors'     => $this->errors,
            'pagination' => $this->pagination,
            'data'       => $array,
        ];

        // foreach ($results as $key => $result) {
        //     if (empty($result)) {
        //         unset($results[$key]);
        //     }
        // }

        return response()->json($results, $this->statusCode, $headers);
    }

    /**
     * Respond the error of 'Forbidden'
     *
     * @param  string $message
     *
     * @return json
     */
    public function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(403)
            ->setMessage($message)
            ->respondWithError();
    }

    /**
     * Respond the error of 'Internal Error'.
     *
     * @param  string $message
     *
     * @return json
     */
    public function errorInternal($message = 'Internal Error')
    {
        return $this->setStatusCode(500)
            ->setMessage($message)
            ->respondWithError();
    }

    /**
     * Respond the error of 'Resource Not Found'
     *
     * @param  string $message
     *
     * @return json
     */
    public function errorNotFound($message = 'Resource Not Found')
    {
        return $this->setStatusCode(404)
            ->setMessage($message)
            ->respondWithError();
    }

    /**
     * Respond the error of 'Unauthorized'.
     *
     * @param  string $message
     *
     * @return json
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)
            ->setMessage($message)
            ->respondWithError();
    }

    /**
     * Respond the error of 'Wrong Arguments'.
     *
     * @param  string $message
     *
     * @return json
     */
    public function errorWrongArgs($message = 'Wrong Arguments')
    {
        return $this->setStatusCode(400)
            ->setMessage($message)
            ->respondWithError();
    }

    public function errorValidate(array $errors)
    {
        return $this->setStatusCode(422)
            ->setMessage('Error')
            ->setErrors($errors)
            ->respondWithArray([]);
    }

    /**
     * Respond the error message.
     *
     * @param  string $message
     * @param  string $errorCode
     *
     * @return json
     */
    protected function respondWithError($statusCode = null, $message = null)
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "You better have a really good reason for erroring on a 200...",
                E_USER_WARNING
            );
        }

        if ($message) {
            $this->setMessage($message);
        }

        if ($statusCode) {
            $this->setStatusCode($statusCode);
        }

        if ($message) {
            $this->setErrors([$message]);
        } else {
            $this->setErrors([$this->getMessage()]);
        }

        return $this->respondWithArray([]);
    }

    protected function getAuth($guard = null)
    {
        return $this->getContainer()->make('auth')->guard($guard);
    }
}
