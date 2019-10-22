<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
	public function getEvents() 
	{
		try {
			$events = Event::all()->toArray();
			return response()->json(['result' => true, 'events' => $events], 200);
		} catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
	}

	public function postEvent(Request $request) 
	{
		try {
			$events = [];
			$period = CarbonPeriod::create($request->input('start_date'), $request->input('end_date'));

			foreach ($period as $date) {
				$d = new Carbon($date->format('Y-m-d'));
				$day_name = $d->format('l');

				if($request->has('days')) {
					if (in_array($day_name, $request->input('days'))) {
						$event = new Event();
						$event->name = $request->input('name');
						$event->color = $request->input('color');
						$event->start_date = $date->format('Y-m-d');
						$event->end_date = $date->format('Y-m-d');
						$event->save();
						array_push($events, $event);
					}
				} else {
					$event = new Event();
					$event->name = $request->input('name');
					$event->color = $request->input('color');
					$event->start_date = $date->format('Y-m-d');
					$event->end_date = $date->format('Y-m-d');
					$event->save();
					array_push($events, $event);
				}
			}

			return response()->json(['result' => true, 'events' => $events], 200);
		} catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
	}

	public function deleteEvents() 
	{
		try {
			$events = Event::truncate();
			return response()->json(['result' => true], 200);
		} catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
	}
}