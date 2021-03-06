@extends('layouts.landing')

@section('content')
  @if (!Auth::guest())
    <div class="title-page-course col-md"><span class="text-white">
        <h3 class="mb-4"><span class="text-white">Hola</span><span class="text-danger"> {{Auth::user()->display_name}}</span><span class="text-white"> ¡Nos alegra verte hoy!</span></h3>
    </div>
  @endif

  <div class="container-fluid courses-slider" style="background-color: #1C1D21;margin-bottom: 0px; padding-bottom: 0px;">
      <div class="container-fluid courses-slider" style="padding-bottom: 0px;">
        <div id="mainSlider" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
              <div class="carousel-item  active ">
                <div class="overlay"></div>
                    <img src="{{ asset('images/streaming-1.jpg') }}" class="d-block w-100" alt="...">
                     <div class="carousel-caption">
                      <div class="col-md-5 offset-md-4">
                      <div class="estilostreaming">STREAMING</div>
                      <div class="estilostreamingtwo">Disfruta de <b> Sesiones en vivo <b></div>
                    </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div><!--BANNER END-->

   <div class="container-fluid" style="background-color: #1C1D21;">
      <div class="row mt-4 mb-2">
         <div class="col-md-4">
            <img src="{{ asset('images/fxtfotohome.png') }}" class="img-fluid" alt="...">
            <div class="text-center">
               <!--<h3 class="text-primary font-weight-bold ftxlivestreming-text">FTX LIVE</h3>-->
               <img src="{{ asset('images/FTXlive-logo.png') }}" class="img-fluid" alt="...">
               <h6 class="text-white mt-2">
                  El usuario podrá disfrutar, sin importar el lugar en donde se encuentre, con su ordenador o su cel, desde presentaciones de negocios, hasta capacitaciones de todo tipo en vivo, lanzamientos y más.
               </h6>
            </div>
         </div>
         <div class="col-md-4">
            <img src="{{ asset('images/fxtmodif.png') }}" class="img-fluid" alt="...">
            <div class="text-center">
               <h3 class="text-danger font-weight-bold ftxlivestreming-text">FTX LIVESTREAMING</h3>
               <h6 class="text-white mt-2">
                  Un espacio de entrenamientos en vivo para emprendedores, su propuesta de valor se distingue por ofrecer: Información de primer nivel y en tiempo real, así como motivación para aprender de forma sencilla y herramientas precisas para que se ponga en practica el conocimiento adquirido en los streaming de forma inmediata.
               </h6>
            </div>
         </div>
         <div class="col-md-4">
            <img src="{{ asset('images/ftxliveacceso.png') }}" class="img-fluid" alt="...">
            <div class="text-center">
               <h3 class="text-danger font-weight-bold ftxlivestreming-text">ACCESO</h3>
               <h6 class="text-white mt-2">
                  El acceso será exclusivo para las personas que sean socios de FTXLive y tengan un login de acceso. Dentro de las principales ventajas de este canal, es su fácil acceso, su increíble diseño, así como su chat interactivo, el cual permitirá tener vinculación inmediata y más cercana a la red, ya que la inmediatez y naturalidad en que son transmitidos los enlaces, permitirá a los espectadores participar, haciendo preguntas acerca del contenido que se este explorando, pudiendo aclarar sus dudas de manera inmediata.
               </h6>
            </div>
         </div>
      </div>
   </div>

   @if(!empty($evento_actual))
      <div style="width: 100%; position: relative; display: inline-block;">
         <img src="{{ asset('uploads/images/banner/'.$evento_actual->image) }}" alt="" style="height: 500px; width:100%; opacity: 0.5;">
         <div style="position: absolute; top: 2%; left: 5%;">
            <div style="color: white; font-size: 70px; font-weight: bold;">
               <a style="font-weight: bold; width: 180px; font-size: 28px; color: #CF202F;">PRÓXIMO STREAMING</a><br>
               <div style="width: 60%; line-height: 70px;">
                  <a href="{{ route('timelive')}}" class="text-white">{{$evento_actual->title}}</a>
               </div>
             <div class="next-streaming-date">
                    <i class="fa fa-calendar"></i> {{\Carbon\Carbon::parse($evento_actual->date)->formatLocalized(' %d de %B')}}
                    <i class="fa fa-clock" style="padding-left: 20px;"></i>{{\Carbon\Carbon::parse($evento_actual->time)->format('g:i a')}}
                </div>
               <div style="font-size: 35px; padding-top: 60px;">
                  @if (Auth::guest())
                     {{-- USUARIOS INVITADOS --}}
                     <a href="{{route('shopping-cart.membership')}}" class="btn btn-secondary" ><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADQUIRIR MEMBRESÍA</a>
                  @else
                     @if (is_null(Auth::user()->membership_id))
                        {{-- USUARIOS LOGUEADOS SIN MEMBRESÍA  --}}
                        <a href="{{route('shopping-cart.membership')}}" class="btn btn-secondary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> ADQUIRIR MEMBRESÍA</a>
                     @else
                        @if (Auth::user()->membership_status == 1)
                           @if (!in_array($evento_actual->id, $misEventosArray))
                              @if (Auth::user()->streamings < Auth::user()->membership->streamings)
                                 {{-- USUARIOS LOGUEADOS CON STREAMINGS DISPONIBLES Y QUE NO TIENEN EL EVENTO AGENDADO AÚN--}}
                                 <a href="{{ route('schedule.event', [$evento_actual->id]) }}" class="btn btn-secondary"><i class="fas fa-chevron-right"></i> RESERVAR PLAZA </a>
                              @else
                                 @if (Auth::user()->membership_id < 4)
                                    <a href="{{route('shopping-cart.store', [Auth::user()->membership_id+1, 'membresia', 'Mensual'])}}" class="btn btn-warning"><i class="fa fa-shopping-cart" aria-hidden="true"></i> AUMENTAR MEMBRESÍA</a>
                                 @else
                                    <i class="fa fa-times" aria-hidden="true"></i> Límite de Eventos Superado
                                 @endif
                              @endif
                           @else
                              <a href="{{ route('timeliveEvent', $evento_actual->id) }}" class="btn btn-secondary">Ir al Evento<i class="fas fa-chevron-right"></i></a>
                           @endif
                        @else
                           <a href="{{route('shopping-cart.store', [Auth::user()->membership_id, 'membresia', 'Mensual'])}}" class="btn btn-secondary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Renovar Membresía</a>
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

   @if (!Auth::guest() && $total > 0)
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
                                    <a href="{{route('shopping-cart.membership')}}" class="btn btn-secondary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al Carrito</a>
                                 @else
                                    @if (is_null(Auth::user()->membership_id))
                                       {{-- USUARIOS LOGUEADOS SIN MEMBRESÍA --}}
                                       <a href="{{route('shopping-cart.membership')}}" class="btn btn-secondary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al Carrito</a>
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
                                             <a href="{{ route('timeliveEvent', $proxima->id) }}" class="btn btn-secondary btn-block">Ir Al Evento</a>
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
                                  @if ($proxima->miniatura == null)
                                  <img src="{{ asset('uploads/avatar/'.$proxima->mentor->avatar) }}" class="card-img-top img-prox-events" alt="...">
                                 @else
                                  <img src="{{ asset('uploads/images/miniatura/'.$proxima->miniatura) }}" class="card-img-top img-prox-events" alt="...">
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
                                       <a href="{{route('shopping-cart.membership')}}" class="btn btn-secondary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al Carrito</a>
                                    @else
                                       @if (is_null(Auth::user()->membership_id))
                                          {{-- USUARIOS LOGUEADOS SIN MEMBRESÍA --}}
                                          <a href="{{route('shopping-cart.membership')}}" class="btn btn-secondary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al Carrito</a>
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
                                                <a href="{{ route('timeliveEvent', $proxima->id) }}" class="btn btn-secondary btn-block">Ir Al Evento</a>
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
               <div class="col-md-3" style="margin-top: 20px;">
                   @if($fin->miniatura == null)
                    <img src="{{ asset('uploads/avatar/'.$fin->mentor->avatar) }}" class="card-img-top" alt="..." >
                   @else
                     <img src="{{ asset('uploads/images/miniatura/'.$fin->miniatura) }}" class="card-img-top" alt="..." >
                   @endif
                  <div class="card-img-overlay" style="margin-left: 10px; margin-right: 10px;">
                     <h6 class="card-title">{{$fin->mentor->display_name}}</h6>
                  </div>

                  <div class="card-body" style="background-color: #2f343a;">
                     <h6 class="card-title" style="margin-top: -15px;">  {{$fin->title}}</h6>
                     <h6 style="font-size: 10px; margin-left: 20px; margin-top: -10px;">{{$fin->category->title}}</h6>
                  </div>
               </div>
            @endforeach
         @else
            <div class="row"></div>
         @endif
      </div>
   </div>
@endsection
