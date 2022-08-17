<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;


class ContactUsController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'email' => ['required,email'],
            'subject' => ['required'],
            'message' => ['required']
        ]);

        \Mail::send('contact_us',
            array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'subject' => $request->get('subject'),
                'user_message' => $request->get('message'),
            ), function ($message) use ($request) {
                $message->from($request->email);
                $message->to('amarghandour89@gmail.com');
            });

        return $this->response(200, true, null, null, 'Email successfully sent');
    }
}
