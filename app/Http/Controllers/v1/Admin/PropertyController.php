<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function addEvent(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'primary_img' => 'required|file|mimes:jpeg,png,jpg|max:2048',
                'name' => 'required|string',
                'address_line1' => 'required|string',
                'address_line2' => 'nullable|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'gmap_location' => 'required',
                'AC' => 'required|boolean',
                'BHK' => 'required|integer',
                'BHK_desc' => 'nullable',
                'bathrooms' => 'nullable|integer',
                'bathrooms_desc' => 'nullable',
                'swimingpool' => 'required|boolean',
                'swimingpool_desc' => 'nullable',
                'parking' => 'required|boolean',
                'furnished' => 'required|boolean',
                'wifi' => 'required|boolean',
                'kitchen' => 'required|boolean',
                'hot_water' => 'required|boolean',
                'caretaker' => 'required|boolean',
                'capacity' => 'required|integer',
                'check_in' => 'required|date_format:H:i',
                'check_out' => 'required|date_format:H:i',
                'other_details' => 'nullable|array',
                'contact1' => 'required|string',
                'contact1' => 'nullable|string',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }
            DB::beginTransaction();
            $photo = null;
            if ($request->hasFile('primary_photo')) {
                $photo = $this->saveFile($request->file('primary_photo'), 'EventImages');
            }
            $event = new Event();
            $event->org_id = app('org_id');
            $event->primary_photo = $photo;
            $event->name = $request->name;
            $event->location = $request->location;
            $event->start_date = $request->start_date;
            $event->start_time = $request->start_time;
            $event->end_date = $request->end_date;
            $event->end_time = $request->end_time;
            $event->has_limit = $request->has_limit;
            $event->limit = $request->limit;
            $event->description = $request->description;
            $event->organizer_name = $request->organizer_name;
            $event->organizer_email = $request->organizer_email;
            $event->organizer_mobile = $request->organizer_mobile;
            $event->is_paid = $request->is_paid;
            $event->capture_attendance = $request->capture_attendance;
            $event->has_customized_schedule = $request->has_customized_schedule;
            $event->status = "draft";
            $event->is_published = false;
            $event->save();
            DB::commit();
            return $this->sendResponse($event['id'], 'Event added successfully.', true);
        } catch (Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage(), $e->getTrace(), 413);
        }
    }
}
