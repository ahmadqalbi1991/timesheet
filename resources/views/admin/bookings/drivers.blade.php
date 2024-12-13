
@foreach($drivers as $driver)
	<option value = "{{$driver->user_id}}" > {{$driver->name}}  {{ ($driver->is_company == 'no')?'(Individual)':'(Company)' }} </option>
@endforeach