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
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);


        // todo sent email to admin.


        return $this->response(200, true, null, null, 'Email successfully sent');
    }
}
