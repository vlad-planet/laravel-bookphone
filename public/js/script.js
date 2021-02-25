$(document).ready(function() {

    $(".add_fav").click(function() {
        $.ajax({
            type: 'post',
            url: 'bookphone/addFav',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $(this).data('id'),
				'name': $(this).attr('data-name'),
            },
            success: function(data) {
                if ((data.errors)){
                  $('.error').removeClass('hidden');
                    $('.error').text(data.errors.name);
                }
                else {
                    $('.error').addClass('hidden');
                }
            },

        });
		
		if($(this).attr('data-name') == "add"){
			$(this).text("REMOVE");
			$(this).attr('data-name', 'rev');
		}else{
			$(this).text("ADD");
			$(this).attr('data-name', 'add');
		}
		
		//alert($(this).attr('data-name'));
    });
	
	
	$(".tbs").click(function() {
		if($(this).attr('name') == 'desc'){
			var sort = $(this).attr('href')+'&ad=desc';
		}
		if($(this).attr('name') == 'asc'){
			var sort = $(this).attr('href')+'&ad=asc';
		}
		$(this).attr('href', sort); 
		//alert();
		
	});
	
  $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text("Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#fid').val($(this).data('id'));
        $('#p').val($(this).data('phone'));
        $('#n').val($(this).data('name'));
        $('#s').val($(this).data('street'));
        $('#h').val($(this).data('home'));
        $('#myModal').modal('show');
    });
    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.did').text($(this).data('id'));
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        $('.dname').html($(this).data('name'));
        $('#myModal').modal('show');
    });

    $('.modal-footer').on('click', '.edit', function() {

        $.ajax({
            type: 'post',
            url: 'bookphone/editItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $("#fid").val(),
                'phone': $('#p').val(),
				'name': $('#n').val(),
				'street': $('#s').val(),
				'home': $('#h').val()
            },
            success: function(data) {
                $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.phone + "34344</td><td>" + data.name + "</td><td>" + data.street + "</td><td>" + data.home + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
            }
        });
    });
    $("#add").click(function() {

        $.ajax({
            type: 'post',
            url: 'bookphone/addItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'phone': $('input[name=phone]').val(),
                'name': $('input[name=name]').val(),
				'street': $('input[name=street]').val(),
				'home': $('input[name=home]').val()
            },
            success: function(data) {
                if ((data.errors)){
                  $('.error').removeClass('hidden');
                    $('.error').text(data.errors.name);
                }
                else {
                    $('.error').addClass('hidden');
                    $('#table').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.phone + "</td><td>" + data.name + "</td><td>" + data.street + "</td><td>" + data.home + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.phone + "  data-name='" + data.name + "  data-name='" + data.street + "  data-name='" + data.home + " '><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                }
            },

        });
        $('#name').val('');
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'bookphone/deleteItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
            },
            success: function(data) {
                $('.item' + $('.did').text()).remove();
            }
        });
    });
	
});
