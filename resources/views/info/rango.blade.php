@extends('layouts.dashboardnew')

@section('content')
<div class="col-xs-12">
  <div class="box box-info">
    <div class="box-body">
      <form method="POST" action="{{ route('info.mostrar-rango') }}">
        {{ csrf_field() }}

        <div class="col-sm-4">

          <label class="control-label " style="text-align: center; margin-top:4px;">Seleccione un Rango</label>
          <select class="form-control form-control-solid placeholder-no-fix form-group" name="rango" required=""
            style="background-color:f7f7f7;" />
          <option value="" selected disabled>Seleccion Un Rango</option>
          @foreach($rangos as $rango)
          <option value="{{$rango->id}}">{{$rango->name}}</option>
          @endforeach
          </select>

        </div>

        <div class="col-sm-2" style="padding-left: 10px;">
          <button class="btn green padding_both_small" type="submit" id="btn"
            style="margin-bottom: 15px; margin-top: 28px;">buscar</button>
        </div>

      </form>
    </div>
  </div>
</div>
@endsection