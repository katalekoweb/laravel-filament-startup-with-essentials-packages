<div style=" display: flex; align-items: center; font-weight: 300; font-size: 12px">

    @auth
     <img src="{{ asset('images/logo.png') }}" style="width: 40px; margin-left: -10px; margin-right: 15px; border-radius: 5px" alt="">
        <div>
            <div>{{ request()->user()?->tenant?->name }}</div>
            <div>NIF: {{ request()->user()?->tenant?->doc }}</div>
        </div>
        @else
         <img src="{{ asset('images/logo.png') }}" style="width: 80px; border-radius: 15px; margin-bottom: 25px" alt="">
    @endauth
</div>
