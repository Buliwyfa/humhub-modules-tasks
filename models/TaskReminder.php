<?php
namespace humhub\modules\task\models;

use DateTime;
use humhub\components\ActiveRecord;
use Yii;
use humhub\modules\task\permissions\ManageTaskReminders;
use humhub\modules\user\models\User;

/**
 * This is the model class for table "task_reminder".
 *
 * The followings are the available columns in table 'task_reminder':
 * @property integer $id
 * @property integer $task_id
 * @property integer $remind_mode
 */
class TaskReminder extends ActiveRecord
{
    /**
     * @inheritdocs
     */
    protected $managePermission = ManageTaskReminders::class;

    /**
     * @inheritdocs
     */
    protected $streamChannel = null;

    /**
     * Remind Mode
     */
    const REMIND_NONE = 0;
    const REMIND_ONE_HOUR = 1;
    const REMIND_TWO_HOURS = 2;
    const REMIND_ONE_DAY = 3;
    const REMIND_TWO_DAYS = 4;
    const REMIND_ONE_WEEK = 5;
    const REMIND_TWO_WEEKS = 6;
    const REMIND_THREE_WEEKS = 7;
    const REMIND_ONE_MONTH = 8;

    /**
     * @var array all given remind modes as array
     */
    public static $remindModes = [
        self::REMIND_NONE,
        self::REMIND_ONE_HOUR,
        self::REMIND_TWO_HOURS,
        self::REMIND_ONE_DAY,
        self::REMIND_TWO_DAYS,
        self::REMIND_TWO_WEEKS,
        self::REMIND_THREE_WEEKS,
        self::REMIND_ONE_MONTH
    ];

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'task_reminder';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'remind_mode'], 'required'],
            [['task_id'], 'integer'],
            [['remind_mode'], 'in', 'range' => self::$remindModes],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return $scenarios;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => Yii::t('TaskModule.models_taskreminder', 'Task'),
            'remind_mode' => Yii::t('TaskModule.models_taskreminder', 'Remind Mode'),
        ];
    }

    public function getTask()
    {
        return $this->hasOne(Task::class, ['id' => 'task_id']);
    }

    public static function getRemindModeItems()
    {
        return [
            self::REMIND_NONE => Yii::t('TaskModule.models_taskreminder', 'Do not remind'),
            self::REMIND_ONE_HOUR => Yii::t('TaskModule.models_taskreminder', 'About 1 Hour before'),
            self::REMIND_TWO_HOURS => Yii::t('TaskModule.models_taskreminder', 'About 2 Hours before'),
            self::REMIND_ONE_DAY => Yii::t('TaskModule.models_taskreminder', '1 Day before'),
            self::REMIND_TWO_DAYS => Yii::t('TaskModule.models_taskreminder', '2 Days before'),
            self::REMIND_ONE_WEEK => Yii::t('TaskModule.models_taskreminder', '1 Week before'),
            self::REMIND_TWO_WEEKS => Yii::t('TaskModule.models_taskreminder', '2 Weeks before'),
            self::REMIND_THREE_WEEKS => Yii::t('TaskModule.models_taskreminder', '3 Weeks before'),
            self::REMIND_ONE_MONTH => Yii::t('TaskModule.models_taskreminder', '1 Month before'),
        ];
    }

    public function getRemindMode()
    {
        switch ($this->remind_mode){
            case (self::REMIND_NONE):
                return Yii::t('TaskModule.models_taskreminder', 'Do not remind');
                break;
            case (self::REMIND_ONE_HOUR):
                return Yii::t('TaskModule.models_taskreminder', 'About 1 Hour before');
                break;
            case (self::REMIND_TWO_HOURS):
                return Yii::t('TaskModule.models_taskreminder', 'About 2 Hours before');
                break;
            case (self::REMIND_ONE_DAY):
                return Yii::t('TaskModule.models_taskreminder', '1 Day before');
                break;
            case (self::REMIND_TWO_DAYS):
                return Yii::t('TaskModule.models_taskreminder', '2 Days before');
                break;
            case (self::REMIND_ONE_WEEK):
                return Yii::t('TaskModule.models_taskreminder', '1 Week before');
                break;
            case (self::REMIND_TWO_WEEKS):
                return Yii::t('TaskModule.models_taskreminder', '2 Weeks before');
                break;
            case (self::REMIND_THREE_WEEKS):
                return Yii::t('TaskModule.models_taskreminder', '3 Weeks before');
                break;
            case (self::REMIND_ONE_MONTH):
                return Yii::t('TaskModule.models_taskreminder', '1 Month before');
                break;
            default:
                return;
        }
    }
}