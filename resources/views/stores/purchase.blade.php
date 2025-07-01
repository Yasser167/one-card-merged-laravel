@extends('layouts.app')

@section('title_page', __('messages.purchase_info'))

@section('content')

<script>
    var cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length == 0) {
        location.replace(window.location.origin);
    }
</script>


<section>

    <div class="container my-5">

        <table class="table table_purchase_complete">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody class="cart-body"></tbody>

            <tfoot>
                <tr>
                    <td colspan="5">
                        <h4>@lang('messages.total'): <span class="btn btn-danger total">00.00</span> @lang('messages.currency')</h4>
                    </td>
                </tr>
            </tfoot>
        </table>


        <form method="POST" action="{{ route('purchase.complete.add') }}" class="form login" onsubmit="return disableButton()">
            @csrf

            <input type="hidden" name="cart_items" id="cart_items">

            <div class="mb-3">
                <label for="name" class="form-label">@lang('messages.name')</label>
                <input type="text" placeholder="@lang('messages.name')" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">@lang('messages.phone')</label>
                <input type="text" placeholder="@lang('messages.phone')" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="phone_2" class="form-label">@lang('messages.phone_2')</label>
                <input type="text" placeholder="@lang('messages.phone_2')" class="form-control" id="phone_2" name="phone_2">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">@lang('messages.address')</label>
                <input type="text" placeholder="@lang('messages.address')" class="form-control" id="address" name="address">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.submit_purchase')</button>
            </div>
        
<div class="mb-3">
    <label for="payment_method" class="form-label">اختر طريقة الدفع</label>
    <select name="payment_method" id="payment_method" class="form-control" onchange="toggleBankInfo(this.value)" required>
        <option value="">اختر طريقة الدفع</option>
        <option value="bank_transfer">💸 التحويل البنكي - One Card</option>
    </select>
</div>

<div id="bank_info" style="display: none; border: 1px solid #ccc; padding: 15px; margin-bottom: 20px; background-color: #f9f9f9;">
    <h5>معلومات التحويل:</h5>
    <p><strong>اسم المتجر:</strong> One Card</p>
    <p><strong>البنك:</strong> مصرف الراجحي</p>
    <p><strong>رقم الآيبان:</strong> SA42 8000 0506 6080 1075 4363</p>
    <p>بعد التحويل، يرجى إرسال صورة الإيصال على الواتساب أو البريد.</p>
</div>

<script>
    function toggleBankInfo(method) {
        var bankInfo = document.getElementById("bank_info");
        if (method === "bank_transfer") {
            bankInfo.style.display = "block";
        } else {
            bankInfo.style.display = "none";
        }
    }
</script>

</form>

    </div>


</section>

@endsection
