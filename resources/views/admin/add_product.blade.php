@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add new product
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form role="form" action="{{ URL::to('/create_product') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">Product name</label>
                                <input type="text" class="form-control" id="name" name="product_name"
                                    placeholder="Enter product name">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    placeholder="price">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea style="resize: none;" rows="3" type="text" class="form-control" id="description" name="description"
                                    placeholder="description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="status">status</label>
                                <input type="text" class="form-control" id="status" name="status"
                                    placeholder="price">
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" id="image" name="image">
                                <!-- <p class="help-block">Example block-level help text here.</p> -->
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> Check me out
                                </label>
                            </div>
                            <button type="submit" class="btn btn-info">Add</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
    </div>
@endsection
