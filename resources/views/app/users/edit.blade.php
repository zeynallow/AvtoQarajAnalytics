@extends('layouts.app')

@section('content')
  <section class="section">
    <div class="section-header">
      <h1>İstifadəçi ID: {{$user->id}}</h1>
    </div>
    <div class="section-body">
      <div class="card">
        <div class="card-body">

          @if (\Session::has('success'))
            <div class="alert alert-success">
              {!! \Session::get('success') !!}
            </div>
            <br/>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{route('users.update',$user->id)}}" method="post">

            <div class="form-group">
              <label for="name">Adı</label>
              <input type="text" class="form-control" name="name" value="{{$user->name}}">
            </div>

            <div class="form-group">
              <label for="email">E-mail</label>
              <input type="text" class="form-control" name="email" value="{{$user->email}}">
            </div>

            <div class="form-group">
              <label for="role_id">İstifadəçi növü</label>
              <select class="form-control" name="role_id" id="role_id">
                @foreach ($roles as $key => $role)
                  @if($role->id == $user->role_id)
                    <option selected value="{{$role->id}}">{{$role->role_name}}</option>
                  @else
                    <option value="{{$role->id}}">{{$role->role_name}}</option>
                  @endif
                @endforeach
              </select>
            </div>


            <div class="form-group" id="select_shop" style="{{($user->role_id == 2) ? 'display:block;' : 'display:none;'}}">
              <label for="shop_id">Mağaza</label>
              <select class="form-control" name="shop_id" id="shop_id">
                <option value="0">Seçin</option>
                @foreach ($shops as $key => $shop)
                  @if($user->shop_id == $shop->id)
                    <option selected value="{{$shop->id}}">{{$shop->name}}</option>
                  @else
                    <option value="{{$shop->id}}">{{$shop->name}}</option>
                  @endif
                @endforeach
              </select>
            </div>


            <div class="form-group">
              <label for="password">Şifrə</label>
              <input type="text" class="form-control" name="password" value="">
            </div>

            <br/>
            <div class="form-group">
              @csrf
              <button type="submit" class="btn btn-success">Yadda saxla</button>
            </div>


          </form>

        </div>
      </div>
    </div>

  </section>
@endsection

@push('javascript')
  <script type="text/javascript">

  $("#role_id").change(function(){
    var user_type = $(this).val();

    if(user_type == 1){
      $("#select_shop").hide();
    }else if(user_type == 2){
      $("#select_shop").show();
    }else{
      $("#select_shop").hide();
    }

    $("#shop_id").val("0");
  });


  </script>
@endpush
