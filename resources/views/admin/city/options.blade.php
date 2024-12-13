@forelse($cities as $key => $city)
    <option value = "{{$city->city_name}}" >{{$city->city_name}}</option>
@empty
<option value = "" disabled>No any city found</option>
@endforelse