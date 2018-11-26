@extends('administration.layouts.master')

@section('content')
      
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Administrators</h1>
      </div>
      <p>
        <a href="/administration/users/create" class="btn btn-primary my-2">Create New</a>
      </p>

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">

            @foreach ($admins as $admin)

              <div class="col-md-2">
              <div class="card mb-2 shadow-sm">
                <div class="card-body">
                  <p class="card-text">{{$admin->name}}</p>
                </div>
              </div>
            </div>

            @endforeach
            
          </div>
        </div>
      </div>
@endsection