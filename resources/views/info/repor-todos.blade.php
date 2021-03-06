@extends('layouts.dashboardnew')

@section('content')


@push('style')
<style>
	.color {
		background-color: #e5e5e5;
	}

	.center {
		text-align: center;
	}
</style>
@endpush

<div class="col-xs-12">
	<div class="box box-info">
		<div class="box-body">
			<table id="mytable" class="table table-bordered table-hover table-responsive">
				<thead>
					<tr class="color">
						<th class="center">#</th>
						<th class="center">Nombre del usuario</th>
						<th class="center">N° de compra</th>
						<th class="center">Concepto</th>
						<th class="center">Fecha</th>
						<th class="center">Total</th>
						<th class="center">Correo del referido</th>
						<th class="center">Nivel</th>
						<th class="center">Estado</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($comision as $comi)

					@php
					$faltante = DB::table($settings->prefijo_wp.'users')
					->where('ID', '=', $comi->user_id)
					->get();
					@endphp

					<tr>
						<td class="center">{{ $comi->id }}</td>
						@foreach ($faltante as $falta)
						<td class="center">{{ $falta->user_nicename }}</td>
						@endforeach
						<td class="center">{{ $comi->compra_id }}</td>
						<td class="center">{{ $comi->concepto }}</td>
						<td class="center">{{ $comi->date }}</td>
						<td class="center">{{ $comi->total }}</td>
						<td class="center">{{ $comi->referred_email }}</td>
						<td class="center">{{ $comi->referred_level }}</td>
						<td class="center">
							@if ($comi->status == 1)
							Aprobado
							@elseif ($comi->status == 0)
							En Espera
							@endif
						</td>
					</tr>
					@endforeach

				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
@include('usuario.componentes.scripBotones')