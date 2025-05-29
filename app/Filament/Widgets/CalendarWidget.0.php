<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class CalendarWidget extends Widget
{
	/**
	 * Порядок вывода виджета (чем меньше — тем выше).
	 */
	protected static ?int $sort = 0;

	/**
	 * Если true — данные будут подгружаться лениво (ajax).
	 */
	protected static bool $isLazy = false;

	/**
	 * Blade-вид, который рендерит календарь.
	 *
	 * @var string
	 */
	protected static string $view = 'filament.widgets.calendar-widget';

	/**
	 * Данные для шаблона.
	 *
	 * @var array<string, mixed>
	 */
	public array $demoData = [];

	/**
	 * Загружаем демо-данные при инициализации.
	 */
	public function mount(): void
	{
		$this->demoData = static::getDemoData();
	}

	/**
	 * Генерирует демо-набор: месяцы, машины, статусы и суммы.
	 *
	 * @return array<string, mixed>
	 */
	public static function getDemoData(): array
	{
		$badgeKeys = ['О', 'П', 'Р', 'В'];

		$monthsConfig = [
			['name' => 'Січень',   'month' => 1, 'year' => 2025, 'days' => 31],
			['name' => 'Лютий',    'month' => 2, 'year' => 2025, 'days' => 28],
			['name' => 'Березень', 'month' => 3, 'year' => 2025, 'days' => 31],
			['name' => 'Квітень',  'month' => 4, 'year' => 2025, 'days' => 30],
			['name' => 'Травень',  'month' => 5, 'year' => 2025, 'days' => 27],
		];

		$machines = [
			'Leaf - AH1547OH',
			'Leaf - AX0428ZA',
			'Sonata - KA0788IB',
			'Sonata - KA8225HT',
			'Leaf - AX0431YA',
			'Sonata hybrid КА 2318 ІР',
		];

		$monthsData = [];
		foreach ($monthsConfig as $cfg) {
			$monthsData[] = array_merge($cfg, [
				'days' => range(1, $cfg['days']),
			]);
		}

		$data    = [];
		$rowSums = [];
		$colSums = [];

		foreach ($machines as $machine) {
			$rowSums[$machine] = [];

			foreach ($monthsData as $mi => $month) {
				foreach ($month['days'] as $day) {
					$status = $badgeKeys[array_rand($badgeKeys)];

					$data[$machine][$mi][$day] = $status;
					$rowSums[$machine][$mi][$status] = ($rowSums[$machine][$mi][$status] ?? 0) + 1;
					$colSums[$mi][$day][$status]    = ($colSums[$mi][$day][$status] ?? 0) + 1;
				}
			}
		}

		return [
			'months'   => $monthsData,
			'machines' => $machines,
			'data'     => $data,
			'rowSums'  => $rowSums,
			'colSums'  => $colSums,
		];
	}
}
