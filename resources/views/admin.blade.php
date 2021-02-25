<!-- resources/views/bookphones.blade.php -->

@extends('layouts.app')

@section('content')


<!-- Форма создания задачи... -->
	{{ csrf_field() }}
	    <br><br><br><br>
      <div class="container">
    		<div class="form-group row add">
    			<div class="col-md-8">
    				<input type="text" class="form-control" id="phone" name="phone"
    					placeholder="Enter some phone" required>
    				<input type="text" class="form-control" id="name" name="name"
    					placeholder="Enter some name" required>
    				<input type="text" class="form-control" id="street" name="street"
    					placeholder="Enter some street" required>
    				<input type="text" class="form-control" id="home" name="home"
    					placeholder="Enter some home" required>
    				<p class="error text-center alert alert-danger hidden"></p>
    			</div>
    			<div class="col-md-4">
    				<button class="btn btn-primary" type="submit" id="add">
    					<span class="glyphicon glyphicon-plus"></span> ADD
    				</button>
    			</div>
    		</div>
  		   {{ csrf_field() }}
  		<div class="table-responsive text-center">
  			<table class="table table-borderless" id="table">
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
  					<td><button class="edit-modal btn btn-info" data-id="{{$item->id}}"
  							data-name="{{$item->name}}" data-phone="{{$item->phone}}" data-street="{{$item->street}}" data-home="{{$item->home}}" >
  							<span class="glyphicon glyphicon-edit"></span> Edit
  						</button>
  						<button class="delete-modal btn btn-danger"
  							data-id="{{$item->id}}" data-name="{{$item->name}}">
  							<span class="glyphicon glyphicon-trash"></span> Delete
  						</button></td>
  				</tr>
  				@endforeach
  			</table>
  		</div>
  	</div>
  	<div id="myModal" class="modal fade" role="dialog">
  		<div class="modal-dialog">
  			<!-- Modal content-->
  			<div class="modal-content">
  				<div class="modal-header">
  					<button type="button" class="close" data-dismiss="modal">&times;</button>
  					<h4 class="modal-title"></h4>
  				</div>
  				<div class="modal-body">
  					<form class="form-horizontal" role="form">
  						<div class="form-group">
  							<label class="control-label col-sm-2" for="id">ID:</label>
  							<div class="col-sm-10">
  								<input type="text" class="form-control" id="fid" disabled>
  							</div>
  						</div>
  						<div class="form-group">
							<div class="col-sm-10">
  							<input type="name" class="form-control" id="p" for="phone">
							<input type="name" class="form-control" id="n" for="name">
							<input type="name" class="form-control" id="s" for="street">
							<input type="name" class="form-control" id="h" for="home">
							</div>							

  						</div>
  					</form>
  					<div class="deleteContent">
  						Are you Sure you want to delete <span class="dname"></span> ? <span
  							class="hidden did"></span>
  					</div>
  					<div class="modal-footer">
  						<button type="button" class="btn actionBtn" data-dismiss="modal">
  							<span id="footer_action_button" class='glyphicon'> </span>
  						</button>
  						<button type="button" class="btn btn-warning" data-dismiss="modal">
  							<span class='glyphicon glyphicon-remove'></span> Close
  						</button>
  					</div>
  				</div>
  			</div>
		  </div>
	</div>
@endsection