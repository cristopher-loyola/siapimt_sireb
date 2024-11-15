@extends('plantillas/plantillaalt')
@section('contenido')
<title>Recursos de {{$proyt->nomproy}}</title>
        <div><h4 class="fw-bold text-center py-5" id="tituloform"> Recursos del proyecto
            	<td style='text-align:center;'>
	<?php
		if ($proyt->claven < 10) 
 			echo "<h3>$proyt->clavea$proyt->clavet-0$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
          	else 	echo "<h3>$proyt->clavea$proyt->clavet-$proyt->claven/$proyt->clavey | $proyt->nomproy</h3>";
	?>
	</td>
            <br>
        <div>
          <input type="text" name="tipo" id="tipo" value="{{ $proyt->clavet }}" hidden>
        <div>
          <a href="{{ route('infoproys', $proyt->id)}}">
                        <button type="submit" class="btn btn-dark btn-sm" id="redondb">
                        <i class='bx bxs-chevron-left-circle bx-sm bx-flashing-hover'></i>
                        Info. proyecto
            </button>
          </a>
        </div>
        <h3 class="fw-bold text-center py-5"> Recursos Financieros </h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproyf', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso Financiero
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($rescf as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalf}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3 class="fw-bold text-center py-5"> Recursos Materiales</h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproym', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso Material
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($rescm as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalm}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3 class="fw-bold text-center py-5"> Recursos Tecnológicos</h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproyt', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso Tecnológico
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($resct as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalt}}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <h3 class="fw-bold text-center py-5"> Recursos Humanos</h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproyh', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso Humano
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($resch as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalh}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <h3 class="fw-bold text-center py-5"> Otros Recursos</h3>
        <div class="mb-4">
          @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
          <a href="{{ route('addrecursosproyo', $proyt->id)}}">
            <button type="submit" class="btn btn-success" id="redondb">
                <i class='bx bx-plus-circle bx-fw bx-flashing-hover'>  </i>
                  Nuevo Recurso de Otros
            </button>
          </a>
          @endif
        </div>
        <div> 
            <table class="table table-hover">
                <thead>
                <tr>
                  <th scope="col" class="">No.</th>
                  <th scope="col" class="">Partida</th>
                  <th scope="col" class="">Concepto</th>
                  <th scope="col" class="">Cantidad</th>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <th scope="col" class="">Eliminar</th>
                  @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($resco as $r)
                <tr>
                  <td scope="row"></td>
                  <td>{{ $r->partida }}</td>
                  <td>{{ $r->concepto }}</td>
                  <td>${{ $r->cantidad }}</td>
                  @if ($proyt->estado == 1 || $proyt->estado == 0 || $proyt->estado == 4)
                  <td>
                    <form action="{{ route('destroyrecurso',[$proyt->id, $r->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" id="redondb">
                        <i class='bx bx-trash bx-fw bx-sm bx-flashing-hover'></i>
                      </button>
                    </form>
                  </td>
                  @endif
                </tr>
                @endforeach
                <tr>
                  <th></th>
                  <td></td>
                  <td>Subtotal</td>
                  <td>{{'$'.$subtotalo}}</td>
                </tr>
                </tbody>
            </table>
        </div>
      <h3 class="fw-bold text-center py-5"> Presupuesto Global </h3>
      <div> 
          <table class="table table-hover">
              <thead>
              <tr>
                <th scope="col" class="">Recursos</th>
                <th scope="col" class="">Cantidad</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td>Recurso Financiero</td>
                <td>{{'$'.$subtotalf}}</td>
              </tr>
              <tr>
                <td>Recurso Materiales</td>
                <td>{{'$'.$subtotalm}}</td>
              </tr>
              <tr>
                <td>Recurso Tecnológico</td>
                <td>{{'$'.$subtotalt}}</td>
              </tr>
              <tr>
                <td>Recurso Humanos</td>
                <td>{{'$'.$subtotalh}}</td>
              </tr>
              <tr>
                <td>Otros Recursos</td>
                <td>{{'$'.$subtotalo}}</td>
              </tr>
              <tr id="etotal">
                <th style="text-align: end">Total<i class='bx bxs-info-circle bx-tada-hover' 
                  title="*Nota: En la propuesta económicas de proyectos internos no se incluye I.V.A"
                  id="info"></i></th>
                <td >$ <input type="text" id="monto" name="monto" 
                  placeholder="Monto" style="border: hidden" value="{{round($total,2)}}" disabled></td></td>
              </tr>
              <tr id="itotal">
                <th style="text-align: end">Subtotal<i class='bx bxs-info-circle bx-tada-hover' 
                  title="*Nota: En la propuesta económicas de proyectos externos se incluye I.V.A"
                  id="info"></i>
                </th>
                <td>$ <input type="text" id="monto" name="monto" 
                  placeholder="Monto" style="border: hidden" value="{{round($total,2)}}" disabled></td>
              </tr>
              <tr id="miva">
                <th style="text-align: end">IVA %</th>
                <td>$ <input type="text" id="iva" name="iva" style="border: hidden"
                  placeholder="IVA" disabled></td>
              </tr>
              <tr id="final">
                <th style="text-align: end">Total</th>
                <td>$ <input type="text" id="total" name="total" style="border: hidden"
                placeholder="Total" disabled></td>
              </tr>
          </table>
      </div>
      <br>
      <div>
        <a href="{{ route('infoproys', $proyt->id)}}">
                        <button type="submit" class="btn btn-dark btn-sm" id="redondb">
                        <i class='bx bxs-chevron-left-circle bx-sm bx-flashing-hover'></i>
                        Info. proyecto
          </button>
        </a>
      </div>
    <div>
@stop
@push('scripts')
<script>
  getSelectValue = document.getElementById("tipo").value;
  if(getSelectValue=="E"){
    var tasa = 16;
    var monto = document.getElementById("monto").value;
    var iva = (monto*tasa)/100;
    var ivatotal = parseFloat(monto) + parseFloat(iva);
    ivatotal = Math.round(ivatotal);
    document.getElementById('iva').value=(iva=='') ? x : iva;
    document.getElementById('total').value=(ivatotal=='') ? x : ivatotal;
    document.getElementById("etotal").style="visibility:hidden;";
    document.getElementById("etotal2").style="visibility:hidden;";
  }else{
    document.getElementById("itotal").style="visibility:hidden;";
    document.getElementById("miva").style="visibility:hidden;";
    document.getElementById("final").style="visibility:hidden;";
  }
</script>    
@endpush