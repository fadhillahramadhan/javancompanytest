@extends('layouts.app')

<style>
    /*Now the CSS*/
    * {
        margin: 0;
        padding: 0;
    }

    .tree ul {
        padding-top: 20px;
        position: relative;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree li {
        float: left;
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*We will use ::before and ::after to draw the connectors*/

    .tree li::before,
    .tree li::after {
        content: '';
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 1px solid #ccc;
        width: 50%;
        height: 20px;
    }

    .tree li::after {
        right: auto;
        left: 50%;
        border-left: 1px solid #ccc;
    }

    /*We need to remove left-right connectors from elements without 
        any siblings*/
    .tree li:only-child::after,
    .tree li:only-child::before {
        display: none;
    }

    /*Remove space from the top of single children*/
    .tree li:only-child {
        padding-top: 0;
    }

    /*Remove left connector from first child and 
        right connector from last child*/
    .tree li:first-child::before,
    .tree li:last-child::after {
        border: 0 none;
    }

    /*Adding back the vertical connector to the last nodes*/
    .tree li:last-child::before {
        border-right: 1px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }

    .tree li:first-child::after {
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }

    /*Time to add downward connectors from parents*/
    .tree ul ul::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 1px solid #ccc;
        width: 0;
        height: 20px;
    }

    .tree li a {
        border: 1px solid #ccc;
        padding: 5px 10px;
        text-decoration: none;
        color: #666;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;

        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*Time for some hover effects*/
    /*We will apply the hover effect the the lineage of the element also*/
    .tree li a:hover,
    .tree li a:hover+ul li a {
        background: #c8e4f8;
        color: #000;
        border: 1px solid #94a0b4;
    }

    /*Connector styles on hover*/
    .tree li a:hover+ul li::after,
    .tree li a:hover+ul li::before,
    .tree li a:hover+ul::before,
    .tree li a:hover+ul ul::before {
        border-color: #94a0b4;
    }

    .L {
        background-color: #424bf5;
        color: white !important;
    }

    .P {
        color: white !important;
        background-color: #e88282;
    }
</style>
@section('content')
<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="tree">
                        @foreach ($families as $item)
                        <ul>
                            <li>
                                <a class="{{ $item->gender }}" href="#">{{$item->name}}</a>
                                <ul>
                                    @foreach ($item->children as $child)
                                    <li>
                                        <a class="{{ $child->gender }}" href="#">{{$child->name}}</a>
                                        <ul>
                                            @foreach ($child->children as $grandchild)
                                            <li>
                                                <a class="{{ $grandchild->gender }}" href="#">{{$grandchild->name}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-2">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
            @endif
            <div class="card">
                <div class="pull-right mt-2 ml-2">
                    <a class="btn btn-success" onClick="add()" href="javascript:void(0)">Create</a>
                </div>
                <div class="card-body">
                    <div style="width: 100%; overflow-y: hidden; overflow-x:hidden;">
                        <table class="table table-bordered" id="products" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- boostrap product model -->
<div class="modal fade" id="product-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="javascript:void(0)" id="ProductForm" name="ProductForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title" id="FamilyModal"></h6>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Product name" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="gender" name="gender">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Keluarga</label>
                        <div class="col-sm-12">
                            <select class="form-control" id="parent_id" name="parent_id"></select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary " id="btn-save">Save changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- end bootstrap model -->

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#products').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('families') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
        });
    });

    function add() {
        $('#ProductForm').trigger("reset");
        $('#FamilyModal').html("Add product");
        $('#product-modal').modal('show');
        $('#id').val('');
    }

    function editFunc(id) {
        $.ajax({
            type: "POST",
            url: "{{ url('edit-family') }}",
            data: {
                id: id
            },
            dataType: 'json',
            success: function(res) {
                $('#FamilyModal').html("Edit Family");
                $('#product-modal').modal('show');
                $('#id').val(res.id);
                $('#name').val(res.name);
                $('#gender').val(res.gender);
                $('#parent_id').val(res.parent_id);


            }
        });
    }

    function getFamilies() {
        $.ajax({
            type: "GET",
            ajax: "{{ route('get-families') }}",
            dataType: 'json',
            success: function(res) {
                let data = res.data;

                var html = '<option value="">Keluarga baru</option>';
                $.each(data, function(key, value) {
                    html += '<option value="' + value.id + '">' + value.name + '</option>';
                });
                $('#parent_id').html(html);
            }
        });
    }

    getFamilies();

    function deleteFunc(id) {
        if (confirm("Delete record?") == true) {
            var id = id;
            // ajax
            $.ajax({
                type: "POST",
                url: "{{ url('delete-family') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    var oTable = $('#products').dataTable();
                    oTable.fnDraw(false);

                    // refresh page
                    location.reload();
                }
            });
        }
    }
    $('#ProductForm').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: 'POST',
            url: "{{ url('store-family') }}",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: (data) => {
                $("#product-modal").modal('hide');
                var oTable = $('#products').dataTable();
                oTable.fnDraw(false);
                $("#btn-save").html('Submit');
                $("#btn-save").attr("disabled", false);

                location.reload();

            },
            error: function(data) {
                console.log(data);
            }
        });
    });
</script>
@endsection