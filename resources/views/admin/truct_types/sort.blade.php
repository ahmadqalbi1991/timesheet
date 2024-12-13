@extends("admin.template.layout")

@section('content')
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
 
  <style>
  
  </style>
 

  <div class="row">
    <div class="col-md-6">
 <form action="#" method="post" id="sort_form">
    <ul id="sortable">
       @foreach($truckTypes as $val)
                <li class="ui-state-default li_detail" detail_id="{{$val->id}}"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{$val->truck_type}}</li>
                @endforeach
    </ul>
    <input type="submit" name="Submit" value="Save Sort">
 </form>
</div>
</div>
@stop

@section('script')

 <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#sortable" ).sortable();
    $('#sort_form').on('submit',function(e){
        e.preventDefault();
        var ids = [];
        $('.li_detail').each(function(i,k){
            
              ids.push($(this).attr('detail_id'));
            
            
        });
        console.log(ids);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: '{{url("admin/truck_types/savesort")}}',
            data: {
                'details' : ids,
                '_token':'{{csrf_token()}}'
            },
           
            dataType: 'json',
            success: function(res) {
                App.alert(res['message'] || 'Data saved successfully');
            }
        });
    })
  } );
  </script>
  @stop