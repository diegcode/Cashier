@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h2 class="page-header">Entrada</h2>
                {{ Form::model($box, ['route'=>['incoming', $box], 'method'=>'put']) }}

                <p>
                    <div class="row">
                        <div class="col-md-6 col-xs-8">{{ Form::text('motive', null, ['class'=>'form-control input-sm col-md-6', 'placeholder'=>'Indique motivo', 'required'=>'']) }}</div>
                        <div class="col-md-6 col-xs-4 text-right">Fecha: {{ \Carbon\Carbon::now()->format('d/m/y') }}</div>
                    </div>
                </p>

                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Valor</th>
                        <th>Cantidad</th>
                        <th>SubTotal</th>
                    </tr>
                    @foreach($box->money as $money)
                        <tr class="money-row" data-value="{{ $money->value }}">
                            <td>{{ $money->name }}</td>
                            <td>{{ Form::number('money_id['.$money->id.']', null, ['class'=>'form-control input-sm quantity', 'step'=>'any']) }}</td>
                            <td data-subtotal="" class="subtotal"></td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="2">Total</th>
                        <th class="total"></th>
                    </tr>
                </table>

                {{ Form::submit('Confirmar entrada', ['class'=>'btn btn-success']) }}

                {{ Form::close() }}

            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $('.subtotal, .total').html('$' + 0);
        $('.quantity').keyup(function(){
            var row = $(this).parents('.money-row');
            var quantity = row.find('.quantity').val();
            var value = row.attr('data-value');
            var subtotal = row.find('.subtotal');
            if (quantity > 0) {
                subtotal.html('$' + quantity * value);
                subtotal.attr('data-subtotal', quantity * value);
                calculate();
            } else {
                subtotal.html('$' + 0);
                subtotal.attr('data-subtotal', quantity * value);
                calculate();
            }
        });

        function calculate() {
            var sum = 0;
            $('.subtotal').each(function() {
                sum += Number($(this).attr('data-subtotal'));
            });
            if (sum > 0) {
                $('.total').html('$' + sum);
            } else {
                $('.total').html('$' + 0);
            }
        }
    </script>
@stop