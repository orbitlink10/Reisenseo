@if (session('success'))
    <div class="rsd-alert success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="rsd-alert error">{{ session('error') }}</div>
@endif

@if (session('warning'))
    <div class="rsd-alert warning">{{ session('warning') }}</div>
@endif

@if (session('info'))
    <div class="rsd-alert info">{{ session('info') }}</div>
@endif
