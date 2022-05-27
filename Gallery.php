<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\space\models;

use humhub\libs\ProfileImage;
use humhub\modules\content\components\ContentContainerSettingsManager;
use humhub\modules\search\interfaces\Searchable;
use humhub\modules\search\events\SearchAddEvent;
use humhub\modules\search\jobs\DeleteDocument;
use humhub\modules\search\jobs\UpdateDocument;
use humhub\modules\space\behaviors\SpaceModelMembership;
use humhub\modules\space\behaviors\SpaceController;
use humhub\modules\space\components\ActiveQuerySpace;
use humhub\modules\space\Module;
use humhub\modules\user\behaviors\Followable;
use humhub\components\behaviors\GUID;
use humhub\modules\content\components\behaviors\SettingsBehavior;
use humhub\modules\content\components\behaviors\CompatModuleManager;
use humhub\modules\space\permissions\CreatePrivateSpace;
use humhub\modules\space\permissions\CreatePublicSpace;
use humhub\modules\space\components\UrlValidator;
use humhub\modules\space\activities\Created;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\user\helpers\AuthHelper;
use humhub\modules\user\models\GroupSpace;
use humhub\modules\user\models\User;
use humhub\modules\user\models\Follow;
use humhub\modules\user\models\Invite;
use humhub\modules\space\widgets\Wall;
use humhub\modules\user\models\User as UserModel;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for table "space".
 *
 * @property integer $id
 * @property string $guid
 * @property string $name
 * @property string $description
 * @property string $about
 * @property string $url
 * @property integer $join_policy
 * @property integer $visibility
 * @property integer $status
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 * @property integer $auto_add_new_members
 * @property integer $contentcontainer_id
 * @property integer $default_content_visibility
 * @property string $color
 * @property User $ownerUser the owner of this space
 *
 * @mixin \humhub\components\behaviors\GUID
 * @mixin \humhub\modules\content\components\behaviors\SettingsBehavior
 * @mixin \humhub\modules\space\behaviors\SpaceModelMembership
 * @mixin \humhub\modules\user\behaviors\Followable
 * @mixin \humhub\modules\content\components\behaviors\CompatModuleManager
 */
class Gallery extends ContentContainerActiveRecord
{
public $imageFile;
public function rules() {
    return [
        [['upload'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
    ];
}
public function upload(){
    if($this->validate()) {
        $this->upload->saveAs('upload/'.$this->upload->baseName . '.' . $this->upload->extension);
        return true;
    } else {
        return false;
    }
}
    /**
     * @inheritdoc
     */
    public $controllerBehavior = SpaceController::class;

    /**
     * @inheritdoc
     */
    public $defaultRoute = '/space/gallery';  // init space/space

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery';
    }

    public function getDisplayName()
    {
        return $this->name;
    }

    public function getDisplayNameSub()
    {
        return $this->description;
    }

    public function getSettings(): ContentContainerSettingsManager
    {
        /* @var $module Module */
        $module = Yii::$app->getModule('space');
        return $module->settings->contentContainer($this);
    }

    /**
       * @inheritdoc$primaryKey
       */
      public static function primaryKey()
      {
          return ["img_id"];
      }
    /**
     * @inheritdoc
     */
    public function attributeLabel() {
        return ['upload'=>'Upload'];
    }
}