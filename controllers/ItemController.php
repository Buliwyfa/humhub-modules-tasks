<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 *
 */

namespace humhub\modules\task\controllers;

use humhub\components\behaviors\AccessControl;
use humhub\modules\content\permissions\ManageContent;
use humhub\modules\file\libs\FileHelper;
use humhub\modules\task\models\forms\TaskItemForm;
use humhub\modules\task\models\ShiftTaskChoose;
use humhub\modules\task\permissions\ManageTasks;
use Yii;
use yii\helpers\Url;
use yii\web\HttpException;
use humhub\modules\content\components\ContentContainerController;
use humhub\modules\file\models\File;
use humhub\modules\content\models\Content;
use humhub\modules\task\models\Task;
use humhub\modules\task\models\TaskItem;

/**
 * Description of IndexController
 *
 * @author and1, luke
 */
class ItemController extends ContentContainerController
{
    /**
     * @inheritdoc
     */
    public $strictGuestMode = true;

    public function getAccessRules()
    {
        return [['permission' => ManageTasks::class]];
    }

    public function actionEdit($id = null, $taskId = null)
    {
        $item = null;

        if (!$id && !$taskId) {
            throw new HttpException(404);
        } else if (!$id) {
            $task = Task::find()->contentContainer($this->contentContainer)->where(['task.id' => $taskId])->one();
            if ($task) {
                $item = $task->newItem();
            }
        } else {
            $item = TaskItem::find()->contentContainer($this->contentContainer)->where(['task_item.id' => $id])->one();
        }

        if (!$item) {
            throw new HttpException(404);
        }

        $form = new TaskItemForm(['model' => $item]);

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            return $this->htmlRedirect($this->contentContainer->createUrl('/task/index/view', ['id' => $item->task_id]));
        }

        return $this->renderAjax("editItem", [
            'itemForm' => $form,
            'saveUrl' => $this->contentContainer->createUrl('/task/item/edit', ['taskId' => $taskId, 'id' => $item->id]),
            'deleteUrl' => $this->contentContainer->createUrl('/task/item/delete', ['id' => $item->id])
        ]);
    }

//    public function actionEditProtocol($id)
//    {
//        $item = TaskItem::find()->contentContainer($this->contentContainer)->where(['task_item.id' => $id])->one();
//        $item->scenario = 'editMinutes';
//
//        if ($item->load(Yii::$app->request->post()) && $item->save()) {
//            $item->fileManager->attach(Yii::$app->request->post('fileUploaderHiddenGuidField'));
//            return $this->htmlRedirect($this->contentContainer->createUrl('/task/index/view', ['id' => $item->task_id]));
//        }
//
//        return $this->renderAjax("editProtocol", ['item' => $item, 'taskId' => $item->task_id, 'contentContainer' => $this->contentContainer]);
//    }

    public function actionDelete($id)
    {
        $this->forcePostRequest();

        $item = TaskItem::find()->contentContainer($this->contentContainer)->where(['task_item.id' => $id])->one();
        $item->delete();

        return $this->htmlRedirect($this->contentContainer->createUrl('/task/index/view', ['id' => $item->task_id]));
    }
}