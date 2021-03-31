@extends('layouts.app')
@section('title','Category')

@section('app_content')
<div class="container">
    <h1 class="text-center mt-5">AXIOS CRUD</h1>
    <hr>
    <div class="row">
        <div class="col-8">
            <table class="table table-bordered">
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Actions</th>
                </tr>
                <tbody id="colorTableBody"></tbody>
            </table>
        </div>
        <div class="col-4">
            <form action="" id="addForm">
                <div class="form-group">
                    <input type="text" class="form-control" id="name" placeholder="Enter name">
                    <span class="text-danger" id="nameError"></span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="number" placeholder="Enter number" >
                    <span id="numError" class="text-danger"></span>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-success">Add New Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@push('script')
<script>
        function table_data_row(data) {
            var	rows = '';
            var i = 0;
            $.each( data, function( key, value ) {
                value.id
                rows = rows + '<tr>';
                rows = rows + '<td>'+ ++i +'</td>';
                rows = rows + '<td>'+value.name+'</td>';
                rows = rows + '<td>'+value.number+'</td>';
                rows = rows + '<td data-id="'+value.id+'" class="text-center">';
                rows = rows + '<a class="btn btn-sm btn-info text-light" id="editRow" data-id="'+value.id+'" data-toggle="modal" data-target="#editModal">Edit</a> ';
                rows = rows + '<a class="btn btn-sm btn-danger text-light"  id="deleteRow" data-id="'+value.id+'" >Delete</a> ';
                rows = rows + '</td>';
                rows = rows + '</tr>';
            });
            $("#colorTableBody").html(rows);
    }
    function getAllData(){
        axios.get("{{ route('get-cat') }}")
        .then(function(response){
            table_data_row(response.data);
           // console.log(response.data);
        })
        .catch(function(e){
            console.log(e);
        })
    }
    getAllData();

    $('body').on('submit','#addForm',function(e){
        e.preventDefault();
        let nameError = $('#nameError')
        let numError = $('#numError')
        nameError.text('')
        numError.text('')
        axios.post("{{ route('category.store') }}", {
            name: $('#name').val(),
            number : $('#number').val()
        })
        .then(function (response) {
           // console.log(response.data)
            getAllData();
            setSwalMessage();
            $('#name').val('');
            $('#number').val('');
        })
        .catch(function (error) {
            if(error.response.data.errors.name){
                nameError.text(error.response.data.errors.name[0]);
            }
            if(error.response.data.errors.number){
                numError.text(error.response.data.errors.number[0]);
            }

            console.log(error);
        });
    });
let base = window.location.origin
//console.log(base);
    $('body').on('click','#deleteRow',function(){
        let id = $(this).data('id')
        let url = base + '/category/' + id
        console.log(url);
        let ob = {id : id}
        axios.delete(url, {params: ob}).then(function(r){
            setSwalMessage();
            getAllData();
            console.log(r);
        });
    })
</script>
@endpush
