@extends('administration.layouts.master')

@section('content')

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Categories</h1>
          </div>

          <h2>Edit Category</h2>
          
          <form action="/administration/categories/update/{{ $category->idCategory }}" method="post">

            {{ csrf_field() }}

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="exampleInputname">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="exampleInputname" placeholder="Enter new name" name="name" required>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

@endsection