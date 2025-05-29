{{-- resources/views/filament/widgets/calendar-widget.blade.php --}}
<x-filament-widgets::widget class="fi-widget-calendar">
    <x-filament::section>
        @php
            ['months' => $months, 'machines' => $machines, 'data' => $data, 'rowSums' => $rowSums, 'colSums' => $colSums] = $demoData;

            $badgeColors = [
                'О' => 'success',
                'П' => 'warning',
                'Р' => 'danger',
                'В' => 'gray',
            ];
            $badgeLabels = [
                'О' => 'Оплата/Робочий',
                'П' => 'Простій',
                'Р' => 'Ремонт',
                'В' => 'Вихідний',
            ];
        @endphp

        {{-- Легенда --}}
        <div class="flex flex-wrap gap-4 mb-4">
            @foreach($badgeColors as $abbr => $color)
                <x-filament::badge :color="$color" size="sm">{{ $abbr }}</x-filament::badge>
                <span class="text-sm mr-4">{{ $badgeLabels[$abbr] }}</span>
            @endforeach
        </div>

        @foreach($months as $mi => $month)
            <div class="mb-8">
                <div class="font-semibold text-base mb-2 text-blue-800 dark:text-blue-300">
                    {{ $month['name'] }} {{ $month['year'] }}
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border rounded-xl text-center bg-white dark:bg-gray-900 shadow text-xs">
                        <thead>
                            <tr>
                                <th class="px-2 py-2 bg-gray-100 dark:bg-gray-800 border sticky left-0 z-10">Авто</th>
                                @foreach($month['days'] as $day)
                                    <th class="px-1 py-1 bg-gray-100 dark:bg-gray-800 border">{{ $day }}</th>
                                @endforeach
                                <th class="px-2 py-2 bg-blue-50 border sticky right-0 z-10">Σ по авто</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($machines as $machine)
                                <tr>
                                    <td class="font-medium border px-2 py-1 sticky left-0 bg-white dark:bg-gray-900 z-10 text-left" style="min-width:160px;">
                                        {{ $machine }}
                                    </td>
                                    @foreach($month['days'] as $day)
                                        @php
                                            $status = $data[$machine][$mi][$day];
                                            $color  = $badgeColors[$status];
                                            $label  = $badgeLabels[$status];
                                        @endphp
                                        <td class="border px-1 py-1">
                                            <x-filament::badge :color="$color" size="sm" :tooltip="$label">
                                                {{ $status }}
                                            </x-filament::badge>
                                        </td>
                                    @endforeach
                                    <td class="border px-1 py-1 bg-blue-50 sticky right-0 z-10">
                                        @foreach($badgeColors as $abbr => $color)
                                            <x-filament::badge :color="$color" size="sm" :tooltip="$badgeLabels[$abbr]">
                                                {{ $abbr }}: {{ $rowSums[$machine][$mi][$abbr] ?? 0 }}
                                            </x-filament::badge>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </x-filament::section>
</x-filament-widgets::widget>
