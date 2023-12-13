<?php include 'layouts/header.php' ?>

<main class="mb-10" id="content">
    <div class="px-4 sm:px-6 lg:px-8 mt-10 mx-auto max-w-7xl">
        <a href="/" class="mb-5 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Назад</a>
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Горничная "<?= $data->user->name ?? null ?>",
                    статистика за "<?= $data->day ?>"</h1>
            </div>
        </div>
        <div class="mt-4 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Номер (с указанием корпуса)
                                </th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Категория номера
                                </th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Тип уборки
                                </th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Начало уборки
                                </th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Конец уборки
                                </th>
                                <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                    Сумма за уборку
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            <?php foreach ($data->stats as $stat): ?>
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        <?= $stat->room_num ?> (<?= $stat->room_korpus ?>)
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?= $stat->room_type ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?= $stat->work_name ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?= $stat->clean_start ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?= $stat->clean_end ?>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <?= $stat->price ?> руб.
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <tfoot>
                            <tr>
                                <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Итого
                                </th>
                                <th colspan="5" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">
                                    <?= array_reduce($data->stats, function ($carry, $item) {
                                        return $carry + ($item->price ?? 0);
                                    }, 0) ?> руб.
                                </th>
                            </tr>
                            </tfoot>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <a href="/" class="mt-5 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Назад</a>
    </div>
</main>

<?php include 'layouts/footer.php' ?>
