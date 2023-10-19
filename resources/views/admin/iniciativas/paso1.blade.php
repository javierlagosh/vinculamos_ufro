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
    <section class="section" style="font-size: 115%;">
        <div class="section-body">

            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    @if (Session::has('errorPaso1'))
                        <div class="alert alert-danger alert-dismissible show fade mb-4 text-center">
                            <div class="alert-body">
                                <strong>{{ Session::get('errorPaso1') }}</strong>
                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Sección 1 - Antecedentes generales</h4>
                            @if (isset($iniciativa) && $editar)
                                <div class="card-header-action">
                                    <div class="dropdown d-inline">
                                        <a href="{{ route('admin.iniciativas.detalles', $iniciativa->inic_codigo) }}"
                                            class="btn btn-icon btn-warning icon-left" data-toggle="tooltip"
                                            data-placement="top" title="Ver detalles de la iniciativa"><i
                                                class="fas fa-eye"></i>Ver detalle</a>

                                        {{-- <a href="{{ route('admin.editar.paso1', $iniciativa->inic_codigo) }}"
                                            class="btn btn-icon btn-primary icon-left" data-toggle="tooltip"
                                            data-placement="top" title="Editar iniciativa"><i
                                                class="fas fa-edit"></i>Editar Iniciativa</a> --}}

                                        {{-- <a href="javascript:void(0)" class="btn btn-icon btn-info icon-left"
                                            data-toggle="tooltip" data-placement="top" title="Calcular INVI"
                                            onclick="calcularIndice({{ $iniciativa->inic_codigo }})"><i
                                                class="fas fa-tachometer-alt"></i>INVI</a> --}}

                                        <a href="{{ route('admin.evidencias.listar', $iniciativa->inic_codigo) }}"
                                            class="btn btn-icon btn-success icon-left" data-toggle="tooltip"
                                            data-placement="top" title="Adjuntar evidencia"><i
                                                class="fas fa-paperclip"></i>Evidencias</a>

                                        <a href="{{ route('admin.cobertura.index', $iniciativa->inic_codigo) }}"
                                            class="btn btn-icon btn-success icon-left" data-toggle="tooltip" data-placement="top"
                                            title="Ingresar cobertura"><i class="fas fa-users"></i>Cobertura</a>

                                        <a href="{{ route('admin.resultados.listado', $iniciativa->inic_codigo) }}"
                                            class="btn btn-icon btn-success icon-left" data-toggle="tooltip"
                                            data-placement="top" title="Ingresar resultado"><i
                                                class="fas fa-flag"></i>Resultado/s</a>

                                        {{-- <a href="{{ route($role . '.evaluar.iniciativa', $iniciativa->inic_codigo) }}"
                                            class="btn btn-icon btn-success icon-left" data-toggle="tooltip"
                                            data-placement="top" title="Evaluar iniciativa"><i
                                                class="fas fa-file-signature"></i>Evaluar</a> --}}

                                        <a href="{{ route('admin.iniciativa.listar') }}"
                                            class="btn btn-primary mr-1 waves-effect icon-left" type="button">
                                            <i class="fas fa-angle-left"></i> Volver a listado
                                        </a>
                                    </div>
                                </div>
                                @endif
                        </div>
                        <div class="card-body">
                            @if (isset($iniciativa) && $editar)
                                <form action="{{ route('admin.actualizar.paso1', $iniciativa->inic_codigo) }}"
                                    method="POST">
                                    @method('PUT')
                                    @csrf
                                    @else
                                    <form action="{{ route($role . '.paso1.verificar') }}" method="POST">
                                        @csrf
                            @endif
                            <div class="row">
                                <div class="col-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label style="font-size: 110%">Nombre de iniciativa</label> <label for=""
                                            style="color: red;">*</label>
                                        @if (isset($iniciativa) && $editar)
                                            <input type="text" class="form-control" id="nombre" name="nombre"
                                                value="{{ old('nombre') ?? @$iniciativa->inic_nombre }}">
                                        @else
                                            <input type="text" class="form-control" id="nombre" name="nombre"
                                                value="{{ old('nombre') }}">
                                        @endif
                                        @if ($errors->has('nombre'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <button class="close"
                                                        data-dismiss="alert"><span>&times;</span></button>
                                                    <strong>{{ $errors->first('nombre') }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3 col-md-3 col-lg-3">
                                    <div class="form-group">
                                        <label style="font-size: 110%">Año</label> <label for=""
                                            style="color: red;">*</label>
                                        <select class="form-control select2" id="anho" name="anho">
                                            <option disabled selected>Seleccione...</option>
                                            @php
                                                $selectedYear = isset($iniciativa) && $editar ? $iniciativa->inic_anho : old('anho');
                                                $currentYear = date('Y');
                                            @endphp
                                            @for ($year = 2018; $year <= $currentYear; $year++)
                                                <option value="{{ $year }}"
                                                    {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}
                                                </option>
                                            @endfor
                                        </select>

                                        @if ($errors->has('anho'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <button class="close"
                                                        data-dismiss="alert"><span>&times;</span></button>
                                                    <strong>{{ $errors->first('anho') }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-3 col-md-3 col-lg-3">

                                    <div class="form-group">
                                        <label style="font-size: 110%">Formato de implementación</label> <label
                                            for="" style="color: red;">*</label>

                                        <select class="form-control select2" id="inic_formato" name="inic_formato">
                                            <option disabled selected>Seleccione...</option>
                                            @if (isset($iniciativa) && $editar)
                                                <option value="Presencial"
                                                    {{ $iniciativa->inic_formato == 'Presencial' ? 'selected' : '' }}>
                                                    Presencial
                                                </option>
                                                <option value="Online"
                                                    {{ $iniciativa->inic_formato == 'Online' ? 'selected' : '' }}>Online
                                                </option>
                                                <option value="Mixto"
                                                    {{ $iniciativa->inic_formato == 'Mixto' ? 'selected' : '' }}>Mixto
                                                </option>
                                            @else
                                                <option value="Presencial" {{ old('formato') == '1' ? 'selected' : '' }}>
                                                    Presencial
                                                </option>
                                                <option value="Online" {{ old('formato') == '2' ? 'selected' : '' }}>Online
                                                </option>
                                                <option value="Mixto" {{ old('formato') == '3' ? 'selected' : '' }}>Mixto
                                                </option>
                                            @endif
                                        </select>
                                        @if ($errors->has('inic_formato'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <button class="close"
                                                        data-dismiss="alert"><span>&times;</span></button>
                                                    <strong>{{ $errors->first('inic_formato') }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                </div>

                            </div>
                            <div class="">
                                <div class="form-group">
                                    <label style="font-size: 110%">Descripción</label> <label for=""
                                        style="color: red;">*</label>
                                    <div class="input-group">
                                        @if (isset($iniciativa) && $editar)
                                            <textarea class="formbold-form-input" id="description" name="description" rows="5" style="width: 100%;">{{ old('description') ?? @$iniciativa->inic_descripcion }}</textarea>
                                        @else
                                            <textarea class="formbold-form-input" id="description" name="description" rows="5" style="width: 100%;">{{ old('description') }}</textarea>
                                        @endif
                                    </div>
                                    @if ($errors->has('description'))
                                        <div class="alert alert-warning alert-dismissible show fade mt-2">
                                            <div class="alert-body">
                                                <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size: 110%">Escuelas</label> <label for=""
                                            style="color: red;">*</label>
                                        <input type="checkbox" id="selectAllEscuelas" style="margin-left: 60%"> <label
                                            for="selectAllEscuelas">Todas</label>
                                        <select class="form-control select2" name="escuelas[]" multiple=""
                                            style="width: 100%" id="escuelas">
                                            @if (isset($iniciativa) && $editar)
                                                @forelse ($escuelas as $escuela)
                                                    <option value="{{ $escuela->escu_codigo }}"
                                                        {{ in_array($escuela->escu_codigo, old('escuelas', [])) || in_array($escuela->escu_codigo, $escuSec) ? 'selected' : '' }}>
                                                        {{ $escuela->escu_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            @else
                                                @forelse ($escuelas as $escuela)
                                                    <option value="{{ $escuela->escu_codigo }}"
                                                        {{ collect(old('escuela'))->contains($escuela->escu_codigo) ? 'selected' : '' }}>
                                                        {{ $escuela->escu_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            @endif
                                        </select>
                                        @if ($errors->has('escuelas'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <button class="close"
                                                        data-dismiss="alert"><span>&times;</span></button>
                                                    <strong>{{ $errors->first('escuelas') }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label style="font-size: 110%">Carreras</label> <label for=""
                                            style="color: red;">*</label><input type="checkbox" id="selectAllCarreras"
                                            style="margin-left: 60%"> <label for="selectAllCarreras">Todas</label>

                                        <select class="form-control select2" multiple="" id="carreras"
                                            name="carreras[]" style="width: 100%">
                                            @if (isset($iniciativa) && $editar)
                                                estoy aca
                                                {{-- <select class="form-control select2" name="sedes[]" multiple id="sedes"> --}}
                                                @forelse ($carreras as $carrera)
                                                    <option value="{{ $carrera->care_codigo }}"
                                                        {{ in_array($carrera->care_codigo, old('carreras', [])) || in_array($carrera->care_codigo, $careSec) ? 'selected' : '' }}>
                                                        {{ $carrera->care_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            @else
                                                {{-- <select class="form-control select2" name="sedes[]" multiple id="sedes"> --}}
                                                @forelse ($carreras as $carrera)
                                                    <option value="{{ $carrera->care_codigo }}"
                                                        {{ collect(old('carreras'))->contains($carrera->care_codigo) ? 'selected' : '' }}>
                                                        {{ $carrera->care_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            @endif
                                        </select>

                                        @if ($errors->has('carreras'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <button class="close"
                                                        data-dismiss="alert"><span>&times;</span></button>
                                                    <strong>{{ $errors->first('carreras') }}</strong>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>



                            </div>

                            <div class="row">
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label style="font-size: 110%">Mecanismo</label> <label for=""
                                            style="color: red;">*</label>
                                        <select class="form-control select2" id="mecanismos" name="mecanismos"
                                            style="width: 100%">
                                            <option value="" selected disabled>Seleccione...</option>
                                            @foreach ($mecanismo as $meca)
                                                @if ($editar && @isset($iniciativa))
                                                    <option value="{{ $meca->meca_codigo }}"
                                                        {{ old('mecanismo', $iniciativa->meca_codigo) == $meca->meca_codigo ? 'selected' : '' }}>
                                                        {{ $meca->meca_nombre }}</option>
                                                @else
                                                    <option value="{{ $meca->meca_codigo }}"
                                                        {{ old('mecanismo') == $meca->meca_codigo ? 'selected' : '' }}>
                                                        {{ $meca->meca_nombre }}</option>
                                                @endif
                                            @endforeach
                                        </select>


                                        @if ($errors->has('mecanismo'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <strong>{{ $errors->first('mecanismo') }}</strong>
                                                </div>
                                            </div>
                                            <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">

                                        <label style="font-size: 110%">Tipo de Actividades</label> <label for=""
                                            style="color: red;">*</label>
                                        <select class="form-control select2" id="tactividad" name="tactividad"
                                            style="width: 100%">
                                            <option value="" selected disabled>Seleccione...</option>
                                            @if (isset($iniciativaData) && $editar)
                                                @forelse ($tipoActividad as $actividad)
                                                    <option value="{{ $actividad->tiac_codigo }}"
                                                        {{ $iniciativaData->tiac_codigo == $actividad->tiac_codigo ? 'selected' : '' }}>
                                                        {{ $actividad->tiac_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            @else
                                                @forelse ($tipoActividad as $actividad)
                                                    <option value="{{ $actividad->tiac_codigo }}"
                                                        {{ old('tactividad') == $actividad->tiac_codigo ? 'selected' : '' }}>
                                                        {{ $actividad->tiac_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            @endif
                                        </select>

                                        @if ($errors->has('programas'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <strong>{{ $errors->first('tactividad') }}</strong>
                                                </div>
                                            </div>
                                            <button class="close" data-dismiss="alert"><span>&times;</span></button>
                                        @endif
                                    </div>
                                </div>


                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label style="font-size: 110%">Convenio</label> <label for=""
                                            style="color: red;">*</label>
                                        <select class="form-control select2" id="convenio" name="convenio"
                                            style="width: 100%">
                                            @if (isset($iniciativa) && $editar)
                                                <option value="" selected>No Aplica</option>
                                                @foreach ($convenios as $convenio)
                                                    <option value="{{ $convenio->conv_codigo }}"
                                                        {{ $iniciativa->conv_codigo == $convenio->conv_codigo ? 'selected' : '' }}>
                                                        {{ $convenio->conv_nombre }}</option>
                                                @endforeach
                                            @else
                                                @if (count($convenios) > 0)
                                                    <option value="" disabled selected>Seleccione...</option>
                                                    @foreach ($convenios as $convenio)
                                                        <option value="{{ $convenio->conv_codigo }}">
                                                            {{ $convenio->conv_nombre }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="-1" disabled selected>No existen registros</option>
                                                @endif

                                            @endif
                                        </select>


                                        @if ($errors->has('convenio'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <button class="close"
                                                        data-dismiss="alert"><span>&times;</span></button>
                                                    <strong>{{ $errors->first('convenio') }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group" id="regiones_div">
                                        <label style="font-size: 110%">Región</label>
                                        <input type="hidden" id="territorio" name="territorio" value="nacional">
                                        <input type="hidden" id="pais" name="pais" value="1">
                                        <select class="form-control select2" id="region" multiple=""
                                            name="region[]" style="width: 100%">
                                            @if (isset($iniciativa) && $editar)
                                                @forelse ($regiones as $region)
                                                    <option value="{{ $region->regi_codigo }}"
                                                        {{ in_array($region->regi_codigo, $iniciativaRegion) ? 'selected' : '' }}>
                                                        {{ $region->regi_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            @else
                                                @forelse ($regiones as $region)
                                                    <option value="{{ $region->regi_codigo }}"
                                                        {{ collect(old('region'))->contains($region->regi_codigo) ? 'selected' : '' }}>
                                                        {{ $region->regi_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            @endif
                                        </select>

                                        @if ($errors->has('region'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <button class="close"
                                                        data-dismiss="alert"><span>&times;</span></button>
                                                    <strong>{{ $errors->first('region') }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group" id="comunas_div">
                                        <label style="font-size: 110%">Comuna</label>
                                        <select class="form-control select2" id="comuna" name="comuna[]"
                                            multiple="" style="width: 100%">
                                            <option value="" disabled>Seleccione...</option>
                                            @if (isset($iniciativa) && $editar)
                                                @forelse ($comunas as $comuna)
                                                    <option value="{{ $comuna->comu_codigo }}"
                                                        {{ in_array($comuna->comu_codigo, $iniciativaComuna) ? 'selected' : '' }}>
                                                        {{ $comuna->comu_nombre }}</option>
                                                @empty
                                                    <option value="-1">No existen registros</option>
                                                @endforelse
                                            @else
                                                @forelse ($comunas as $comuna)
                                                    <option value="{{ $comuna->comu_codigo }}"
                                                        {{ collect(old('comuna'))->contains($comuna->comu_codigo) ? 'selected' : '' }}>
                                                        {{ $comuna->comu_nombre }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            @endif
                                        </select>

                                        @if ($errors->has('comuna'))
                                            <div class="alert alert-warning alert-dismissible show fade mt-2">
                                                <div class="alert-body">
                                                    <button class="close"
                                                        data-dismiss="alert"><span>&times;</span></button>
                                                    <strong>{{ $errors->first('comuna') }}</strong>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary mr-1 waves-effect">Siguiente <i
                                                class="fas fa-chevron-right"></i></button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            actividadesByMecanismos();
            comunasByRegiones();
            selectAllRegiones();
            selectAllComunas();
            selectAllEscuelas();
            selectAllCarreras();
            carrerasByEscuelas();
            // $('#programas').on('change', function() {
            //     selectTiposActividades();
            // });

            // // Llamada inicial
            // selectTiposActividades();
        });

        function selectAllRegiones() {
            $('#selectAllRegiones').change(function() {
                const selectAll = $(this).prop('checked');
                $('#region option').prop('selected', selectAll);
                $('#region').trigger('change');
            });
        }

        function selectAllComunas() {
            $('#selectAllComunas').change(function() {
                const selectAll = $(this).prop('checked');
                $('#comuna option').prop('selected', selectAll);
                $('#comuna').trigger('change');
            });
        }


        function selectAllCarreras() {
            $('#selectAllCarreras').change(function() {
                const selectAll = $(this).prop('checked');
                $('#carreras option').prop('selected', selectAll);
                $('#carreras').trigger('change');
            });
        }

        function selectAllEscuelas() {
            $('#selectAllEscuelas').change(function() {
                const selectAll = $(this).prop('checked');
                $('#escuelas option').prop('selected', selectAll);
                $('#escuelas').trigger('change');
            });
        }

        function actividadesByMecanismos() {
            $('#mecanismos').on('change', function() {
                console.log("first")
                $.ajax({
                    url: window.location.origin + '/admin/iniciativas/obtener-actividades',
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        _token: '{{ csrf_token() }}',
                        mecanismo: $('#mecanismos').val()
                    },
                    success: function(data) {
                        $('#tactividad').empty();
                        $.each(data, function(key, value) {
                            $('#tactividad').append(
                                `<option value="${value.tiac_codigo}">${value.tiac_nombre}</option>`
                            );
                        });
                    }
                });

            })
        }

        function seleccionarTerritorio() {
            var territorio = $('#territorio').val();

            if (territorio == 'nacional') {
                $('#regiones_div').show();
                $('#comunas_div').show();
                $.ajax({
                    url: window.location.origin + '/admin/iniciativas/obtener-pais',
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        _token: '{{ csrf_token() }}',
                        pais: territorio
                    },
                    success: function(data) {
                        $('#pais').empty();
                        // $('#pais').append('<option>Seleccione...</option>')
                        $.each(data, function(key, value) {
                            $('#pais').append(
                                `<option value="${value.pais_codigo}">${value.pais_nombre}</option>`
                            );
                        });
                    }
                });

            } else {
                $('#regiones_div').hide();
                $('#comunas_div').hide();
                $.ajax({
                    url: window.location.origin + '/admin/iniciativas/obtener-pais',
                    type: 'POST',
                    dataType: 'json',

                    data: {
                        _token: '{{ csrf_token() }}',
                        pais: territorio
                    },
                    success: function(data) {
                        $('#pais').empty();
                        // $('#pais').append('<option>Seleccione...</option>')
                        $.each(data, function(key, value) {
                            $('#pais').append(
                                `<option value="${value.pais_codigo}">${value.pais_nombre}</option>`
                            );
                        });
                    }
                });
            }
        }

        function comunasByRegiones() {
            $('#region').on('change', function() {
                var regionesId = $(this).val();
                if (regionesId) {
                    $.ajax({
                        url: window.location.origin + '/admin/iniciativas/obtener-comunas',
                        type: 'POST',
                        dataType: 'json',

                        data: {
                            _token: '{{ csrf_token() }}',
                            regiones: regionesId
                        },
                        success: function(data) {
                            $('#comuna').empty();
                            $.each(data, function(key, value) {
                                $('#comuna').append(
                                    `<option value="${value.comu_codigo}">${value.comu_nombre}</option>`
                                );
                            });
                        }
                    });
                }
            })
        }

        function carrerasByEscuelas() {
            const escuelasSelect = $("#escuelas");
            const carrerasSelect = $("#carreras");
            const carrerasOptions = {!! json_encode($carreras) !!};

            escuelasSelect.on("change", function() {
                const selectedEscuelas = escuelasSelect.val();

                const filteredCarreras = carrerasOptions.filter(carrera => selectedEscuelas.includes(carrera
                    .escu_codigo.toString()));

                carrerasSelect.empty();
                if (filteredCarreras.length > 0) {
                    $.each(filteredCarreras, function(index, carrera) {
                        carrerasSelect.append($("<option></option>").attr("value", carrera.care_codigo)
                            .text(carrera.care_nombre));
                    });
                } else {
                    carrerasSelect.append($("<option></option>").attr("value", "-1").text("No existen registros"));
                }
            });
        }
    </script>

@endsection
