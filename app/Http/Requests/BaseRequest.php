<?php

namespace App\Http\Requests;

use App\Services\ResponseService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

abstract class BaseRequest extends FormRequest
{
    protected $errorMsg = '';
    protected $formData;
    protected $preparingDataRules = [];

    /**
     * @return string Определяет какой объект будет наполняться
     */
    abstract public function getDTOClass(): string;

    /**
     * Возвращает наполненнный объект данными
     *
     * @return mixed
     */
    public function getDataForm()
    {
        return $this->fillData();
    }

    /**
     * Заполнение данными указанного объекта
     *
     * @return mixed
     */
    protected function fillData()
    {
        if (!empty($this->formData)) {
            return $this->formData;
        }
        $className = $this->getDTOClass();
        $this->formData = new $className();

        foreach ($this->formData as $key => $value) {
            $valueForAdd = $this->get($key);
            if (!isset($valueForAdd) && isset($value)) {
                $valueForAdd = $value;
            }
            $this->formData->$key = $valueForAdd;
        }

        if (!empty($this->formData->FILES)) {
            $this->fillFiles();
        }

        if (!empty($this->preparingDataRules)) {
            $this->prepareData();
        }

        return $this->formData;
    }

    protected function prepareData()
    {
        foreach ($this->preparingDataRules as $property => $method) {
            if (method_exists($this, $method)) {
                $this->formData->$property = $this->$method($this->formData->$property);
            }
        }
    }

    protected function fillFiles()
    {
        foreach ($this->formData->FILES as $fileProperty) {
            if (!$this->hasFile($fileProperty)) {
                continue;
            }
            $this->formData->$fileProperty = $this->file($fileProperty);
        }
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        /** @var ResponseService $responseService */
        $responseService = app()->get(ResponseService::class);

        throw new HttpResponseException(
            $responseService->sendResponseWithErrors(
                $this->prepareErrors((new ValidationException($validator))->errors()),
                $this->errorMsg
            )
        );
    }

    /**
     * @param $errors
     * @return mixed
     */
    protected function prepareErrors($errors)
    {
        if (empty($errors)) {
            return $errors;
        }

        foreach ($errors as $fieldName => $errorList) {
            $errors[$fieldName] = implode(' ', $errorList);
        }

        return $errors;
    }
}
