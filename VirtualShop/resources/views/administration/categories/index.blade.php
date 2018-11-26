@extends('administration.layouts.master')

@section('content')
      
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Categories</h1>
      </div>
      <p>
        <a href="/administration/categories/create" class="btn btn-primary my-2">Create New</a>
      </p>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">

            @foreach ($categories as $category)

              <div class="col-md-2">
              <div class="card mb-2 shadow-sm">
                <div class="card-body">
                  <p class="card-text">{{$category->name}}</p>
                    <div class="btn-group">
                      <button type="button" name="{{$category->name}}_edit" class="btn btn-sm btn-outline-secondary" onclick="location.href = '/administration/categories/{{ $category->idCategory }}';">Edit</button>
                  </div>
                </div>
              </div>
            </div>

            @endforeach
            
          </div>
        </div>
      </div>
@endsection