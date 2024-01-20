@if (session('error'))
    <div class="text-center font-weight-bold bg-danger">
        {{ __('views.auth.errors_message') }}
        <br>
        {{ session('error') }}
    </div>
@endif