<form action = "{{ route('add.booking.payments') }}" method = "POST" id = "booking-payments-form">
    @if($booking->total_qoutation_amount <= 0)
        <span class = "text-danger">Still Qoute is not Accepted by Customer</span>
    @endif
    <input type = "hidden" name = "booking_id" value = "{{ $booking->id }}">  
    @csrf
    <div class="row">
        <div class="col-md-12" >
            <label class="form-label">Total Amount</label>
            <input type = "number" name = "total_amount" id = "total_amount" class = "form-control-plaintext" value = "{{$booking->grand_total ?? 0}}" readonly>
        </div>

        <div class="col-md-12" >
            <label class="form-label">Advance Payment</label>
            <input type = "number" name = "received_amount" id = "received_amount" class = "form-control-plaintext" value = "{{ $booking->total_received_amount ?? 0 }}" {{ $booking->grand_total <= 0?'readonly':'' }}>
            <span class = "text-danger" id = "validate-message" style = "display:none">Advance Payment Should not be greater than Total Amount</span>
        </div>

        <div class="col-md-12" >
            <label class="form-label">Balance Payment</label>
            <input type = "number" class = "form-control-plaintext" value = "{{ ($booking->grand_total - $booking->total_received_amount) }}"  readonly>
        </div>
    </div>

    <hr />
    
    </form>