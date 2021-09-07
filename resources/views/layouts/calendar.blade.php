<script type="text/javascript">
var today = new Date();
year = today.getFullYear();
month = today.getMonth();
day = today.getDate();
var calendar = $('#myEvent').fullCalendar({
  height: 'auto',
  defaultView: 'month',
  editable: false,
  selectable: true,
  header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay,listMonth'
  },



  events: [ 
  @foreach(getUserTask(Auth::id()) as $task)
    {
     
      @php
      //Atributed date info
        $date = strtotime($task->attributed_at);
        $year = date('Y',$date);
        $month = date('m',$date);
        $day = date('d',$date);
      //Delais execution date info
        $dateEnd = strtotime($task->delaisExec);
        $yearEnd = date('Y',$dateEnd) ;
        $monthEnd = date('m',$dateEnd) ;
        $dayEnd = date('d',$dateEnd) ;



        //Choose color for background
        $color = formatLevel($task->niveau_evolutions_id)['textColor'];

        
      @endphp
  

      title: "{{$task->nomTache}}",
      start: new Date({{ $year }}, {{ $month-1 }}, {{ $day }}),
      end: new Date({{ $yearEnd }}, {{ $monthEnd-1 }}, {{ $dayEnd }}),
      backgroundColor: "{{ $color }}"
    },
  @endforeach
]



});

</script>