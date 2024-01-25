@if (Session::has('admin'))
    @php
        $role = 'admin';
    @endphp
@elseif (Session::has('digitador'))
    @php
        $role = 'digitador';
    @endphp
@elseif (Session::has('observador'))
    @php
        $role = 'observador';
    @endphp
@elseif (Session::has('supervisor'))
    @php
        $role = 'supervisor';
    @endphp
@endif

@extends('admin.panel')

@section('contenido')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-3"></div>
                        <div class="col-6">
                            @if (Session::has('exitoIniciativa'))
                                <div class="alert alert-success alert-dismissible show fade mb-4 text-center">
                                    <div class="alert-body">
                                        <strong>{{ Session::get('exitoIniciativa') }}</strong>
                                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-6">
                            @if (Session::has('errorIniciativa'))
                                <div class="alert alert-danger alert-dismissible show fade mb-4 text-center">
                                    <div class="alert-body">
                                        <strong>{{ Session::get('errorIniciativa') }}</strong>
                                        <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-3"></div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Listado de Iniciativas</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route($role . '.iniciativa.listar') }}" method="GET">
                                <div class="row align-items-end">
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-2 mb-sm-0">
                                        <div class="form-group">
                                            <label>Filtrar por Mecanismo</label>
                                            <select class="form-control select2" id="mecanismo" name="mecanismo"
                                                onchange="filtrarTablaxMecanismo()">
                                                <option value="" selected>TODOS</option>
                                                @forelse ($mecanismos as $mecanismo)
                                                    <option value="{{ $mecanismo->meca_nombre }}"
                                                        {{ Request::get('mecanismo') == $mecanismo->meca_nombre ? 'selected' : '' }}>
                                                        {{ $mecanismo->meca_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label>Filtrar por Estado</label>
                                            <select class="form-control select2" id="filtro1" name="filtro1"
                                                onchange="filtrarTablaxMecanismo()">
                                                <option value="" selected>TODOS</option>
                                                <option value="1">En revisión</option>
                                                <option value="2">En ejecución</option>
                                                <option value="3">Aceptada</option>
                                                <option value="4">Falta info</option>
                                                <option value="5">Cerrada</option>
                                                <option value="6">Finalizada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 mb-2 mb-sm-0">
                                        <div class="form-group">
                                            <label>Filtrar por Año</label>
                                            <select class="form-control select2" id="ano" name="ano"
                                                onchange="filtrarTablaxMecanismo()">
                                                <option value="" selected>TODOS</option>
                                                @forelse ($anhos as $ann)
                                                    <option value="{{ $ann->inic_anho }}"
                                                        {{ Request::get('mecanismo') == $ann->inic_anho ? 'selected' : '' }}>
                                                        {{ $ann->inic_anho }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="mb-4">
                                            <a href="{{ route($role . '.iniciativa.listar') }}" type="button"
                                                class="btn btn-primary mr-1 waves-effect"><i class="fas fa-broom"></i>
                                                Limpiar</a>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>

                                            <th>Nombre</th>
                                            <th>Mecanismo</th>
                                            <th>Año</th>
                                            {{-- <th>Escuelas</th> --}}
                                            <th>Institutos</th>
                                            <th>Estado</th>
                                            <th>Fecha de creación</th>
                                            <th style="width: 250px">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-iniciativas">
                                        @foreach ($iniciativas as $iniciativa)
                                            <tr data-meca="{{ $iniciativa->meca_nombre }}"
                                                data-ano="{{ $iniciativa->inic_anho }}"
                                                data-filtro1="{{ $iniciativa->inic_estado }}">
                                                <td>{{ $iniciativa->inic_nombre }}</td>
                                                <td>{{ $iniciativa->meca_nombre }}</td>
                                                <td>{{ $iniciativa->inic_anho }}</td>
                                                {{-- <td>
                                                    @php
                                                        $escuelasArray = explode(',', $iniciativa->escuelas);
                                                    @endphp
                                                    @if (count($escuelasArray) > 3)
                                                        Todas
                                                    @else
                                                        {{ $iniciativa->escuelas }}
                                                    @endif
                                                </td> --}}
                                                {{-- <td>{{ $iniciativa->carreras }}</td> --}}
                                                <td>
                                                    @php
                                                        $carrerasArray = explode(',', $iniciativa->carreras);
                                                    @endphp
                                                    @if (count($carrerasArray) > 29)
                                                        Todos
                                                    @else
                                                        {{ $iniciativa->carreras }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $estadoBadges = [
                                                            1 => ['class' => 'light', 'icon' => 'history', 'text' => 'En revisión'],
                                                            2 => ['class' => 'info', 'icon' => 'play-circle', 'text' => 'En ejecución'],
                                                            3 => ['class' => 'success', 'icon' => 'lock', 'text' => 'Aceptada'],
                                                            4 => ['class' => 'info', 'icon' => 'info-circle', 'text' => 'Falta info'],
                                                            5 => ['class' => 'primary', 'icon' => 'pause-circle', 'text' => 'Cerrada'],
                                                            6 => ['class' => 'success', 'icon' => 'check-double', 'text' => 'Finalizada'],
                                                        ];
                                                    @endphp

                                                    <div
                                                        class="badge badge-{{ $estadoBadges[$iniciativa->inic_estado]['class'] }} badge-shadow">
                                                        <i
                                                            class="fas fa-{{ $estadoBadges[$iniciativa->inic_estado]['icon'] }}"></i>
                                                        {{ $estadoBadges[$iniciativa->inic_estado]['text'] }}
                                                    </div>
                                                </td>
                                                <td>{{ $iniciativa->inic_creado }}</td>
                                                <td>
                                                    <div class="dropdown d-inline">
                                                        <button class="btn btn-primary dropdown-toggle"
                                                            id="dropdownMenuButton2" data-toggle="dropdown"title="Opciones">
                                                            <i class="fas fa-cog"></i> </button>
                                                        <div class="dropdown-menu dropright">
                                                            {{-- <a href="{{ route($role . '.evaluar.iniciativa', $iniciativa->inic_codigo) }}"
                                                                class="dropdown-item has-icon"><i
                                                                    class="fas fa-user-edit"></i>Evaluar Iniciativa</a> --}}
                                                            <a href="{{ route($role . '.editar.paso1', $iniciativa->inic_codigo) }}"
                                                                class="dropdown-item has-icon"><i
                                                                    class="fas fa-edit"></i>Editar Iniciativa</a>
                                                            <a href="javascript:void(0)" class="dropdown-item has-icon"
                                                                onclick="eliminarIniciativa({{ $iniciativa->inic_codigo }})"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Eliminar">Eliminar Iniciativa<i
                                                                    class="fas fa-trash"></i></a>

                                                            <a href="{{ route($role . '.iniciativas.detalles', $iniciativa->inic_codigo) }}"
                                                                class="dropdown-item has-icon" data-toggle="tooltip"
                                                                data-placement="top" title="Ver detalles"><i
                                                                    class="fas fa-eye"></i>Ver detalles</a>
                                                            <a href="{{ route($role . '.evidencias.listar', $iniciativa->inic_codigo) }}"
                                                                class="dropdown-item has-icon" data-toggle="tooltip"
                                                                data-placement="top" title="Adjuntar evidencia"><i
                                                                    class="fas fa-paperclip"></i>Adjuntar evidencia</a>
                                                        </div>
                                                    </div>

                                                    <div class="dropdown d-inline">
                                                        <button class="btn btn-primary dropdown-toggle"
                                                        id="dropdownMenuButton2" data-toggle="dropdown" title="Ingresar">
                                                        <i class="fas fa-plus-circle"></i> Ingresar
                                                        </button>
                                                        <div class="dropdown-menu dropright">
                                                            <a href="{{ route($role . '.cobertura.index', $iniciativa->inic_codigo) }}"
                                                                class="dropdown-item has-icon" data-toggle="tooltip"
                                                                data-placement="top" title="Ingresar cobertura"><i
                                                                    class="fas fa-users"></i> Ingresar cobertura</a>
                                                            <a href="{{ route($role . '.resultados.listado', $iniciativa->inic_codigo) }}"
                                                                class="dropdown-item has-icon" data-toggle="tooltip"
                                                                data-placement="top" title="Ingresar resultado"><i
                                                                    class="fas fa-flag"></i> Ingresar resultado</a>
                                                        </div>
                                                    </div>

                                                    {{-- <a href="" class="btn btn-icon btn-success" data-toggle="tooltip"
                                                        data-placement="top" title="Ingresar resultado"><i
                                                            class="fas fa-flag"></i></a>

                                                    <a href="" class="btn btn-icon btn-success" data-toggle="tooltip"
                                                        data-placement="top" title="Evaluar iniciativa"><i
                                                            class="fas fa-file-signature"></i></a> --}}

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modalEliminaIniciativa" tabindex="-1" role="dialog" aria-labelledby="modalEliminar"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route($role . '.iniciativa.eliminar') }} " method="POST">
                    @method('DELETE')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEliminar">Eliminar Iniciativa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fas fa-ban text-danger" style="font-size: 50px; color"></i>
                        <h6 class="mt-2">La iniciativa dejará de existir dentro del sistema. <br> ¿Desea continuar de
                            todos
                            modos?</h6>
                        <input type="hidden" id="inic_codigo" name="inic_codigo" value="">
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-primary">Continuar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
