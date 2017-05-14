@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div id="alerts"></div>
                @if (Auth::user()->role == 1)
                <div class="panel panel-default">
                    <div class="panel-heading">Invite new user</div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input class="form-control" name="email" id="inviteEmail" type="text">
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                            </div>
                            <div class="form-group">
                                <input id="sendInvite" class="btn btn-primary form-control" value="Send" type="submit">
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>
                    <div class="panel-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div id="createEventModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Event</h4>
                </div>
                <div class="modal-body">
                    <div class="control-group">
                        <label class="control-label" for="inputPatient">Event:</label>
                        <div class="field desc">
                            <input class="form-control" id="title" name="title" placeholder="Event" type="text" value="">
                            <textarea class="form-control" id="description" placeholder="Description"></textarea>
                            <input class="form-control color" name="color-picker">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                        </div>
                    </div>

                    <input type="hidden" id="startTime"/>
                    <input type="hidden" id="endTime"/>



                    <div class="control-group">
                        <label class="control-label" for="when">When:</label>
                        <div class="controls controls-row" id="when" style="margin-top:5px;">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitButton">Save</button>
                </div>
            </div>

        </div>
    </div>


    <div id="calendarModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Event Details</h4>
                </div>
                <div id="modalBody" class="modal-body">
                    <input class="form-control" id="calendarModalTitle" class="modal-title">

                    <textarea class="form-control" id="calendarModalDescription" placeholder="Description"></textarea>
                    <div class="radio">
                        <label><input type="radio" value="new" name="optradio">new</label>
                    </div>
                    <div class="radio">
                        <label><input type="radio" value="in-progress" name="optradio">in-progress</label>
                    </div>
                    <div class="radio disabled">
                        <label><input type="radio" value="done" name="optradio">done</label>
                    </div>
                    <input class="form-control colorModal" name="color-picker">
                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                    <div id="modalWhen" style="margin-top:5px;"></div>
                </div>
                <input type="hidden" id="eventID"/>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button class="btn btn-danger" id="deleteButton">Delete</button>
                    <button class="btn btn-primary" id="editButton">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!--Modal-->
@endsection
