@extends('layouts.dashboardnew')

@section('content')

@push('style')
<style>
	.p {
		width: 50% !important;
		text-align: center;
	}

	@media screen and (max-width: 700px) {
		#yo {
			font-size: 12px;
		}

		#mytable {
			width: 100% !important;
		}
	}
</style>
@endpush
<div class="col-xs-12">
	<div class="box box-info">
		<div class="box-header with-border text-center">
				<img src="{{ asset('assets/img/logo-light.png') }}" alt="logo" class="logo-default"
				style="width: 115px;" />
		</div>
		<div class="box-body">
			<table id="mytable" class="table table-bordered table-responsive" style="width: 100%; margin: 100px auto;">
				<thead>
					<tr>
						<th class="p">Propiedades</th>
						<th class="p">Valores</th>
					</tr>
				</thead>
				<tbody>
					@foreach($buscar as $bus)

					@php
					$referido = DB::table($settings->prefijo_wp.'users')
					->select('user_nicename')
					->where('ID', '=', $bus->referred_id)
					->get();

					$faltante = DB::table('user_campo')
					->where('ID', '=', $bus->ID)
					->get();
					@endphp

					<tr>
						<td class="p">Nombre</td>
						<td class="p" id="yo">{{$bus->user_nicename}}</td>

					</tr>

					@foreach($faltante as $falta)
					<tr>
						<td class="p">Nombre Completo</td>
						<td class="p" id="yo">{{$falta->firstname}} {{$falta->lastname}}</td>

					</tr>


					@foreach($referido as $refe)
					<tr>
						<td class="p">Patrocinador</td>
						<td class="p" id="yo">{{$refe->user_nicename}}</td>

					</tr>
					@endforeach


					<tr>
						<td class="p">Direccion</td>
						<td class="p" id="yo">{{ $falta->direccion }}</td>

					</tr>


					<tr>
						<td class="p">Pais</td>
						<td class="p" id="yo">{{ $falta->pais }}</td>

					</tr>
					<tr>
						<td class="p">Estado</td>
						<td class="p" id="yo">{{ $falta->estado }}</td>

					</tr>
					<tr>
						<td class="p">Numero de Telefono</td>
						<td class="p" id="yo">{{ $falta->phone }}</td>

					</tr>
					@endforeach

					<tr>
						<td class="p">Correo</td>
						<td class="p" id="yo">{{ $bus->user_email }}</td>

					</tr>
					@foreach($faltante as $falta)
					<tr>
						<td class="p">Fecha de Nacimiento</td>
						<td class="p" id="yo">{{ $falta->edad }}</td>

					</tr>
					<tr>
						<td class="p">Genero</td>
						@if($falta->genero == 'M')
						<td class="p" id="yo">Masculino</td>
						@else
						<td class="p" id="yo">Femenino</td>
						@endif

					</tr>
					@endforeach
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
@include('usuario.componentes.scripBotones')