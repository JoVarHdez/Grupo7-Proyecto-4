@extends('administration.layouts.master')

@section('content')

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Products</h1>
          </div>

          <h2>Create Product</h2>
          
          <form action="/administration/products" method="post" enctype="multipart/form-data">

            {{ csrf_field() }}

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="exampleInputname">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="exampleInputname" placeholder="Enter new name" name="name" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="exampleInputDescription">Description</label>
              <div class="col-sm-10">
                <textarea type="text" class="form-control" id="exampleInputDescription" placeholder="Enter new description" name="description" required></textarea>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="exampleInputPrice">Price</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input type="number" value="0" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="exampleInputPrice" placeholder="Enter new price" name="price" required>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="exampleInputAmount">Amount</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="exampleInputAmount" placeholder="Enter new amount" name="amount" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="exampleInputImage">Image</label>
              <div class="col-sm-10">
                <input type="file" name="file" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Active</label>
              <div class="col-sm-10">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="exampleInputActive" name="active">
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Category</label>
              <div class="col-sm-10">
                <select multiple class="form-control" name="category">
                  @foreach ($categories as $category)
                    <option value="{{$category->name}}">{{$category->name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

@endsection