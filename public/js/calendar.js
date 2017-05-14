$(document).ready(function(){
    var picker = new CP(document.querySelector('.color'));
    picker.on("change", function(color) {
        this.target.value = '#' + color;
    });

    var picker = new CP(document.querySelector('.colorModal'));
    picker.on("change", function(color) {
        this.target.value = '#' + color;
    });

    $('#sendInvite').on('click', function(e){
        e.preventDefault();
        sendInvite();
    });

    var calendar = $('#calendar').fullCalendar({
        header:{
            left: 'prev,next today',
            center: 'title',
            right: 'agendaWeek,agendaDay'
        },
        defaultView: 'agendaWeek',
        editable: true,
        selectable: true,
        allDaySlot: false,

        events: '/events',

        eventRender: function(event, element) {
            element.find('.fc-title').append("<br/>" + event.description);
        },

        eventClick:  function(event, jsEvent, view) {
            endtime = $.fullCalendar.moment(event.end).format('h:mm');
            starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');
            var mywhen = starttime + ' - ' + endtime;
            $('#modalDescription').val(event.description);
            $('#modalTitle').val(event.title);
            $('input[name="optradio"]').val([event.status]);
            $('#calendarModalTitle').val(event.title);
            $('#calendarModalDescription').val(event.description);
            $('#modalWhen').text(mywhen);
            $('#eventID').val(event.id);
            $('#calendarModal').modal();
        },

        select: function(start, end, jsEvent) {
            endtime = $.fullCalendar.moment(end).format('h:mm');
            starttime = $.fullCalendar.moment(start).format('dddd, MMMM Do YYYY, h:mm');
            var mywhen = starttime + ' - ' + endtime;
            start = moment(start).format();
            end = moment(end).format();
            $('#createEventModal #startTime').val(start);
            $('#createEventModal #endTime').val(end);
            $('#createEventModal #when').text(mywhen);
            $('#createEventModal').modal('toggle');
        },
        eventDrop: function(event, delta){
            $.ajax({
                url: '/events/resize',
                data: 'start='+moment(event.start).format()+'&end='+moment(event.end).format()+'&id='+event.id ,
                type: "GET",
                success: function(json) {
                    $("#calendar").fullCalendar('refetchEvents');
                }
            });
        },
        eventResize: function(event) {
            $.ajax({
                url: '/events/resize',
                data: 'start='+moment(event.start).format()+'&end='+moment(event.end).format()+'&id='+event.id,
                type: "GET",
                success: function(json) {
                    $("#calendar").fullCalendar('refetchEvents');
                }
            });
        }
    });

    $('#submitButton').on('click', function(e){
        e.preventDefault();
        doSubmit();
    });

    $('#editButton').on('click', function(e){
        e.preventDefault();
        doEdit();
    });

    $('#deleteButton').on('click', function(e){
        e.preventDefault();
        doDelete();
    });

    function doDelete(){
        $("#calendarModal").modal('hide');
        var eventID = $('#eventID').val();
        $.ajax({
            url: '/events/delete',
            data: 'id='+eventID,
            type: "GET",
            success: function(json) {
                if(json.status === true){
                    $("#calendar").fullCalendar('removeEvents',eventID);
                    bs3Alerts("#alerts", 'delete', json.status, "warning", "1", "3000");
                }
                else
                    return false;
            }
        });
    }
    function doSubmit(){
        $("#createEventModal").modal('hide');
        var title = $('#title').val();
        var description = $('#description').val();
        var startTime = $('#startTime').val();
        var endTime = $('#endTime').val();
        var color = $('#createEventModal .color').val();

        $.ajax({
            url: '/events/create',
            data: {title: title, start: startTime, end:endTime, color: color, description: description},
            type: "GET",
            success: function(json) {
                bs3Alerts("#alerts", 'create', json.status, "warning", "1", "3000");
                $("#calendar").fullCalendar('refetchEvents');
            }
        });
    }

    function doEdit(){
        $("#calendarModal").modal('hide');
        var eventID = $('#eventID').val();
        var title = $('#calendarModalTitle').val();
        var color = encodeURIComponent($('.colorModal').val());
        var description = $('#calendarModalDescription').val();
        var status = $("input[name=optradio]:checked").val();

        $.ajax({
            url: '/events/edit',
            data: 'title='+title+'&id='+eventID+'&color='+color+'&description='+description+'&status='+status,
            type: "GET",
            success: function(json, event) {
                bs3Alerts("#alerts", 'edit', json.status, "warning", "1", "3000");
                $("#calendar").fullCalendar('refetchEvents');
            }
        });
    }

    function sendInvite(){
        var inviteEmail = $('#inviteEmail').val();
        var token = $('#token').val();

        $.ajax({
            url: '/invite',
            data: {email:inviteEmail, _token: token},
            type: "POST",
            success: function(json, event) {
                bs3Alerts("#alerts", 'send invite', json.status, "warning", "1", "3000");
            }
        });
    }

    function bs3Alerts(idtag, title, message, type, showx, timeout) {

        var classSearch = $(idtag).hasClass("hide");

        $(idtag).empty();

        $(idtag).addClass("alert alert-"+type+" alert-dismissable");

        if(showx == 1) {
            $(idtag).append( "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>" );
        }

        if(title != "") {
            $(idtag).append("<strong>"+title+"</strong>&nbsp;&nbsp;");
        }

        if(message != "") {
            $(idtag).append(message);
        }


        if(classSearch == true) {
            $(idtag).removeClass("hide");
            $(idtag).addClass("show");
        }

        if(classSearch == false) {
            $(idtag).removeAttr('style');
            $(idtag).addClass("show");
        }

        if(timeout != "") {
            $(idtag).delay(timeout).fadeOut('slow').removeClass("show");


        }

    }

});