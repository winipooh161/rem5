<!-- filepath: c:\ospanel\domains\remont\resources\views\partner\calculator\pdf.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расчет строительных материалов</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            color: #007bff;
            font-size: 20px;
        }
        
        .header .company-info {
            margin-top: 10px;
            font-size: 11px;
            color: #666;
        }
        
        .calculation-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        
        .calculation-info div {
            flex: 1;
        }
        
        .materials-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .materials-table th,
        .materials-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        .materials-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        .materials-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .material-name {
            font-weight: bold;
            color: #333;
        }
        
        .number-cell {
            text-align: right;
        }
        
        .total-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }
        
        .total-row td {
            border-top: 2px solid #007bff;
        }
        
        .summary {
            margin-top: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        
        .summary h3 {
            margin: 0 0 10px 0;
            color: #28a745;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
            text-align: center;
        }
        
        .currency {
            font-weight: bold;
            color: #28a745;
        }
        
        .note {
            font-style: italic;
            color: #666;
            font-size: 10px;
            margin-top: 10px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Заголовок документа -->
    <div class="header">
        <h1>Расчет строительных материалов</h1>
        <div class="company-info">
            <?php echo e($company_name); ?><br>
            Калькулятор материалов для строительных и ремонтных работ
        </div>
    </div>

    <!-- Информация о расчете -->
    <div class="calculation-info">
        <div>
            <strong>Дата расчета:</strong> <?php echo e($calculation_date); ?>

        </div>
        <div>
            <strong>Составил:</strong> <?php echo e($user_name); ?>

        </div>
        <div>
            <strong>Всего позиций:</strong> <?php echo e(count($results)); ?>

        </div>
    </div>

    <!-- Таблица материалов -->
    <table class="materials-table">
        <thead>
            <tr>
                <th style="width: 5%;">№</th>
                <th style="width: 40%;">Наименование материала</th>
                <th style="width: 12%;">Объем</th>
                <th style="width: 10%;">Слой</th>
                <th style="width: 12%;">Расход</th>
                <th style="width: 10%;">Упаковок</th>
                <th style="width: 11%;">Стоимость</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="number-cell"><?php echo e($index + 1); ?></td>
                <td class="material-name"><?php echo e($result['material']['name']); ?></td>
                <td class="number-cell">
                    <?php echo e(number_format($result['volume'], 1, ',', ' ')); ?>

                    <?php echo e($result['material']['calculation_type'] === 'linear' ? 'м.п.' : 'м²'); ?>

                </td>
                <td class="number-cell">
                    <?php if(in_array($result['material']['calculation_type'], ['area_layer', 'linear_layer'])): ?>
                        <?php echo e(number_format($result['layer'], 1, ',', ' ')); ?>

                        <?php if($result['material']['id'] == 13 || $result['material']['id'] == 14): ?>
                            слоев
                        <?php else: ?>
                            мм
                        <?php endif; ?>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
                <td class="number-cell">
                    <?php echo e(number_format($result['consumption'], 1, ',', ' ')); ?> <?php echo e($result['unit']); ?>

                </td>
                <td class="number-cell">
                    <?php echo e($result['packages']); ?> <?php echo e($result['material']['package_unit']); ?>

                </td>
                <td class="number-cell currency">
                    <?php echo e(number_format($result['total_cost'], 0, ',', ' ')); ?> ₽
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <!-- Итоговая строка -->
            <tr class="total-row">
                <td colspan="6" style="text-align: right; font-weight: bold;">
                    <strong>ИТОГО:</strong>
                </td>
                <td class="number-cell currency">
                    <strong><?php echo e(number_format($total_cost, 0, ',', ' ')); ?> ₽</strong>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Сводка -->
    <div class="summary">
        <h3>Сводка по расчету</h3>
        <p>
            <strong>Общее количество материалов:</strong> <?php echo e(count($results)); ?> позиций<br>
            <strong>Общая стоимость материалов:</strong> <span class="currency"><?php echo e(number_format($total_cost, 0, ',', ' ')); ?> ₽</span><br>
            <strong>В стоимость включен запас:</strong> 10% от расчетного количества
        </p>
        
        <div class="note">
            * Указанные цены являются ориентировочными и могут отличаться от актуальных рыночных цен.<br>
            * Расчет выполнен на основе стандартных норм расхода материалов.<br>
            * Рекомендуется уточнить точную стоимость материалов у поставщиков.
        </div>
    </div>

    <!-- Детальная информация по категориям -->
    <?php
        $categories = [
            'Смеси и растворы' => [4, 6, 7, 10, 12, 24, 27],
            'Гипсокартон и профили' => [13, 14, 15, 16, 17, 18],
            'Крепеж' => [19, 20, 21, 25],
            'Изоляционные материалы' => [8, 9, 22, 23],
            'Прочие материалы' => [5, 11, 26]
        ];
        
        $categoryTotals = [];
        foreach($categories as $categoryName => $materialIds) {
            $categoryTotal = 0;
            foreach($results as $result) {
                if(in_array($result['material']['id'], $materialIds)) {
                    $categoryTotal += $result['total_cost'];
                }
            }
            if($categoryTotal > 0) {
                $categoryTotals[$categoryName] = $categoryTotal;
            }
        }
    ?>

    <?php if(!empty($categoryTotals)): ?>
    <div style="margin-top: 30px;">
        <h3>Распределение по категориям</h3>
        <table class="materials-table">
            <thead>
                <tr>
                    <th>Категория материалов</th>
                    <th style="width: 20%;">Стоимость</th>
                    <th style="width: 15%;">Доля в %</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $categoryTotals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $total): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($category); ?></td>
                    <td class="number-cell currency"><?php echo e(number_format($total, 0, ',', ' ')); ?> ₽</td>
                    <td class="number-cell"><?php echo e(number_format(($total / $total_cost) * 100, 1)); ?>%</td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <!-- Подвал документа -->
    <div class="footer">
        <p>
            Документ сформирован автоматически <?php echo e($calculation_date); ?><br>
            Система управления строительными проектами
        </p>
    </div>
</body>
</html><?php /**PATH C:\OSPanel\domains\remont\resources\views\partner\calculator\pdf.blade.php ENDPATH**/ ?>