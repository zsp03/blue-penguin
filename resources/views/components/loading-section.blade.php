@php
    if ((! isset($columnSpan)) || (! is_array($columnSpan))) {
        $columnSpan = [
            'default' => $columnSpan ?? null,
        ];
    }

    if ((! isset($columnStart)) || (! is_array($columnStart))) {
        $columnStart = [
            'default' => $columnStart ?? null,
        ];
    }
@endphp

<x-filament::grid.column
    :default="$columnSpan['default'] ?? 1"
    :sm="$columnSpan['sm'] ?? null"
    :md="$columnSpan['md'] ?? null"
    :lg="$columnSpan['lg'] ?? null"
    :xl="$columnSpan['xl'] ?? null"
    :twoXl="$columnSpan['2xl'] ?? null"
    :defaultStart="$columnStart['default'] ?? null"
    :smStart="$columnStart['sm'] ?? null"
    :mdStart="$columnStart['md'] ?? null"
    :lgStart="$columnStart['lg'] ?? null"
    :xlStart="$columnStart['xl'] ?? null"
    :twoXlStart="$columnStart['2xl'] ?? null"
>
    <div
        class="flex items-center justify-center fi-card rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
    >
        <div
            class="flex h-16 w-16 items-center justify-center rounded-full bg-primary-50 text-primary-500 dark:bg-gray-700"
        >
            <x-filament::loading-indicator class="h-6 w-6" />
        </div>
    </div>
</x-filament::grid.column>
