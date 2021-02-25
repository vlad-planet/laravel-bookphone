<!-- resources/views/bookphones.blade.php -->

@extends('layouts.app')

@section('content')

<!-- Форма создания задачи... -->
	{{ csrf_field() }}
    <div class="container">
		<a href="/bookphone"><b>BOOKFONES >> (ПЕРЕЙТИ В ТЕЛЕФОННУЮ КНИГУ)</b></a>
		<br>
		<a href="/users"><b>ALL USERS >></b></a>
		<br><br><br>
		
  		<div class="table-responsive text-center">
			<? if(!empty($data)){ ?>
  			<table class="table table-borderless" id="table">
				<label>ИЗБРАННОЕ ТЕКУЩЕГО ПОЛЬЗОВАТЕЛЯ</label>
  				<thead>
  					<tr>
  						<th class="text-center">#</th>
  						<th class="text-center">Phone</th>
						<th class="text-center">Name</th>
						<th class="text-center">Street</th>
						<th class="text-center">Home</th>
						<th class="text-center">Actions</th>
  					</tr>
  				</thead>
  				@foreach($data as $item)
  				<tr class="item{{$item->id}}">
  					<td>{{$item->id}}</td>
  					<td>{{$item->phone}}</td>
					<td>{{$item->name}}</td>
					<td>{{$item->street}}</td>
					<td>{{$item->home}}</td>
  					<td>
						<button class="btn btn-primary add_fav" type="submit" data-id="{{$item->id}}" data-name="rev">REMOVE</button>
					</td>
  				</tr>
  				@endforeach
  			</table>
			<? } ?>
  		</div>
  	</div>

@endsection