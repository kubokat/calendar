<?php

namespace App\Http\Controllers;

use App\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class MeetingCalendar extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Calendar::get(['id','title', 'description', 'start', 'end', 'color','status']);
        return Response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $request->request->add(['user_id' => Auth::id()]);
            $request->request->add(['status' => 1]);
            $event = new Calendar($request->all());
            $resp = array(
                'status' => $event->save(),
                'id' => $event->id
            );

            return Response()->json($resp);
        } catch (\Exception $e) {
            $resp = array(
                'status' => false,
                'error'  => $e->getMessage()
            );
            return Response()->json($resp);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resize(Request $request)
    {
        try {
            $event = Calendar::find($request->id);

            if (Auth::user()->role == 1 || $event->user_id == Auth::id()) {
                $event->start = $request->start;
                $event->end = $request->end;
                $resp = array(
                    'status' => $event->save(),
                    'id' => $event->id
                );
            } else {
                $resp = array(
                    'status' => 'Access denied',
                );
            }


            return Response()->json($resp);
        } catch (\Exception $e) {
            $resp = array(
                'status' => false,
                'error'  => $e->getMessage()
            );
            return Response()->json($resp);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {

            $event = Calendar::find($request->id);

            if (Auth::user()->role == 1 || $event->user_id == Auth::id()) {
                $event = Calendar::find($request->id);
                $event->title = $request->title;
                $event->description = $request->description;
                $event->color = $request->color;
                $event->status = $request->status;
                $resp = array(
                    'status' => $event->save(),
                    'id' => $event->id,
                );
            } else {
                $resp = array(
                    'status' => 'Access denied',
                );
            }

            return Response()->json($resp);
        } catch (\Exception $e) {
            $resp = array(
                'status' => false,
                'error'  => $e->getMessage()
            );
            return Response()->json($resp);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        try {

            $event = Calendar::find($request->id);

            if (Auth::user()->role == 1 || $event->user_id == Auth::id()) {
                $resp = array(
                    'status' => $event->delete()
                );
            } else {
                $resp = array(
                    'status' => 'Access denied'
                );
            }


            return Response()->json($resp);
        } catch (\Exception $e) {
            $resp = array(
                'status' => false,
                'error'  => $e->getMessage()
            );
            return Response()->json($resp);
        }
    }
}
