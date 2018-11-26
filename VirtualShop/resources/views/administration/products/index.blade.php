@extends('administration.layouts.master')

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
      <h1 class="h2">Products</h1>
    </div>
    <p>
      <a href="/administration/products/create" class="btn btn-primary my-2">Create New</a>
    </p>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">

            @foreach ($products as $product)

            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" src="{{ asset('products/'.$product->image_path) }}">
                <div class="card-body">
                  <p class="card-title">{{$product->name}}</p>
                  <p class="card-text">{{$product->description}}</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                     <!--  <button type="button" class="btn btn-sm btn-outline-secondary">View</button> -->
                      <button type="button" name="{{$product->name}}_edit" class="btn btn-sm btn-outline-secondary" onclick="location.href = '/administration/products/{{ $product->idProduct }}';">Edit</button>
                    </div>
                    <small class="text-muted">$ {{$product->price}}</small>
                    <small class="text-muted">Qty: {{$product->amount}}</small>
                  </div>
                </div>
              </div>
            </div>

            @endforeach
            
          </div>
        </div>
      </div>
@endsection