<!-- resources/views/users.blade.php -->

@extends('layouts.app')

@section('content')

<!-- Форма создания задачи... -->
	{{ csrf_field() }}
    <div class="container">
		<a href="/bookphone"><b>BOOKFONES >> (ПЕРЕЙТИ В ТЕЛЕФОННУЮ КНИГУ)</b></a>
		<br><br><br>
		
  		<div class="table-responsive text-center">
			<? if(!empty($data)){ ?>

			<? //var_dump($data[0]['department']['name']) ?>
  			<table class="table table-borderless" id="table">
				<label>ЗАРЕГИСТРИРОВАННЫЕ ПОЛЬЗОВАТЕЛИ</label>
  				<thead>
  					<tr>
  						<th class="text-center"><a href="?sort=id<?=(isset($_GET['page']))? '&page='.$_GET['page'] : '' ; ?>" name="<?=(isset($_GET['ad']) && $_GET['ad'] == 'desc')? 'asc': 'desc'; ?>" class="tbs">#</a></th>
  						<th class="text-center"><a href="?sort=name<?=(isset($_GET['page']))? '&page='.$_GET['page'] : '' ; ?>" name="<?=(isset($_GET['ad']) && $_GET['ad'] == 'desc')? 'asc': 'desc'; ?>" class="tbs">Name</a></th>
						<th class="text-center"><a href="?sort=email<?=(isset($_GET['page']))? '&page='.$_GET['page'] : '' ; ?>" name="<?=(isset($_GET['ad']) && $_GET['ad'] == 'desc')? 'asc': 'desc'; ?>" class="tbs">Email</a></th>
						<th class="text-center"><a href="?sort=created_at<?=(isset($_GET['page']))? '&page='.$_GET['page'] : '' ; ?>" name="<?=(isset($_GET['ad']) && $_GET['ad'] == 'desc')? 'asc': 'desc'; ?>" class="tbs">Created</a></th>
						<th class="text-center"><a href="?sort=updated_at<?=(isset($_GET['page']))? '&page='.$_GET['page'] : '' ; ?>" name="<?=(isset($_GET['ad']) && $_GET['ad'] == 'desc')? 'asc': 'desc'; ?>" class="tbs">Updated</a></th>
						<th class="text-center"><a href="?sort=role_id<?=(isset($_GET['page']))? '&page='.$_GET['page'] : '' ; ?>" name="<?=(isset($_GET['ad']) && $_GET['ad'] == 'desc')? 'asc': 'desc'; ?>" class="tbs">Role</a></th>
					</tr>
  				</thead>
  				@foreach($data as $item)
  				<tr class="item{{$item->id}}">
  					<td>{{$item->id}}</td>
  					<td>{{$item->name}}</td>
					<td>{{$item->email}}</td>
					<td>{{$item->created_at}}</td>
					<td>{{$item->updated_at}}</td>
					<td>{{$item->department['name']}}</td>
  				</tr>
  				@endforeach
  			</table>
			{{ $data->links() }}
			<? } ?>
  		</div>
  	</div>

@endsection