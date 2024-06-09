<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public static function sendResponse($result = [], $message = [], $additionalData = [])
    {
        if(!empty($message)){
            $result['message'] = $message;
            $response = [
                'success' => true,
                'data'    => $result,
            ];
        }
        elseif(empty($result)){
            $response = [
                'success' => true,
                'data'    => (object)$result,
            ];
        } 
        else {
            $response = [
                'success' => true,
                'data'    => $result,
            ];
        }
        
        if (!empty($additionalData) && is_array($additionalData) && count($additionalData) > 0) {
            $response['additional_data'] = $additionalData;
        }

        return response()->json($response, 200);
    }


    /**
     * return error response.
     * default erro response - code 300
     * @return \Illuminate\Http\Response
     */
    public static function sendError($errorMessages = "", $code = 300)
    {
    	$response = [
            'success' => false,
            'error'=> [
                'code' => (string)$code,
                'message' => static::getErrorMessage($code),
            ]
        ];

        if(!empty($errorMessages)){
            $response['error']['message'] = $errorMessages;
        }

        return response()->json($response, 200);
    }

    public static function getErrorMessage($code){
        switch ($code) {
            case 300:
                return 'Переданы неверные данные';
                break;

            case 301:
            case 104:    
                return 'Необходима повторная авторизация';
                break;
            
            case 302:
                return 'Произошла ошибка при записи';
                break;
            
            case 303:
                return 'Не заполнены обязательные поля';
                break;
                
            case 304:
                return 'Заявки отсутствуют';
                break;

            case 305:
                return 'Неправильно указан callback, должен начинаться с http или https';
                break;
            case 306:
                return 'Некорректный участник обмена';
                break;
            case 307:
                return 'Отсутствуют файлы в архиве';
                break;
            case 308:
                return 'Отсутствуют платные работы';
                break;
			case 309:
                return 'Функционал не активен';
                break;           
            default:
                return 'Переданы неверные данные';
                break;
        }
    }
}
