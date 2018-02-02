<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

/* @var $this \yii\web\View */
/* @var $item \humhub\modules\task\models\TaskItem */
/* @var $options array */

use humhub\libs\Html;

?>
<?= Html::beginTag('div', $options) ?>

<div class="task-item" id="item-<?= $item->id; ?>">

    <div class="row">
        <?php if (true) : ?>
            <div class="col-md-12" style="padding-right: 0;">
                <div class="checkbox">
                    <label>
                        <?= Html::checkBox('item[' . $item->id . ']', $item->completed, ['label' => $item->title, 'itemId' => $item->id, 'data-action-change' => 'confirm', 'data-action-submit']); ?>
                    </label>
                </div>
            </div>
        <?php endif; ?>
    </div>


</div>
<?= Html::endTag('div') ?>

<div class="clearFloats"></div>