@if(request()->session()->has('message'))
    <div class="card bg-light border-start border-lg rounded p-3 mb-3">
        <div class="card-header">{{ __('users.message') }}</div>
        <div class="card-body">
            <span class="text {{ request()->session()->get('message')['type'] }}">{{ request()->session()->get('message')['text'] }}</span>
        </div>
    </div>
@endif