@extends('layouts.landing')

@push('styles')
    <style>
        .banner-text{
            color: white; font-size: 50px; font-weight: bold;
        }
        .banner-title{
            width: 70%; 
            line-height: 50px;
        }
        .banner-buttons{
            font-size: 35px; 
            padding-top: 60px;
        }
        .banner-next-text{
            font-weight: bold; 
            width: 180px; 
            font-size: 28px; 
            color: #CF202F;
        }
        .banner-date{
            font-size: 20px;
            color: #fff;
            font-weight: 300;
            padding-top: 10px;
        }
        @media (max-width: 1000px) {
            .banner-text{
                font-size: 30px; 
            }
            .banner-title{
                width: 70%; 
                line-height: 30px;
            }
            .banner-buttons{
                font-size: 25px; 
                padding-top: 30px;
            }
            .banner-next-text{
                font-size: 22px;
            }
            .section-title-landing{
                font-size: 24px;
            }
            .reciente-mentor-name {
                top: 50%;
            }
        }
        @media (max-width: 500px) {
            .banner-text{
                font-size: 26px; 
            }
            .banner-title{
                width: 70%; 
                line-height: 26px;
            }
            .banner-buttons{
                font-size: 18px; 
                padding-top: 5px;
            }
            .banner-next-text{
                font-size: 16px;
            }
            .banner-date{
                font-size: 14px;
                padding-top: 5px;
            }
            .section-title-landing{
                font-size: 18px;
            }
        }
    </style>
@endpush

@push('scripts')
  <script>
    if ({{$modalVisitante}} == 1){
      $('#visitante-modal').modal();
    }
  </script>
@endpush
@section('content')

@if (app('request')->input('logout') == "1")
    <script>
        document.getElementById('logout-form').submit();
    </script>
@endif

@if (Session::has('msj-exitoso'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <strong>{{ Session::get('msj-exitoso') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

   {{-- SLIDER --}}
   @if ($cursosDestacados->count() > 0)
      <div class="container-fluid courses-slider">
         <div id="mainSlider" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000">
            @if ($cursosDestacados->count() > 1)
               @php $contCD = 0; @endphp
               <ol class="carousel-indicators">
                  @foreach ($cursosDestacados as $cd)
                     <li data-target="#mainSlider" data-slide-to="{{ $contCD }}" @if ($contCD == 0) class="active" @endif></li>
                     @php $contCD++; @endphp
                  @endforeach
               </ol>
            @endif
            <div class="carousel-inner">
               @php $cont = 0; @endphp
               @foreach ($cursosDestacados as $cursoDestacado)
                  @php $cont++; @endphp
                  <div class="carousel-item @if ($cont == 1) active @endif">
                     <div class="overlay" ></div>
                     <img src="{{ asset('uploads/images/courses/featured_covers/'.$cursoDestacado->featured_cover) }}" class="d-block w-100 img-fluid" alt="...">
                     <div class="carousel-caption">
                        <p style="color:#007bff; font-size: 22px; font-weight: bold; margin-top: -20px;">NUEVA GRABACIÓN</p>
                        <div class="course-autor text-white">{{$cursoDestacado->mentor->display_name}}</div>
                        <div class="course-title"> <a href="{{ route('courses.show', [$cursoDestacado->slug, $cursoDestacado->id]) }}" style="color: white;">{{ $cursoDestacado->title }}</a></div>
                        <!--<div class="course-category">{{ $cursoDestacado->category->title }}</div>-->
                     </div>
                  </div>
               @endforeach
            </div>
            @if ($cursosDestacados->count() > 1)
               <a class="carousel-control-prev" href="#mainSlider" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#mainSlider" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
               </a>
            @endif
         </div>
      </div>
   @endif
   {{-- FIN DEL SLIDER --}}
@if (!Auth::guest())
<div class="title-page-course col-md"><span class="text-white">
    <h3 class="mb-4"><span class="text-white">Hola</span><span class="text-danger"> {{Auth::user()->display_name}}</span><span class="text-white"> ¡Nos alegra verte hoy!</span></h3>
</div>
@endif
   @if(!empty($evento_actual))
      <div style="width: 100%; position: relative; display: inline-block;">
         <img src="{{ asset('uploads/images/banner/'.$evento_actual->image) }}" alt="" style="width:100%; opacity: 0.5;">
         <div style="position: absolute; top: 2%; left: 5%;">
            <div class="banner-text">
               <a class="banner-next-text">PRÓXIMO STREAMING</a><br>
               <div class="banner-title">
                  <a href="{{ route('timelive')}}" class="text-white">{{$evento_actual->title}}</a>
               </div>
                <div class="banner-date">
                    <i class="fa fa-calendar"></i> {{\Carbon\Carbon::parse($evento_actual->date)->formatLocalized(' %d de %B')}}
                    <i class="fa fa-clock" style="padding-left: 20px;"></i>{{\Carbon\Carbon::parse($evento_actual->time)->format('g:i a')}}
                </div>
               <div class="banner-buttons">
                  @if (Auth::guest())
                     {{-- USUARIOS INVITADOS --}}
                     <a href="{{route('shopping-cart.membership')}}" class="btn btn-danger" ><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADQUIRIR MEMBRESÍA</a>
                  @else
                     @if (is_null(Auth::user()->membership_id))
                        {{-- USUARIOS LOGUEADOS SIN MEMBRESÍA  --}}
                        <a href="{{route('shopping-cart.membership')}}" class="btn btn-danger"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADQUIRIR MEMBRESÍA</a>
                     @else
                        @if (Auth::user()->membership_status == 1)
                           @if (!in_array($evento_actual->id, $misEventosArray))
                              @if (Auth::user()->streamings < Auth::user()->membership->streamings)
                                 {{-- USUARIOS LOGUEADOS CON STREAMINGS DISPONIBLES Y QUE NO TIENEN EL EVENTO AGENDADO AÚN--}}
                                 <a href="{{ route('schedule.event', [$evento_actual->id]) }}" class="btn btn-danger"><i class="fas fa-chevron-right"></i> RESERVAR PLAZA </a>
                              @else
                                 @if (Auth::user()->membership_id < 4)
                                    <a href="{{route('shopping-cart.store', [Auth::user()->membership_id+1, 'membresia', 'Mensual'])}}" class="btn btn-warning"><i class="fa fa-shopping-cart" aria-hidden="true"></i> AUMENTAR MEMBRESÍA</a>
                                 @else
                                    <i class="fa fa-times" aria-hidden="true"></i> Límite de Eventos Superado
                                 @endif
                              @endif
                           @else
                              <a href="{{ route('timeliveEvent', $evento_actual->id) }}" class="btn btn-danger">Ir al Evento<i class="fas fa-chevron-right"></i></a>
                           @endif
                        @else
                           <a href="{{route('shopping-cart.store', [Auth::user()->membership_id, 'membresia', 'Mensual'])}}" class="btn btn-danger"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Renovar Membresía</a>
                        @endif
                     @endif
                  @endif
               </div>
            </div>
         </div>
      </div>
   @endif

   @if (Session::has('msj'))
      <div class="col-md-12">
         <div class="alert alert-secondary">
            <button class="close" data-close="alert"></button>
            <span>{{Session::get('msj')}}</span>
         </div>
      </div>
   @endif

   @if (Session::has('msj2'))
      <div class="col-md-12">
         <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span>{{Session::get('msj2')}}</span>
         </div>
      </div>
   @endif

   @if ($total > 0)
   <div class="section-landing" style="background: linear-gradient(to bottom, #222326 50%, #1C1D21 50.1%);">
      <div class="col">
         <div class="section-title-landing" style="padding-bottom: 35px;">PRÓXIMAS TRANSMISIONES EN VIVO</div>
      </div>

      @if($total > 0)
         <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="row">
                     @php $contador =0; @endphp
                     @foreach($proximos as $proxima)
                        @php $contador++; @endphp

                        @if($contador <= 3)
                           <div class="col-md-4" style="margin-top: 20px;">

                              @if ($proxima->miniatura == null)
                                 <img src="{{ asset('uploads/avatar/'.$proxima->mentor->avatar) }}" class="card-img-top img-prox-events" alt="...">
                              @else
                                 <img src="{{ asset('uploads/images/miniatura/'.$proxima->miniatura) }}" class="card-img-top img-prox-events" alt="...">
                              @endif
                              <div class="card-img-overlay d-flex flex-column" style="margin-left: 10px; margin-right: 10px;">
                                  <div class="mt-auto">
                                 <form action="{{route('timelive')}}" method="GET">
                                    @csrf
                                    <input id="sigEvent" name="sigEvent" type="hidden" value="{{ $proxima->id }}">
                                    <button class="btn text-left" type="submit" style=" color: #CF202F;"><h2 class="streaming">{{$proxima->title}}</h2></button>
                                 </form>

                                 <p class="card-text font-weight-bold mr-2" style="margin-top: -10px; font-size: 12px;">   <i class="far fa-calendar mr-2" style="font-size: 18px !important;padding: 5px;"> </i>
                                    {{\Carbon\Carbon::parse($proxima->date)->formatLocalized(' %d de %B')}}
                                    <i class="far fa-clock ml-2" style="font-size: 18px !important;padding: 5px;" aria-hidden="true"></i>{{\Carbon\Carbon::parse($proxima->time)->format('g:i a')}}
                                 </p>
                                 @if (Auth::guest())
                                    {{-- USUARIOS INVITADOS --}}
                                    <a href="{{route('shopping-cart.membership')}}" class="btn btn-danger btn-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al Carrito</a>
                                 @else
                                    @if (is_null(Auth::user()->membership_id))
                                       {{-- USUARIOS LOGUEADOS SIN MEMBRESÍA --}}
                                       <a href="{{route('shopping-cart.membership')}}" class="btn btn-danger"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al Carrito</a>
                                    @else
                                       @if (Auth::user()->membership_status == 1)
                                          @if (!in_array($proxima->id, $misEventosArray))
                                             @if (Auth::user()->streamings < Auth::user()->membership->streamings)
                                                {{-- USUARIOS LOGUEADOS CON MEMBRESÍA MAYOR O IGUAL A LA SUBCATEGORÍA DEL EVENTO Y QUE NO TIENEN EL EVENTO AGENDADO AÚN--}}
                                                <a href="{{route('schedule.event', [$proxima->id])}}" class="btn btn-danger btn-block">Agendar</a>
                                             @else
                                                @if (Auth::user()->membership_id < 4)
                                                   <a href="{{route('shopping-cart.store', [Auth::user()->membership_id+1, 'membresia', 'Mensual'])}}" class="btn btn-warning"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Aumentar Membresía</a>
                                                @else
                                                   <i class="fa fa-times text-danger" aria-hidden="true"></i> <span class="text-danger"> Límite de Eventos Superado</span>
                                                @endif
                                             @endif
                                          @else
                                             {{-- EL USUARIO YA TIENE EL EVENTO AGENDADO--}}
                                             <a href="{{ route('timeliveEvent', $proxima->id) }}" class="btn btn-danger btn-block">Ir Al Evento</a>
                                          @endif
                                       @else
                                          <a href="{{route('shopping-cart.store', [Auth::user()->membership_id, 'membresia', 'Mensual'])}}" class="btn btn-danger"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Renovar Membresía</a>
                                       @endif
                                    @endif
                                 @endif
                                 </div>
                              </div>
                           </div>

                           <!--<div class="col-md-4" style="margin-top: 20px;">
                              <img src="{{ asset('uploads/avatar/'.$proxima->avatar) }}" class="card-img-top" alt="...">
                              <div class="card-img-overlay" style="margin-left: 10px; margin-right: 10px;">
                                 <h4 class="card-title" style="margin-top: 180px; color: #CF202F;">{{$proxima->title}}</h4>
                                 <p class="card-text" style="margin-top: -10px; font-size: 10px;">
                                    <i class="far fa-calendar" style="font-size: 18px;"></i> {{$proxima->fecha}}
                                    <i class="far fa-clock" style="font-size: 18px;margin-right: 5px;"></i>{{\Carbon\Carbon::parse($proxima->date)->format('g:i a')}}
                                 </p>
                                 <a href="{{route('transmi-agendar', $proxima->id)}}" class="btn btn-danger btn-block">Agendar</a>
                              </div>
                           </div>-->
                        @endif
                     @endforeach
                  </div>
               </div>

               @if($total >= 4)
                  <div class="carousel-item">
                     <div class="row">
                        @php $segundo =0; @endphp
                        @foreach($proximos as $proxima)
                           @php $segundo++; @endphp
                           @if($segundo >= 4)
                              <div class="col-md-4" style="margin-top: 20px;">
                                  @if ($proxima->cover == null)
                                  <img src="{{ asset('uploads/avatar/'.$proxima->mentor->avatar) }}" class="card-img-top img-prox-events" alt="...">
                                 @else
                                  <img src="{{ asset('uploads/images/miniatura/'.$proxima->cover) }}" class="card-img-top img-prox-events" alt="...">
                                 @endif
                                 <div class="card-img-overlay" style="margin-left: 10px; margin-right: 10px;">
                                    <h5 class="card-title font-weight-bold" style="margin-top: 170px; color: #CF202F;">{{$proxima->title}}</h5>
                                    <p class="card-text font-weight-bold mr-2" style="margin-top: -10px; font-size: 12px;">
                                       <i class="far fa-calendar mr-2" style="font-size: 18px;"> </i>
                                       {{\Carbon\Carbon::parse($evento_actual->date)->formatLocalized('%A %d de %B')}}
                                       <i class="far fa-clock ml-2" style="font-size: 18px;"></i>{{\Carbon\Carbon::parse($proxima->time)->format('g:i a')}}
                                    </p>
                                    @if (Auth::guest())
                                       {{-- USUARIOS INVITADOS --}}
                                       <a href="{{route('shopping-cart.membership')}}" class="btn btn-danger"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al Carrito</a>
                                    @else
                                       @if (is_null(Auth::user()->membership_id))
                                          {{-- USUARIOS LOGUEADOS SIN MEMBRESÍA --}}
                                          <a href="{{route('shopping-cart.membership')}}" class="btn btn-danger"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al Carrito</a>
                                       @else
                                          @if (Auth::user()->membership_status == 1)
                                             @if (!in_array($proxima->id, $misEventosArray))
                                                @if (Auth::user()->streamings < Auth::user()->membership->streamings)
                                                   {{-- USUARIOS LOGUEADOS CON MEMBRESÍA MAYOR O IGUAL A LA SUBCATEGORÍA DEL EVENTO Y QUE NO TIENEN EL EVENTO AGENDADO AÚN--}}
                                                   <a href="{{route('schedule.event', [$proxima->id])}}" class="btn btn-danger btn-block">Agendar</a>
                                                @else
                                                   @if (Auth::user()->membership_id < 4)
                                                      <a href="{{route('shopping-cart.store', [Auth::user()->membership_id+1, 'membresia', 'Mensual'])}}" class="btn btn-warning"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Aumentar Membresía</a>
                                                   @else
                                                      <i class="fa fa-times" aria-hidden="true"></i> Límite de Eventos Superado
                                                   @endif
                                                @endif
                                             @else
                                                {{-- EL USUARIO YA TIENE EL EVENTO AGENDADO--}}
                                                <a href="{{ route('timeliveEvent', $proxima->id) }}" class="btn btn-danger btn-block">Ir Al Evento</a>
                                             @endif
                                          @else
                                             <a href="{{route('shopping-cart.store', [Auth::user()->membership_id, 'membresia', 'Mensual'])}}" class="btn btn-danger"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Renovar Membresía</a>
                                          @endif
                                       @endif
                                    @endif
                                 </div>
                              </div>
                           @endif
                        @endforeach
                     </div>
                  </div>
               @endif
            </div>

            @if($total >= 3)
               <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
               </a>
               <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
               </a>
            @endif
         </div>
      @else
         <!--<div class="row">No se encontraron próximas transmisiones...</div>-->
      @endif
   </div>
   @endif
   <div class="section-landing" style="background: linear-gradient(to bottom, #222326 50%, #1C1D21 50.1%);">
      <div class="col">
         <div class="section-title-landing" style="padding-bottom: 35px; text-align:center;">TRANSMISIONES RECIENTES</div>
      </div>

        {{--<div class="form-row">

       <div class="col-md-2" style="font-size: 20px;">
        <label>ORDENAR POR:</label>
        </div>

        <div class="col-md-3">
        <select name="tipo" class="form-control" required style="height: calc(1.9em + .100rem + 2px); width: 80%; border: none; background-color: #1a1b1d; color: #CF202F; font-size: 16px; font-weight: bold;
">
            <option value="1">MÁS VISTOS</option>
        </select>
        </div>

    </div>--}}

      <div class="row">
         @if($finalizados->isNotEmpty())
            @foreach($finalizados as $fin)
               <div class="col-md-4" style="margin-top: 20px;">
                    <div class="card">
                        <a href="" style="color: white;" class="position-relative">
                            @if($fin->cover == null)
                                <img src="{{ asset('uploads/images/miniatura/'.$fin->miniatura) }}" class="card-img-top new-course-img" alt="..." >
                            @else
                                <img src="{{ asset('uploads/images/miniatura/'.$fin->cover) }}" class="card-img-top new-course-img" alt="..." >
                            @endif
                            <div class="card-img-overlay d-flex flex-column reciente-mentor-name">
                                
                                <div class="mt-auto">
                                    <div class="text-sm text-white" style="line-height:1;">
                                        <div class="row">
                                            <div class="col-md-10">
                                               <h6 class="card-title">{{$fin->mentor->display_name}}</h6>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                          </a>
                    </div><!--CARD IMG-->
                    <!--<div class="card-img-overlay reciente-mentor-name">
                        <h6 class="card-title">{{$fin->mentor->display_name}}</h6>
                    </div>-->
                    <div class="card-body" style="background-color: #2f343a;">
                        <h6 class="card-title" style="margin-top: -15px;"><img src="{{ asset('images/icons/play-button.svg') }}" alt="" height="25px" width="25px">  {{$fin->title}}</h6>
                        <h6 style="font-size: 10px; margin-left: 40px; margin-top: -10px;">{{$fin->category->title}}</h6>
                    </div>
               </div>
            @endforeach
         @else
            <div class="row"></div>
         @endif
      </div>
   </div>
   <div class="">
        <div class="container-fluid">
            <div class="col section-title-category">
                <h1>
                    CATEGORÍA
                </h1>
            </div>

            <div class="row">
                @foreach ($events_category as $event)
                        <div class="col-sm-4 d-inline-flex p-2">
                            @if (!is_null($event->cover))
                                <img src="{{ asset('uploads/images/categories/covers/'.$event->cover) }}" class="card-img-top img-fluid event-category " alt="...">
                            @else
                                <img src="{{ asset('uploads/images/categories/covers/default.jpg') }}" class="card-img-top img-fluid event-category " alt="...">
                            @endif
                            <div class="course-category-caption ml-1 mr-1">
                                <div class="col-sm-lg text-sm-left font-weight-bold">
                                    <a href="{{ url('events/category/'.$event->id) }}" class="col-sm-lg text-sm-left  text-danger">{{$event->title}}</a>
                                </div>
                                <div class="col-lg">
                                    <h4 class="text-secondary font-weight-bold">{{$event->events_count}} Eventos</h4>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </div>

     <div class="modal fade" id="visitante-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel" style="color:white;">REGÍSTRATE AHORA</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-white pl-5 pr-5 text-center">
                    Te encuentras en modo visitante.<br>
                    Para disfrutar de nuestro contenido a precio preferencial ingresa en este botón.
                    <br><br>
                    <a type="button" class="btn btn-primary btn-register-header" href="{{ route('log').'?act=1' }}">REGISTRO</a>
                </div>
            </div>
        </div>
    </div>

@endsection
