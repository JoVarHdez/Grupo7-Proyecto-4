@extends('administration.layouts.master')

@section('content')

          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h1 class="h2">Administrators</h1>
          </div>

          <h2>Create new Account</h2>
          
          <form action="/administration/users" method="post">

            {{ csrf_field() }}

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="exampleInputEmail1">Name</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="exampleInputname" placeholder="Name" dusk="input-name" name="name" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="exampleInputEmail1">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="john@example.com" name="email" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="password">Password</label>

              <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label" for="password_confirmation">Confirm Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password" required>
              </div>
            </div>

            <button dusk="submit-botton" type="submit" class="btn btn-primary">Submit</button>
          </form>

@endsection