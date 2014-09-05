
$(document).ready(function() {


    //Query Parameter for filter box
    var floc = $('#filter-location option:selected').val();
    var fuser = $('#filter-user option:selected').val();
    var fdate = $('#filter-date option:selected').val();
    var sdate = '';
    var edate = '';

    if (fdate === 'cust') {
        sdate = $('#sdate').val();
        edate = $('#edate').val();
    }

    var param = buildQueryParam(floc, fuser, fdate, sdate, edate);

    $('#external-events div.external-event').each(function() {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true, // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });

    });


    /* initialize the calendar
     -----------------------------------------------------------------*/

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
    var calendarUrl = config.URL + 'calendars/schedulecalendar?' + param;

    var calendar = $('#calendar').fullCalendar({
        buttonText: {
            prev: '<i class="icon-chevron-left"></i>',
            next: '<i class="icon-chevron-right"></i>'
        },
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        contentHeight: 600,
        events: calendarUrl,
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        drop: function(date, allDay) { // this function is called when something is dropped

//            alert('Event Droped');
//            // retrieve the dropped element's stored Event Object
//            var originalEventObject = $(this).data('eventObject');
//            var $extraEventClass = $(this).attr('data-class');
//
//
//            // we need to copy it, so that multiple events don't have a reference to the same object
//            var copiedEventObject = $.extend({}, originalEventObject);
//
//            // assign it the date that was reported
//            copiedEventObject.start = date;
//            copiedEventObject.allDay = allDay;
//            if ($extraEventClass)
//                copiedEventObject['className'] = [$extraEventClass];
//
//            // render the event on the calendar
//            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
//            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
//
//            // is the "remove after drop" checkbox checked?
//            if ($('#drop-remove').is(':checked')) {
//                // if so, remove the element from the "Draggable Events" list
//                $(this).remove();
//            }

        }
        ,
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {

            var mm = ''; var dd = '';
            var yyyy = start.getFullYear();
            var m = start.getMonth() + 1;
            if(m < 10) {
                mm = '0' + m.toString();
            } else {
                mm = m.toString();
            }
            var d = start.getDate();
            if(d < 10) {
                dd = '0' + d.toString();
            } else {
                dd = d.toString();
            }
            var selectedDate = yyyy + '-' + mm + '-' + dd;
//            alert("Selected Date: " + selectedDate);
            $('.calendardetailtitle').html('Outlets visited on <span class="text-info">' + selectedDate + '</span>');
            url = config.URL + 'calendars/planneddetails/' + selectedDate;
                $.ajax({
                    url: url,
                    data: param,
                    dataType: 'JSON',
                    success: function(data) {

                        var outlets = '';
                        var vcount = 0;
                        var scount = data.length;
                        ;
                        var ucount = 0;
                        for (var i = 0; i < data.length; i++) {
                            if (data[i].visited) {
                                outlets += ('<p class="outlets visited"><a href="'
                                        + config.URL + 'outlets/view/' + data[i].outletid + '">' + data[i].outletname + '</a></p>');
                                vcount++;
                            } else {
                                outlets += ('<p class="outlets unvisited"><a href="'
                                        + config.URL + 'outlets/view/' + data[i].outletid + '">' + data[i].outletname + '</a></p>');
                                ucount++;
                            }
                        }
                        
                        $('#cal-outlets').html('');
                        var heading = '';
                        heading += '<table class="table table-bordered center">';
                        heading += '<tr><th>Planned Visit</th><th>Total Visited</th><th>Total Unvisited</th></tr>';
                        heading += '<tr>';
                        heading += '<td class="center"><button class="btn btn-warning btn-minier"> ' + (vcount+ucount) + ' </button></td>';
                        heading += '<td class="center"><button class="btn btn-success btn-minier"> ' + vcount + ' </button></td>';
                        heading += '<td class="center"><button class="btn btn-danger btn-minier"> ' + ucount + ' </button></td>';
                        heading += '</tr>';
                        heading += '</table>';
                        outlets = heading + outlets;
                        $('#cal-outlets').html(outlets);
                    }
                });
            
                $('#calendarclick').modal();
//             $('#calendar-details').html('');
//            var form = $("<form class='form-inline'><label>Change event name &nbsp;</label></form>");
//            form.append("<input autocomplete=off type=text value='" + calEvent.title + "' /> ");
//            form.append("<button type='submit' class='btn btn-small btn-success'><i class='icon-ok'></i> Save</button>");
//
//            var div = bootbox.dialog(form,
//                    [
//                        {
//                            "label": "<i class='icon-trash'></i> Delete Event",
//                            "class": "btn-small btn-danger",
//                            "callback": function() {
//                                calendar.fullCalendar('removeEvents', function(ev) {
//                                    return (ev._id == calEvent._id);
//                                })
//                            }
//                        }
//                        ,
//                        {
//                            "label": "<i class='icon-remove'></i> Close",
//                            "class": "btn-small"
//                        }
//                    ]
//                    ,
//                    {
//                        // prompts need a few extra options
//                        "onEscape": function() {
//                            div.modal("hide");
//                        }
//                    }
//            );
//
//            form.on('submit', function() {
//                calEvent.title = form.find("input[type=text]").val();
//                calendar.fullCalendar('updateEvent', calEvent);
//                div.modal("hide");
//                return false;
//            });

//            bootbox.dialog({
//                message: "I am a custom dialog",
//                title: "New Schedule",
//                buttons: {
//                    success: {
//                        label: "Success!",
//                        className: "btn-success",
//                        callback: function() {
//                            Example.show("great success");
//                        }
//                    },
//                    danger: {
//                        label: "Danger!",
//                        className: "btn-danger",
//                        callback: function() {
//                            Example.show("uh oh, look out!");
//                        }
//                    },
//                    main: {
//                        label: "Click ME!",
//                        className: "btn-primary",
//                        callback: function() {
//                            Example.show("Primary button");
//                        }
//                    }
//                }
//            });

//            var form = $('<form class="form-horizontal"></form>');
//            form.append('<label>Schedule Date</label>');
//            form.append('<input type="text" class="">');
//            form.append('<label>Outlet</label>');
//            form.append('<input type="text" class="">');
//            
//            bootbox.dialog({
//                message: form,
//                title: "New Schedule Visit",
//                buttons: {
//                    danger: {
//                        label: 'Cancel',
//                        className: "btn-important btn-small",
//                        callback: function() {}
//                    },
//                    success: {
//                        label: 'Save',
//                        className: "btn-success btn-small",
//                        callback: function() {
//                            
//                        }
//                    }
//                }
//            });
//            
//            bootbox.prompt("New Event Title:", function(title) {
//                if (title !== null) {
//                    calendar.fullCalendar('renderEvent',
//                            {
//                                title: title,
//                                start: start,
//                                end: end,
//                                allDay: allDay
//                            },
//                    true // make the event "stick"
//                            );
//                }
//            });


//            calendar.fullCalendar('unselect');

        }
        ,
        eventClick: function(calEvent, jsEvent, view) {

            var mm = ''; var dd = '';
            var eventid = calEvent.id;
            var startdate = new Date(calEvent.start);
            var yyyy = startdate.getFullYear();
            var m = startdate.getMonth() + 1;
            if(m < 10) {
                mm = '0' + m.toString();
            } else {
                mm = m.toString();
            }
            var d = startdate.getDate();
            if(d < 10) {
                dd = '0' + d.toString();
            } else {
                dd = d.toString();
            }
            var strYear = yyyy + '-' + mm + '-' + dd;

            var url = '';
            if (eventid === 'p') {
                url = config.URL + 'calendars/planneddetails/' + strYear;
                $.ajax({
                    url: url,
                    data: param,
                    dataType: 'JSON',
                    success: function(data) {

                        var outlets = '';
                        var vcount = 0;
                        var scount = data.length;
                        ;
                        var ucount = 0;
                        for (var i = 0; i < data.length; i++) {
                            if (data[i].visited) {
                                outlets += ('<p class="outlets visited"><a href="'
                                        + config.URL + 'outlets/view/' + data[i].outletid + '">' + data[i].outletname + '</a></p>');
                                vcount++;
                            } else {
                                outlets += ('<p class="outlets unvisited"><a href="'
                                        + config.URL + 'outlets/view/' + data[i].outletid + '">' + data[i].outletname + '</a></p>');
                                ucount++;
                            }
                        }

                        $('#calendar-details').html('');
                        $('#calendar-details').append('<h4>Date</h4>');
                        $('#calendar-details').append('<p>' + strYear + '</p>');
                        $('#calendar-details').append('<h4>Total Planned Visit</h4>');
                        $('#calendar-details').append('<p>' + scount + '</p>');
                        $('#calendar-details').append('<h4>Total Actual Visit</h4>');
                        $('#calendar-details').append('<p>' + vcount + '</p>');
                        $('#calendar-details').append('<h4>Total Unvisited</h4>');
                        $('#calendar-details').append('<p>' + ucount + '</p>');
                        $('#calendar-details').append('<h4>List of outlets</h4>');
                        $('#calendar-details').append('<div id="outlets">');
                        $('#calendar-details').append('</div>');
                        $('#outlets').append(outlets);
                    }
                });
            } else if (eventid === 'a') {
                url = config.URL + 'calendars/actualdetails/' + strYear;
                $.ajax({
                    url: url,
                    data: param,
                    dataType: 'JSON',
                    success: function(data) {

                        var outlets = '';
                        for (var i = 0; i < data.length; i++) {
                            outlets += '<p class="outlets visited"><a href="'
                                    + config.URL + 'visits/view/' + data[i].outletid + '">' + data[i].outletname + '</a></p>';
                        }

                        $('#calendar-details').html('');
                        $('#calendar-details').append('<h4>Date</h4>');
                        $('#calendar-details').append('<p>' + strYear + '</p>');
                        $('#calendar-details').append('<h4>Total Actual Visit</h4>');
                        $('#calendar-details').append('<p>' + data.length + '</p>');
                        $('#calendar-details').append('<h4>List of outlets</h4>');
                        $('#calendar-details').append('<div id="outlets">');
                        $('#calendar-details').append('</div>');
                        $('#outlets').append(outlets);
                    }
                });
            }

        }

    });

    $("#schedule-outlets").minimalect({
        placeholder: "Select an Outlet",
//        onchange: function(value) {
//            
//        }
    });

    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    $('#scheduledate').datepicker({
        'format': 'yyyy-mm-dd',
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
          }
    }).on('changeDate', function(ev) {
//        if (ev.date.valueOf() > edate.valueOf()) {
//            alert('The start date can not be greater than the end date');
//            sdatepicker.setValue(sdate);
//        } else {
//            sdate = new Date(ev.date);
//            $('#edate').datepicker('show');
            //                    $('#sdate').text($('#sdate, .startdatespan').data('date'));
//        }
        $('#scheduledate').datepicker('hide');
    });

});


