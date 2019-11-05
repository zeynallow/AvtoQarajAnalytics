@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>İstifadəçilər <a class="btn btn-success btn-sm" href="{{ route('users.create') }}">+ Yeni istifadəçi</a></h1>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">

          <div class="row">
            <div class="col-md-12">

            </div>
          </div>
          <br/>

          @if (\Session::has('error'))
            <div class="alert alert-danger">
              {!! \Session::get('error') !!}
            </div>
            <br/>
          @endif

          @if (\Session::has('success'))
            <div class="alert alert-success">
              {!! \Session::get('success') !!}
            </div>
            <br/>
          @endif

          @if(count($users))
            <div class="row">
              <div class="col-md-12 table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>İD</th>
                      <th>Adı</th>
                      <th>E-mail</th>
                      <th>Mağaza</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($users) > 0)
                      @foreach ($users as $key => $user)
                        <tr>
                          <td>{{$user->id}}</td>
                          <td>{{$user->name}}</td>
                          <td>{{$user->email}}</td>
                          <td></td>
                          <td><a href="{{ route('users.edit',$user->id)}}" class="btn btn-info"><i class="fa fa-edit"></i></a></td>
                        </tr>
                      @endforeach
                    @endif

                  </tbody>
                </table>
              </div>
              <div class="col-md-12">
                {{$users}}
              </div>
            </div>
          @else
            <div class="alert alert-danger">
              İstifadəçi yoxdur
            </div>
          @endif

        </div>
      </div>
    </div>

  </section>
@endsection
