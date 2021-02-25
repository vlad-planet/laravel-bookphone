<!-- resources/views/bookphones.blade.php -->

@extends('layouts.app')

@section('content')


<!-- Форма создания задачи... -->
	{{ csrf_field() }}
	
    <div class="container">
		<a href="/favourites"><b>FAVORITES >> (ПЕРЕЙТИ В ИЗБРАННОЕ)</b></a>
		<br>
		<a href="/users"><b>ALL USERS >></b></a>
		<br><br><br>
					<form method="GET" >
						<input type="text" class="" id="search" name="search" placeholder="Search" size="50" required>
						<input type="submit" value="SEARCH" name="send"/>
					</form>
					
<? if(isset($msg)){echo "<a href='/bookphone'>{$msg}</a>";} // обработчик напишу позже =) JS ?>					
<form action="{{ URL::to('downloadExcel') }}" class="form-horizontal" method="GET" enctype="multipart/form-data">
                <label for="">Download:</label>
                <select id="" name="type">
                    <option value="xls">Excel xls</option>
                    <option value="xlsx">Excel xlsx</option>
                    <option value="csv">CSV</option>
                    <option value="pdf">PDF</option>
                </select>
                <input type="submit" value="Отправить" />
			
					
					
  		<div class="table-responsive text-center">
			<? if(!empty($data)){ ?>
  			<table class="table table-borderless" id="table">
				<label>ТЕЛЕФОННАЯ КНИГА</label>
  				<thead>
  					<tr>
						<th class="text-center">Check</th>
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
					<td><input type="checkbox" name="bp_id[]" value="{{$item->id}}"></td>
  					<td>{{$item->id}}</td>
  					<td>{{$item->phone}}</td>
					<td>{{$item->name}}</td>
					<td>{{$item->street}}</td>
					<td>{{$item->home}}</td>
  					<td>
					<?
						$key = '';
						if(!empty($bp)){$key = array_search($item->id,$bp);}
						if(isset($bp[$key]) && $bp[$key] == $item->id){	
					?>
						<button class="btn btn-primary add_fav" type="button" data-id="{{$item->id}}" data-name="rev">REMOVE</button>
					<?	}else{	?>
						<button class="btn btn-primary add_fav" type="button" data-id="{{$item->id}}" data-name="add">ADD</button>
					<?	}	?>
					</td>
  				</tr>
  				@endforeach
  			</table>
			<? } ?>

  		</div>
</form>
  	</div>

@endsection