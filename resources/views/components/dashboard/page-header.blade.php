@props([
    'title' => '',
    'description' => null,
])

<div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 pb-4 border-b border-slate-200">
    <div>
        <h1 class="admin-title">{{ $title }}</h1>
        @if($description)
            <p class="admin-subtitle">{{ $description }}</p>
        @endif
    </div>
    @if($slot->isNotEmpty())
        <div class="flex flex-wrap items-center gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
