@props([
    'title' => '',
    'description' => null,
])

<div class="bg-white border border-slate-200 shadow-sm px-6 py-5 border-l-4 border-l-[#C85A32] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-lg font-bold text-slate-900 uppercase tracking-wide">{{ $title }}</h1>
        @if($description)
            <p class="text-slate-400 text-sm mt-0.5">{{ $description }}</p>
        @endif
    </div>
    @if($slot->isNotEmpty())
        <div class="flex flex-wrap items-center gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
