<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Throwable;

class ClientErrorController extends Controller
{
    public function __invoke(Request $request)
    {
        // Messages/categories are enumerated. Never accept arbitrary browser exception text.
        $safe = $request->validate([
            'app' => ['required', Rule::in(['public', 'portal'])],
            'app_version' => ['required', 'string', 'max:128', 'regex:/^[a-zA-Z0-9._-]+$/'],
            'event_id' => ['required', 'uuid'],
            'category' => ['required', Rule::in(['network', 'server', 'invalid_response', 'component', 'route', 'unhandled'])],
            'message' => ['required', Rule::in(['Request failed', 'Unexpected interface error'])],
            'route_template' => ['required', 'string', 'max:128', 'regex:#^/[a-zA-Z0-9_/:{}-]*$#'],
            'status' => ['nullable', 'integer', 'between:400,599'],
            'request_id' => ['nullable', 'uuid'],
        ]);
        // Extra submitted fields are not logged. No model, auth, or session lookup is needed.
        try {
            Log::channel('diagnostics')->warning('client_error', $safe);
        } catch (Throwable) {
            return response()->json(['message' => 'Diagnostics are temporarily unavailable.',
                'code' => 'service_unavailable', 'request_id' => $request->attributes->get('request_id')], 503);
        }
        return response()->json(['accepted' => true], 202);
    }
}
