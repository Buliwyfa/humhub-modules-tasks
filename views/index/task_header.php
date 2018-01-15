<?php
use humhub\libs\Html;
use humhub\modules\task\widgets\TaskBadge;
use humhub\modules\task\widgets\TaskMenu;
use humhub\widgets\Button;
use humhub\widgets\TimeAgo;

/* @var $contentContainer \humhub\modules\content\components\ContentContainerActiveRecord */
/* @var $task \humhub\modules\task\models\Task */
/* @var $canEdit boolean */

$editUrl = $contentContainer->createUrl('edit', ['id' => $task->id]);
//$icon = !$task->isToday() && $task->isPast() ? 'fa-calendar-check-o' : 'fa-calendar-o';
$icon = 'fa-calendar-o';
$backUrl = $this->context->contentContainer->createUrl('/task/index');

?>
<div class="panel-heading clearfix">
    <div>
        <strong><i class="fa <?= $icon ?>"></i> <?= Html::encode($task->title); ?></strong>
    </div>

    <?= TaskMenu::widget(['task' => $task,
        'canEdit' => $canEdit,
        'contentContainer' => $contentContainer]); ?>

    <div class="row clearfix">
        <div class="col-sm-12 media">

            <h2 style="margin:5px 0 0 0;">
                <?= $task->getFormattedDeadline(); ?>
            </h2>
                <span class="author">
                    <?= Html::containerLink($task->content->createdBy); ?>
                </span>
            <?php if ( $task->content->updated_at !== null) : ?>
                &middot <span class="tt updated" title="<?= Yii::$app->formatter->asDateTime($task->content->updated_at); ?>"><?= Yii::t('ContentModule.base', 'Updated'); ?></span>
            <?php endif; ?>


            <?php $badge = TaskBadge::widget(['task' => $task])?>
            <?= (!empty($badge)) ? '<br>'.$badge : '' ?>

            <?php if($task->content->isPublic()) : ?>
                <span class="label label-info"><?= Yii::t('base', 'Public');?></span>
            <?php endif; ?>

            <?= Button::back($backUrl,  Yii::t('TaskModule.base', 'Back to overview'))->sm()->loader(true); ?>
        </div>
    </div>
</div>